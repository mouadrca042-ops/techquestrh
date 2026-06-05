<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Badge extends Model
{
    protected $fillable = [
        'titre', 'description', 'condition_type',
        'condition_valeur', 'image'
    ];

    /**
     * Attache le badge à l'utilisateur (avec la date d'obtention).
     */
    public function notifierObtention(User $user): void
    {
        $user->badges()->attach($this->id, [
            'obtenu_at' => now(),
        ]);
    }

    /**
     * Indique si l'utilisateur remplit la condition de ce badge,
     * d'après ses défis réussis (progressions complétées).
     */
    public function conditionRemplie(User $user): bool
    {
        // Base : tous les défis réussis (complétés) par l'utilisateur
        $defisReussis = Progression::where('user_id', $user->id)
            ->whereNotNull('completed_at');

        return match ($this->condition_type) {

            // 1er défi réussi
            'premier_defi' => (clone $defisReussis)->count() >= 1,

            // X défis réussis dans la semaine en cours
            'assidu' => (clone $defisReussis)
                ->where('completed_at', '>=', now()->startOfWeek())
                ->count() >= $this->condition_valeur,

            // X défis avec un score parfait (100 %)
            'maitrise' => Progression::where('user_id', $user->id)
                ->where('score', 100)
                ->count() >= $this->condition_valeur,

            // Au moins une formation entièrement terminée
            'explorateur' => Parcours::all()->contains(function ($parcours) use ($user) {
                $total = $parcours->defis()->count();
                if ($total === 0) {
                    return false;
                }
                $faits = Progression::where('user_id', $user->id)
                    ->whereNotNull('completed_at')
                    ->whereIn('defi_id', $parcours->defis()->pluck('id'))
                    ->count();
                return $faits >= $total;
            }),

            // Badge secret : X défis réussis au total
            'secret' => (clone $defisReussis)->count() >= $this->condition_valeur,

            default => false,
        };
    }

    /**
     * Parcourt tous les badges et attribue à l'utilisateur ceux qu'il mérite
     * et qu'il n'a pas encore. Renvoie la liste des badges nouvellement obtenus.
     */
    public static function attribuerSelonProgression(User $user): Collection
    {
        $dejaObtenus = $user->badges()->pluck('badge_id')->all();
        $nouveaux    = collect();

        foreach (self::all() as $badge) {
            if (in_array($badge->id, $dejaObtenus)) {
                continue; // déjà obtenu, on saute
            }

            if ($badge->conditionRemplie($user)) {
                $badge->notifierObtention($user);
                $nouveaux->push($badge);
            }
        }

        return $nouveaux;
    }

    // Relation
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges', 'badge_id', 'user_id')
                    ->withPivot('obtenu_at');
    }
}

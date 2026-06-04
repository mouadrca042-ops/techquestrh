<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Defi extends Model
{
    protected $fillable = [
        'parcours_id', 'titre', 'type',
        'niveau', 'ordre', 'xp_recompense', 'contenu_json'
    ];

    protected $casts = [
        'contenu_json' => 'array',
    ];

    public function donnerExplicationBienveillante(int $score): string
    {
        if ($score === 100) {
            return "Parfait ! Vous maîtrisez ce sujet, continuez comme ça !";
        } elseif ($score >= 50) {
            return "Bonne tentative ! Vous pouvez réessayer autant de fois que vous voulez !";
        } else {
            return "Ne vous découragez pas, chaque essai est un apprentissage !";
        }
    }

    /**
     * Message d'encouragement affiché quand le module n'est pas encore validé.
     * Le ton s'adapte au score, et un message est tiré au hasard pour varier.
     */
    public static function messageMotivant(int $score): string
    {
        if ($score >= 50) {
            // Proche de la réussite : on encourage à persévérer.
            $messages = [
                "Vous y êtes presque ! Relisez la leçon et retentez : la validation est à portée de main.",
                "Belle progression ! Encore un petit effort et ce module est validé.",
                "C'est tout proche ! Quelques points à revoir et vous décrochez ce module.",
                "Bonne tentative ! En reprenant les points manqués, vous allez y arriver.",
            ];
        } else {
            // Score bas : on dédramatise et on motive.
            $messages = [
                "Pas d'inquiétude : se tromper fait partie de l'apprentissage. Relisez la leçon et réessayez !",
                "Chaque tentative vous fait progresser. Reprenez la leçon à tête reposée, vous allez y arriver.",
                "Ne lâchez rien ! Les explications ci-dessous vous montrent exactement quoi revoir.",
                "L'erreur est le meilleur professeur. Un petit tour par la leçon et vous serez prêt à valider.",
            ];
        }

        return $messages[array_rand($messages)];
    }

    public function estVerrouille(int $userId): bool
    {
        $user = User::find($userId);
        if ($this->niveau === 'expert') {
            return $user->niveau === 'debutant' || $user->niveau === 'intermediaire';
        }
        if ($this->niveau === 'intermediaire') {
            return $user->niveau === 'debutant';
        }
        return false;
    }

    // Relations
    public function parcours(): BelongsTo
    {
        return $this->belongsTo(Parcours::class);
    }

    public function progressions(): HasMany
    {
        return $this->hasMany(Progression::class);
    }
}
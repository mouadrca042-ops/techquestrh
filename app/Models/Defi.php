<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Defi extends Model
{
    protected $fillable = [
        'parcours_id', 'titre', 'type',
        'niveau', 'xp_recompense', 'contenu_json'
    ];

    protected $casts = [
        'contenu_json' => 'array',
    ];

    public function verifierReponse($reponseDonnee): int
    {
    // On compare la réponse choisie par l'utilisateur avec la bonne réponse en BDD
    // Si c'est juste, on retourne 100%, sinon 0%
    if ($this->reponse_correcte === $reponseDonnee) {
        return 100;
    }

    return 0;
    }

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
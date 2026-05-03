<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $fillable = [
        'titre', 'description', 'condition_type',
        'condition_valeur', 'image'
    ];

    public function notifierObtention(User $user): void
    {
        // Attacher le badge à l'utilisateur
        $user->badges()->attach($this->id, [
            'obtenu_at' => now()
        ]);
    }

    // Relation
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withPivot('obtenu_at');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parcours extends Model
{
    protected $fillable = [
        'titre', 'description', 'outil', 'nb_defis_total'
    ];

    public function calculerProgressionGlobale(int $userId): int
    {
        $total = $this->nb_defis_total;
        if ($total === 0) return 0;
        $completes = Progression::where('user_id', $userId)
                                ->whereHas('defi', fn($q) => $q->where('parcours_id', $this->id))
                                ->where('score', '>', 0)
                                ->count();
        return (int) round(($completes / $total) * 100);
    }

    // Relations
    public function defis(): HasMany
    {
        return $this->hasMany(Defi::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parcours_user')
                    ->withPivot('xp_gagne', 'statut');
    }
}
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
        $totalDefis = $this->defis()->count();
        if ($totalDefis == 0) return 0;

        $defisTermines = \DB::table('progressions')
            ->join('defis', 'progressions.defi_id', '=', 'defis.id')
            ->where('defis.parcours_id', $this->id)
            ->where('progressions.user_id', $userId)
            ->where('progressions.score', '>=', 100) // Supposons que 100 est le score minimum pour valider un défi
            ->count();

        return round(($defisTermines / $totalDefis) * 100);
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
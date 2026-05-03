<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'poste', 'avatar',
        'xp_total', 'niveau',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isEmploye(): bool
    {
        return $this->role === 'employe';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function monterDeNiveau(): void
    {
        if ($this->xp_total >= 1000) {
            $this->niveau = 'expert';
        } elseif ($this->xp_total >= 500) {
            $this->niveau = 'intermediaire';
        } else {
            $this->niveau = 'debutant';
        }
        $this->save();
    }

    public function getProgressionParcours(int $parcoursId): int
    {
        $parcours = $this->parcours()->find($parcoursId);
        if (!$parcours) return 0;
        $total = $parcours->nb_defis_total;
        if ($total === 0) return 0;
        $completes = $this->progressions()
                          ->whereHas('defi', fn($q) => $q->where('parcours_id', $parcoursId))
                          ->where('score', '>', 0)
                          ->count();
        return (int) round(($completes / $total) * 100);
    }

    public function progressions(): HasMany
    {
        return $this->hasMany(Progression::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('obtenu_at');
    }

    public function parcours(): BelongsToMany
    {
        return $this->belongsToMany(Parcours::class, 'parcours_user')
                    ->withPivot('xp_gagne', 'statut');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progression extends Model
{
    protected $fillable = [
        'user_id', 'defi_id', 'score',
        'tentatives', 'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function enregistrerSansPenalite(int $score): void
    {
        $this->tentatives += 1;
        if ($score > $this->score) {
            $this->score = $score;
        }
        $this->completed_at = now();
        $this->save();
    }

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function defi(): BelongsTo
    {
        return $this->belongsTo(Defi::class);
    }
}
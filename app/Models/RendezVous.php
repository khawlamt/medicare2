<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date_heure',
        'statut',
        'motif',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    const STATUTS = ['planifie', 'confirme', 'annule', 'effectue'];

    // ── Relations ──────────────────────────────────────
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    // ── Scopes ─────────────────────────────────────────
    public function scopeToday($query)
    {
        return $query->whereDate('date_heure', today()->toDateString());
    }

    public function scopeTomorrow($query)
    {
        return $query->whereDate('date_heure', now()->addDay()->toDateString());
    }

    public function scopeActifs($query)
    {
        return $query->whereIn('statut', ['planifie', 'confirme']);
    }

    // ── Helpers ────────────────────────────────────────
    public function getBadgeClassAttribute(): string
    {
        return match($this->statut) {
            'planifie'  => 'warning',
            'confirme'  => 'success',
            'annule'    => 'danger',
            'effectue'  => 'secondary',
            default     => 'light',
        };
    }
}

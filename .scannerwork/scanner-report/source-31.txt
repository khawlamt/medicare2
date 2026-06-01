<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'groupe_sanguin',
        'telephone',
        'email',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // ── Relations ──────────────────────────────────────
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    // ── Accessors ──────────────────────────────────────
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getAgeAttribute(): int
    {
        return $this->date_naissance->age;
    }

    // ── Scopes ─────────────────────────────────────────
    public function scopeAvecRendezVousAujourdhui($query)
    {
        return $query->whereHas('rendezVous', fn($q) =>
            $q->whereDate('date', today())
        );
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('nom', 'like', "%$term%")
                     ->orWhere('prenom', 'like', "%$term%")
                     ->orWhere('email', 'like', "%$term%");
    }
}

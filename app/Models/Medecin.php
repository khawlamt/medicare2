<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'specialite',
        'email',
        'telephone',
    ];

    // ── Relations ──────────────────────────────────────
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    // ── Accessors ──────────────────────────────────────
    public function getNomCompletAttribute(): string
    {
        return 'Dr. ' . $this->prenom . ' ' . $this->nom;
    }

    // ── Scopes ─────────────────────────────────────────
    public function scopeSearch($query, string $term)
    {
        return $query->where('nom', 'like', "%$term%")
                     ->orWhere('prenom', 'like', "%$term%")
                     ->orWhere('specialite', 'like', "%$term%");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ville',
        'gouvernorat',
        'adresse',
        'telephone',
        'email',
        'latitude',
        'longitude',
        'description',
        'type',
        'urgence',
        'maternite',
        'chirurgie',
    ];

    protected $casts = [
        'urgence' => 'boolean',
        'maternite' => 'boolean',
        'chirurgie' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // ── Scopes ─────────────────────────────────────────
    public function scopeSearch($query, string $term)
    {
        return $query->where('nom', 'like', "%$term%")
                     ->orWhere('ville', 'like', "%$term%")
                     ->orWhere('gouvernorat', 'like', "%$term%");
    }

    public function scopeByGovernorate($query, string $gouvernorat)
    {
        return $query->where('gouvernorat', $gouvernorat);
    }

    public function scopeWithUrgence($query)
    {
        return $query->where('urgence', true);
    }

    public function scopePublic($query)
    {
        return $query->where('type', 'public');
    }

    public function scopePrivate($query)
    {
        return $query->where('type', 'prive');
    }

    // ── Helpers ────────────────────────────────────────
    public function getServicesAttribute(): string
    {
        $services = [];
        if ($this->urgence) $services[] = 'Urgence';
        if ($this->maternite) $services[] = 'Maternité';
        if ($this->chirurgie) $services[] = 'Chirurgie';
        return count($services) ? implode(', ', $services) : 'Consultation générale';
    }
}

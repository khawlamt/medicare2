<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'stock',
        'seuil_alerte',
        'prix',
    ];

    // ── Scopes ─────────────────────────────────────────

    public function scopeFaibleStock($query)
    {
        return $query->whereColumn('stock', '<=', 'seuil_alerte');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('nom', 'like', "%$term%");
    }

    // ── Helpers ────────────────────────────────────────

    public function getStockStatusAttribute(): string
    {
        if ($this->stock === 0) {
            return 'Rupture de stock';
        }

        if ($this->stock <= $this->seuil_alerte) {
            return 'Stock faible';
        }

        return 'Disponible';
    }

    public function getStockBadgeAttribute(): string
    {
        if ($this->stock === 0) {
            return 'danger';
        }

        if ($this->stock <= $this->seuil_alerte) {
            return 'warning';
        }

        return 'success';
    }
}

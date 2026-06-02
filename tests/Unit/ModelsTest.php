<?php

namespace Tests\Unit;

use App\Models\Medecin;
use App\Models\Medicament;
use App\Models\Patient;
use App\Models\RendezVous;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    public function test_patient_accessors_return_correct_full_name_and_age()
    {
        $patient = Patient::make([
            'nom' => 'Durand',
            'prenom' => 'Alice',
            'date_naissance' => now()->subYears(25)->toDateString(),
        ]);

        $this->assertSame('Alice Durand', $patient->nom_complet);
        $this->assertSame(25, $patient->age);
    }

    public function test_medecin_nom_complet_prefixe_docteur()
    {
        $medecin = Medecin::make([
            'nom' => 'Leroy',
            'prenom' => 'Sophie',
        ]);

        $this->assertSame('Dr. Sophie Leroy', $medecin->nom_complet);
    }

    public function test_medicament_stock_status_and_badge_classes()
    {
        $rupture = Medicament::make(['stock' => 0, 'seuil_alerte' => 5]);
        $faible = Medicament::make(['stock' => 3, 'seuil_alerte' => 5]);
        $ok = Medicament::make(['stock' => 10, 'seuil_alerte' => 5]);

        $this->assertSame('Rupture de stock', $rupture->stock_status);
        $this->assertSame('danger', $rupture->stock_badge);

        $this->assertSame('Stock faible', $faible->stock_status);
        $this->assertSame('warning', $faible->stock_badge);

        $this->assertSame('Disponible', $ok->stock_status);
        $this->assertSame('success', $ok->stock_badge);
    }

    public function test_rendezvous_badge_class_covers_all_statuts()
    {
        $values = [
            'planifie' => 'warning',
            'confirme' => 'success',
            'annule' => 'danger',
            'effectue' => 'secondary',
            'autre' => 'light',
        ];

        foreach ($values as $statut => $badge) {
            $rendezVous = RendezVous::make(['statut' => $statut]);
            $this->assertSame($badge, $rendezVous->badge_class);
        }
    }
}

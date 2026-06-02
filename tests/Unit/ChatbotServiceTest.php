<?php

namespace Tests\Unit;

use App\Models\Medecin;
use App\Models\Medicament;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Services\ChatbotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_construire_prompt_inclut_les_donnees_et_la_question()
    {
        $service = new ChatbotService();
        $data = [
            'patients_total' => 2,
            'medicaments_total' => 1,
        ];

        $prompt = $service->construirePrompt('Quel est le bilan ?', $data);

        $this->assertStringContainsString('Tu es l\'assistant intelligent de MediCare', $prompt);
        $this->assertStringContainsString('=== DONNÉES ACTUELLES DE LA BASE DE DONNÉES ===', $prompt);
        $this->assertStringContainsString('"patients_total": 2', $prompt);
        $this->assertStringContainsString('=== QUESTION DE L\'UTILISATEUR ===', $prompt);
        $this->assertStringContainsString('Quel est le bilan ?', $prompt);
    }

    public function test_recuperer_contexte_retourne_toutes_les_sections_requises()
    {
        $patient = Patient::forceCreate([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'date_naissance' => now()->subYears(30)->toDateString(),
            'groupe_sanguin' => 'A+',
            'sexe' => 'M',
            'telephone' => '0102030405',
            'email' => 'jean.dupont@example.com',
        ]);

        $medecin = Medecin::create([
            'nom' => 'Martin',
            'prenom' => 'Claire',
            'specialite' => 'Cardiologie',
            'email' => 'claire.martin@example.com',
            'telephone' => '0607080910',
        ]);

        Medicament::create([
            'nom' => 'Aspirine',
            'stock' => 2,
            'seuil_alerte' => 5,
            'prix' => 3.5,
        ]);

        Medicament::create([
            'nom' => 'Paracétamol',
            'stock' => 0,
            'seuil_alerte' => 10,
            'prix' => 1.2,
        ]);

        RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->setTime(9, 0),
            'statut' => 'planifie',
            'motif' => 'Consultation',
        ]);

        RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->addDay()->setTime(11, 0),
            'statut' => 'confirme',
            'motif' => 'Suivi',
        ]);

        $service = new ChatbotService();

        $question = 'Donne-moi le bilan des patients, médecins, rendez-vous aujourd\'hui, demain, médicaments et statistique.';
        $contexte = $service->recupererContexte($question);

        $this->assertSame(1, $contexte['patients_total']);
        $this->assertSame(1, $contexte['medecins_total']);
        $this->assertSame(2, $contexte['medicaments_total']);
        $this->assertCount(1, $contexte['rdv_aujourd_hui']);
        $this->assertCount(1, $contexte['rdv_demain']);
        $this->assertSame(1, $contexte['resume_global']['total_patients']);
        $this->assertSame(1, $contexte['resume_global']['total_medecins']);
        $this->assertSame(2, $contexte['resume_global']['total_rdv']);
        $this->assertSame(1, $contexte['resume_global']['rdv_aujourd_hui']);
        $this->assertSame(2, $contexte['resume_global']['alertes_stock']);
    }
}

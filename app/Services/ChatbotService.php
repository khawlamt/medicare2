<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Medicament;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class ChatbotService
{
    /**
     * Point d'entrée principal : reçoit la question + historique,
     * retourne la réponse de l'IA.
     */
    public function repondre(string $question, array $historique = []): string
    {
        // Étape 1 : récupérer les données métier pertinentes
        $contexte = $this->recupererContexte($question);

        // Étape 2 : construire le prompt enrichi
        $prompt = $this->construirePrompt($question, $contexte);

        // Étape 3 : appel à l'API Gemini
        return $this->appelerGemini($prompt, $historique);
    }

    // ──────────────────────────────────────────────────────────────
    // Récupération des données depuis la BDD selon la question
    // ──────────────────────────────────────────────────────────────
    public function recupererContexte(string $question): array
    {
        $q    = mb_strtolower($question);
        $data = [];

        // --- Patients ---
        if (str_contains($q, 'patient')) {
            $data['patients_total']  = Patient::count();
            $data['patients_recents'] = Patient::latest()
                ->take(5)
                ->get(['id', 'nom', 'prenom', 'groupe_sanguin', 'date_naissance'])
                ->map(fn($p) => [
                    'id'             => $p->id,
                    'nom_complet'    => $p->nom_complet,
                    'groupe_sanguin' => $p->groupe_sanguin,
                    'age'            => $p->age,
                ])->toArray();
        }

        // --- Médecins ---
        if (str_contains($q, 'médecin') || str_contains($q, 'medecin') || str_contains($q, 'docteur')) {
            $data['medecins'] = Medecin::all(['id', 'nom', 'prenom', 'specialite'])
                ->map(fn($m) => [
                    'id'         => $m->id,
                    'nom_complet'=> $m->nom_complet,
                    'specialite' => $m->specialite,
                ])->toArray();
            $data['medecins_total'] = Medecin::count();
        }

        // --- Rendez-vous aujourd'hui ---
        if (str_contains($q, 'aujourd') || str_contains($q, 'aujoud')) {
            $data['rdv_aujourd_hui'] = RendezVous::with(['patient', 'medecin'])
                ->today()
                ->orderBy('date_heure')
                ->get()
                ->map(fn($r) => [
                    'heure'   => $r->date_heure->format('H:i'),
                    'patient' => $r->patient->nom_complet,
                    'medecin' => $r->medecin->nom_complet,
                    'statut'  => $r->statut,
                    'motif'   => $r->motif,
                ])->toArray();
        }

        // --- Rendez-vous demain ---
        if (str_contains($q, 'demain')) {
            $data['rdv_demain'] = RendezVous::with(['patient', 'medecin'])
                ->tomorrow()
                ->orderBy('date_heure')
                ->get()
                ->map(fn($r) => [
                    'heure'   => $r->date_heure->format('H:i'),
                    'patient' => $r->patient->nom_complet,
                    'medecin' => $r->medecin->nom_complet,
                    'statut'  => $r->statut,
                    'motif'   => $r->motif,
                ])->toArray();
        }

        // --- Rendez-vous en général ---
        if (str_contains($q, 'rendez') || str_contains($q, 'rdv') || str_contains($q, 'consultation')) {
            $data['rdv_total']    = RendezVous::count();
            $data['rdv_planifies']= RendezVous::where('statut', 'planifie')->count();
            $data['rdv_confirmes']= RendezVous::where('statut', 'confirme')->count();
            $data['rdv_annules']  = RendezVous::where('statut', 'annule')->count();
            $data['rdv_effectues']= RendezVous::where('statut', 'effectue')->count();
        }

        // --- Médicaments ---
        if (str_contains($q, 'médicament') || str_contains($q, 'medicament') ||
            str_contains($q, 'stock') || str_contains($q, 'pharmacie')) {
            $data['medicaments_total']        = Medicament::count();
            $data['medicaments_faible_stock'] = Medicament::faibleStock()
                ->get(['nom', 'stock', 'seuil_alerte'])
                ->toArray();
            $data['medicaments_rupture']      = Medicament::where('stock', 0)->count();
        }

        // --- Statistiques globales ---
        if (str_contains($q, 'statistique') || str_contains($q, 'bilan') ||
            str_contains($q, 'résumé') || str_contains($q, 'resume') ||
            str_contains($q, 'tableau de bord') || str_contains($q, 'combien')) {
            $data['resume_global'] = [
                'total_patients'  => Patient::count(),
                'total_medecins'  => Medecin::count(),
                'total_rdv'       => RendezVous::count(),
                'rdv_aujourd_hui' => RendezVous::today()->count(),
                'alertes_stock'   => Medicament::faibleStock()->count(),
            ];
        }

        return $data;
    }

    // ──────────────────────────────────────────────────────────────
    // Construction du prompt intelligent
    // ──────────────────────────────────────────────────────────────
    public function construirePrompt(string $question, array $data): string
    {
        $dataJson  = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $dateAujourd = now()->translatedFormat('l d F Y');

        return <<<PROMPT
Tu es l'assistant intelligent de MediCare, une application de gestion hospitalière.
Aujourd'hui nous sommes le {$dateAujourd}.

RÈGLES IMPORTANTES :
- Réponds UNIQUEMENT à partir des données fournies ci-dessous.
- Ne fabrique JAMAIS d'informations qui ne sont pas dans les données.
- Si une information n'est pas disponible dans les données, dis-le clairement.
- Réponds toujours en français, de façon professionnelle et concise.
- Pour les listes, utilise des puces claires.
- Ne mentionne pas que tu utilises un prompt ou des données JSON.

=== DONNÉES ACTUELLES DE LA BASE DE DONNÉES ===
{$dataJson}

=== QUESTION DE L'UTILISATEUR ===
{$question}

Réponds maintenant de façon claire et utile :
PROMPT;
    }
// ──────────────────────────────────────────────────────────────
    // Appel à l'API Google Gemini
    // ──────────────────────────────────────────────────────────────

    private function appelerGemini(string $prompt, array $historique): string
    {
        $apiKey = config('services.groq.key');
        $apiUrl = config('services.groq.url');

        $messages = [];

        // Historique conversation
        foreach ($historique as $msg) {
            $role = $msg['role'] === 'model' ? 'assistant' : $msg['role'];

            $messages[] = [
                'role' => $role,
                'content' => $msg['content'],
            ];
        }

        // Compléter ici avec l'envoi de la requête à l'API (ex: $response = Http::...)
        // En supposant que le bloc try englobe l'appel API et le traitement du résultat :
        try {
            // [Logique de votre requête HTTP et assignation de $result ici]

            return $result['choices'][0]['message']['content']
                ?? 'Je n\'ai pas pu générer une réponse.';
        } catch (ConnectException $e) {
            return '⚠️ Service IA indisponible.';
        } catch (RequestException $e) {
            return $this->handleRequestException($e);
        } catch (\Exception $e) {
            return '⚠️ Erreur inattendue.';
        }
    }

    /**
     * Helper pour isoler la complexité de la RequestException
     */
    private function handleRequestException(RequestException $e): string
    {
        $code = $e->hasResponse() ? $e->getResponse()->getStatusCode() : '?';

        if ($code == 429) {
            return '⚠️ Limite API atteinte.';
        }

        if ($code == 401) {
            return '⚠️ API Key invalide.';
        }

        if ($code == 400) {
            return '⚠️ Requête invalide.';
        }

        return $e->hasResponse()
            ? $e->getResponse()->getBody()->getContents()
            : $e->getMessage();
    }
}

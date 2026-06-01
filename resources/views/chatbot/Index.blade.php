@extends('layouts.app')
@section('title', 'Chatbot IA — MediCare')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-robot text-primary me-2"></i>Assistant MediCare IA
    </h4>
    <a href="{{ route('chatbot.effacer') }}" class="btn btn-sm btn-outline-secondary"
       onclick="return confirm('Effacer tout l\'historique ?')">
        <i class="bi bi-trash me-1"></i> Effacer historique
    </a>
</div>

{{-- Info box --}}
<div class="alert alert-info alert-dismissible fade show py-2" role="alert">
    <i class="bi bi-lightbulb me-2"></i>
    <strong>Exemples :</strong>
    "Combien de patients avons-nous ?" · "Quels rendez-vous sont prévus demain ?" · "Affiche les médicaments en stock faible"
    <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
</div>

{{-- Zone de chat --}}
<div class="card" style="height:520px; display:flex; flex-direction:column;">
    <div class="card-header bg-white d-flex align-items-center gap-2 py-2">
        <span class="bg-success rounded-circle" style="width:10px;height:10px;display:inline-block"></span>
        <span class="small fw-semibold">Assistant en ligne</span>
    </div>

    {{-- Messages --}}
    <div id="chat-box"
         class="flex-fill p-3 overflow-auto"
         style="background:#f8fafc;">

        {{-- Message de bienvenue --}}
        <div class="d-flex gap-2 mb-3">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:36px;height:36px;">
                <i class="bi bi-robot text-white"></i>
            </div>
            <div class="bg-white rounded p-3 shadow-sm" style="max-width:80%">
                <p class="mb-0 small">
                    Bonjour ! Je suis l'assistant intelligent de <strong>MediCare</strong>.
                    Je peux vous aider à consulter les données de votre application :
                    patients, médecins, rendez-vous et médicaments.
                    Comment puis-je vous aider ?
                </p>
            </div>
        </div>

        {{-- Historique chargé depuis la BDD --}}
        @foreach($historique as $msg)
            {{-- Question utilisateur --}}
            <div class="d-flex gap-2 mb-2 justify-content-end">
                <div class="bg-primary text-white rounded p-3 shadow-sm" style="max-width:80%">
                    <p class="mb-0 small">{{ $msg->question }}</p>
                </div>
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:36px;height:36px;">
                    <i class="bi bi-person text-white"></i>
                </div>
            </div>
            {{-- Réponse IA --}}
            <div class="d-flex gap-2 mb-3">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:36px;height:36px;">
                    <i class="bi bi-robot text-white"></i>
                </div>
                <div class="bg-white rounded p-3 shadow-sm" style="max-width:80%">
                    <p class="mb-0 small" style="white-space:pre-line">{{ $msg->reponse }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Zone de saisie --}}
    <div class="card-footer bg-white p-3">
        <div id="typing-indicator" class="text-muted small mb-2 d-none">
            <span class="spinner-border spinner-border-sm me-1"></span>
            L'assistant rédige une réponse...
        </div>
        <div class="d-flex gap-2">
            <input type="text" id="message-input"
                   class="form-control"
                   placeholder="Posez votre question en langage naturel..."
                   autocomplete="off">
            <button id="send-btn" class="btn btn-primary px-4">
                <i class="bi bi-send"></i>
            </button>
        </div>

        {{-- Suggestions rapides --}}
        <div class="mt-2 d-flex flex-wrap gap-1">
            <button class="btn btn-sm btn-outline-secondary suggestion-btn">
                Nombre de patients
            </button>
            <button class="btn btn-sm btn-outline-secondary suggestion-btn">
                RDV de demain
            </button>
            <button class="btn btn-sm btn-outline-secondary suggestion-btn">
                Stock faible médicaments
            </button>
            <button class="btn btn-sm btn-outline-secondary suggestion-btn">
                Liste des médecins
            </button>
        </div>
    </div>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
const chatBox   = document.getElementById('chat-box');
const input     = document.getElementById('message-input');
const sendBtn   = document.getElementById('send-btn');
const typing    = document.getElementById('typing-indicator');
const csrfToken = '{{ csrf_token() }}';

// Scroll vers le bas au chargement
chatBox.scrollTop = chatBox.scrollHeight;

// Suggestions rapides
document.querySelectorAll('.suggestion-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        input.value = btn.textContent.trim();
        input.focus();
    });
});

// Envoi via bouton ou Entrée
sendBtn.addEventListener('click', envoyerMessage);
input.addEventListener('keydown', e => { if (e.key === 'Enter') envoyerMessage(); });

async function envoyerMessage() {
    const message = input.value.trim();
    if (!message) return;

    // Afficher la question
    ajouterMessage(message, 'user');
    input.value = '';
    sendBtn.disabled = true;
    typing.classList.remove('d-none');
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const res = await fetch('{{ route("chatbot.envoyer") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message })
        });

        // Vérifier si la réponse HTTP est OK
        if (!res.ok) {
            const errText = await res.text();
            console.error('Erreur HTTP:', res.status, errText);
            ajouterMessageErreur('Erreur serveur (' + res.status + '). Vérifiez les logs Laravel.');
            return;
        }

        const data = await res.json();
        console.log('Réponse reçue:', data); // Debug dans la console

        // Vérifier que reply existe
        if (data && data.reply !== undefined) {
            ajouterMessage(data.reply, 'bot');
        } else {
            console.error('Clé reply manquante dans:', data);
            ajouterMessageErreur('Réponse invalide du serveur. Voir console pour détails.');
        }

    } catch (err) {
        console.error('Erreur fetch:', err);
        ajouterMessageErreur('Erreur de connexion : ' + err.message);
    } finally {
        typing.classList.add('d-none');
        sendBtn.disabled = false;
        chatBox.scrollTop = chatBox.scrollHeight;
        input.focus();
    }
}

function ajouterMessage(texte, role) {
    if (role === 'user') {
        chatBox.innerHTML += `
            <div class="d-flex gap-2 mb-2 justify-content-end">
                <div class="bg-primary text-white rounded p-3 shadow-sm" style="max-width:80%">
                    <p class="mb-0 small">${escapeHtml(texte)}</p>
                </div>
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:36px;height:36px;">
                    <i class="bi bi-person text-white"></i>
                </div>
            </div>`;
    } else {
        chatBox.innerHTML += `
            <div class="d-flex gap-2 mb-3">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:36px;height:36px;">
                    <i class="bi bi-robot text-white"></i>
                </div>
                <div class="bg-white rounded p-3 shadow-sm" style="max-width:80%">
                    <p class="mb-0 small" style="white-space:pre-line">${escapeHtml(texte)}</p>
                </div>
            </div>`;
    }
}

function ajouterMessageErreur(texte) {
    chatBox.innerHTML += `
        <div class="d-flex gap-2 mb-3">
            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:36px;height:36px;">
                <i class="bi bi-exclamation text-white"></i>
            </div>
            <div class="bg-white rounded p-3 shadow-sm border border-danger" style="max-width:80%">
                <p class="mb-0 small text-danger">${escapeHtml(texte)}</p>
            </div>
        </div>`;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(text));
    return div.innerHTML;
}
</script>
@endpush

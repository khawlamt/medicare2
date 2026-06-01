<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(private ChatbotService $chatbotService) {}

    public function index()
    {
        $historique = ChatMessage::where('user_id', auth()->id())
            ->latest()
            ->take(30)
            ->get()
            ->reverse()
            ->values();

        return view('chatbot.index', compact('historique'));
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            // Récupérer l'historique de session (pour le contexte IA)
            $historique = session('chat_historique', []);

            // Appel au service chatbot
            $reponse = $this->chatbotService->repondre($request->message, $historique);

            // Sauvegarder en base de données
            ChatMessage::create([
                'user_id' => auth()->id(),
                'message' => $request->message,
                'response' => $reponse,
            ]);

            // Mettre à jour l'historique session (max 20 messages)
            $historique[] = ['role' => 'user',  'content' => $request->message];
            $historique[] = ['role' => 'model', 'content' => $reponse];
            session(['chat_historique' => array_slice($historique, -20)]);

            return response()->json(['reply' => $reponse]);

        } catch (\Exception $e) {
            // Log l'erreur pour le debug
            \Log::error('Chatbot error: ' . $e->getMessage());

            return response()->json([
                'reply' => '⚠️ Erreur : ' . $e->getMessage()
            ], 200); // 200 pour que le JS puisse lire la réponse
        }
    }

    public function effacerHistorique()
    {
        session()->forget('chat_historique');

        return redirect()->route('chatbot.index')
            ->with('success', 'Historique effacé.');
    }
}

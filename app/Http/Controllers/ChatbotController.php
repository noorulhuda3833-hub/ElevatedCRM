<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicket;
use App\Models\Task;
use App\Models\Activity;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $user    = Auth::user();
        $message = $request->message;

        // ── STEP 1: RETRIEVE relevant data from CRM database ──────────
        $context = $this->retrieveContext($user, $message);

        // ── STEP 2: BUILD system prompt with retrieved data ────────────
        $systemPrompt = $this->buildSystemPrompt($user, $context);

        // ── STEP 3: GENERATE answer using Groq AI ─────────────────────
        $apiKey = env('GROQ_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'openai/gpt-oss-20b',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $message],
            ],
            'max_tokens'  => 400,
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            return response()->json([
                'reply' => 'Sorry, I am unable to respond right now. Please try again later.'
            ]);
        }

        $reply = $response->json('choices.0.message.content');

        return response()->json([
            'reply' => $reply ? trim($reply) : 'Sorry, I could not generate a response.'
        ]);
    }

    // ── PUBLIC CHATBOT — No login required ─────────────────────────
public function guestReply(Request $request)
{
    $request->validate([
        'message' => ['required', 'string', 'max:500'],
    ]);

    $systemPrompt = "You are a friendly customer support assistant for ElevatedCRM.
    ElevatedCRM is a powerful CRM web application that helps businesses manage:
    - Customer relationships and profiles
    - Support tickets and issue tracking
    - Daily activities
    - Personal tasks and deadlines
    - Reports and analytics dashboards

    You help website visitors with:
    - Questions about what ElevatedCRM does
    - How to register or create an account
    - What features are available
    - How to contact support
    - General pricing and plan questions
    - How to get started with the CRM

    If someone asks about personal data such as tickets or tasks,
    tell them they need to log in to access their personal information.

    Keep answers friendly, concise, and helpful.";

    $apiKey = env('GROQ_API_KEY');

    // Check that Laravel can read the API key
    if (!$apiKey) {
        return response()->json([
            'reply' => 'GROQ_API_KEY is not configured in Laravel.'
        ], 500);
    }

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])
        ->timeout(30)
        ->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'openai/gpt-oss-20b',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $request->message
                ],
            ],
            'max_tokens' => 300,
            'temperature' => 0.7,
        ]);

        // TEMPORARY DEBUGGING
        if ($response->failed()) {
    return response()->json([
        'reply' => 'Sorry, I am unable to respond right now. Please try again later.'
    ]);
}

        $reply = $response->json('choices.0.message.content');

        return response()->json([
            'reply' => $reply
                ? trim($reply)
                : 'Sorry, I could not generate a response.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
        ], 500);
    }
}

    // ── RETRIEVE: Pull relevant data from CRM database ─────────────────
    private function retrieveContext($user, $message)
    {
        $context = [];
        $msg     = strtolower($message);

        // ── Tickets ───────────────────────────────────────────────────
        if ($this->isAbout($msg, ['ticket', 'issue', 'complaint', 'support', 'problem', 'request'])) {
            if ($user->role === 'admin') {
                $tickets = SupportTicket::with('user')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($t) => [
                        'id'       => $t->id,
                        'customer' => $t->user->name,
                        'title'    => $t->title,
                        'status'   => $t->status,
                        'priority' => $t->priority,
                        'created'  => $t->created_at->format('d M Y'),
                    ]);
            } else {
                $tickets = SupportTicket::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($t) => [
                        'id'      => $t->id,
                        'title'   => $t->title,
                        'status'  => $t->status,
                        'reply'   => $t->admin_reply ?? 'No reply yet',
                        'created' => $t->created_at->format('d M Y'),
                    ]);
            }
            if ($tickets->count() > 0) {
                $context['tickets'] = $tickets->toArray();
            }
        }

        // ── Tasks ─────────────────────────────────────────────────────
        if ($this->isAbout($msg, ['task', 'todo', 'deadline', 'pending', 'complete', 'due'])) {
            $tasks = Task::where('user_id', $user->id)
                ->orderByRaw("CASE WHEN status='pending' THEN 0 ELSE 1 END")
                ->orderBy('deadline')
                ->take(5)
                ->get()
                ->map(fn($t) => [
                    'title'    => $t->title,
                    'status'   => $t->status,
                    'deadline' => $t->deadline ? $t->deadline->format('d M Y') : 'No deadline',
                    'overdue'  => $t->isOverdue() ? 'YES' : 'No',
                ]);
            if ($tasks->count() > 0) {
                $context['tasks'] = $tasks->toArray();
            }
        }

        // ── Activities ────────────────────────────────────────────────
        if ($this->isAbout($msg, ['activity', 'meeting', 'call', 'note', 'follow', 'schedule'])) {
            $activities = Activity::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
                ->map(fn($a) => [
                    'type'        => $a->typeLabel(),
                    'title'       => $a->title,
                    'status'      => $a->statusLabel(),
                    'date'        => $a->activity_date->format('d M Y'),
                    'follow_up'   => $a->follow_up_date ? $a->follow_up_date->format('d M Y') : 'None',
                ]);
            if ($activities->count() > 0) {
                $context['activities'] = $activities->toArray();
            }
        }

        // ── User profile (always included) ────────────────────────────
        $context['user'] = [
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ];

        // ── Summary stats (always included) ───────────────────────────
        if ($user->role === 'admin') {
            $context['stats'] = [
                'total_customers' => \App\Models\User::where('role', 'customer')->count(),
                'open_tickets'    => SupportTicket::where('status', 'open')->count(),
                'total_tickets'   => SupportTicket::count(),
            ];
        } else {
            $context['stats'] = [
                'my_open_tickets'    => SupportTicket::where('user_id', $user->id)->where('status', 'open')->count(),
                'my_pending_tasks'   => Task::where('user_id', $user->id)->where('status', 'pending')->count(),
                'my_overdue_tasks'   => Task::where('user_id', $user->id)->where('status', 'pending')->whereNotNull('deadline')->whereDate('deadline', '<', now())->count(),
            ];
        }

        return $context;
    }

    // ── BUILD: Create system prompt with CRM context injected ───────────
    private function buildSystemPrompt($user, $context)
    {
        $contextJson = json_encode($context, JSON_PRETTY_PRINT);

        return "You are a helpful AI assistant for ElevatedCRM, a CRM web application.
You are talking to: {$user->name} (Role: {$user->role})

REAL-TIME CRM DATA (retrieved from the database for this user):
{$contextJson}

INSTRUCTIONS:
- Use the above CRM data to give accurate, personalized answers
- If the user asks about their tickets, tasks, or activities — refer to the data above
- If asked about something not in the data, answer based on general CRM knowledge
- Keep answers concise, friendly, and helpful
- Never make up ticket IDs, dates, or statuses — only use what is in the data above
- If no relevant data is found, guide the user on how to use the CRM features";
    }

    // ── HELPER: Check if message is about a topic ───────────────────────
    private function isAbout(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
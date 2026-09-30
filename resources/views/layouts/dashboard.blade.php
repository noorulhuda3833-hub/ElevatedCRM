<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ElevatedCRM') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color:#0F172A; color:#E5E7EB;">

<!-- Mobile top bar -->
<div class="lg:hidden flex items-center justify-between px-4 h-14 sticky top-0 z-40"
     style="background-color:#1E293B; border-bottom:1px solid #334155;">
    <span class="text-lg font-bold" style="color:#22D3EE;">ElevatedCRM</span>
    <button id="sidebar-toggle" class="p-2 rounded-lg" style="color:#E5E7EB;">
        <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<!-- Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-black bg-opacity-50 hidden lg:hidden"></div>

<div class="flex min-h-screen" style="background-color:#0F172A;">

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out"
           style="background-color:#1E293B; border-right:1px solid #334155;">

        <!-- Logo -->
        <div class="flex h-16 items-center justify-center flex-shrink-0" style="border-bottom:1px solid #334155;">
            <span class="text-xl font-bold" style="color:#22D3EE;">
                {{ auth()->user()->role === 'admin' ? 'Admin Portal' : 'Customer Portal' }}
            </span>
        </div>

        <!-- Nav links -->
        <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-3">

            @php
            function navLink($route, $label, $icon, $match = null) {
                $active = $match ? request()->routeIs($match) : request()->routeIs($route);
                $activeStyle = $active ? 'background-color:#273549; color:#22D3EE;' : 'color:#E5E7EB;';
                $hoverOut    = $active ? 'background-color:#273549' : 'transparent';
                echo '<a href="'.route($route).'"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150"
                    style="'.$activeStyle.'"
                    onmouseover="this.style.backgroundColor=\'#273549\'"
                    onmouseout="this.style.backgroundColor=\''.$hoverOut.'\'"
                    onclick="closeSidebar()">
                    '.$icon.'
                    '.$label.'
                </a>';
            }
            $icons = [
                'dashboard' => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                'customers' => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                'tickets'   => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>',
                'reports'   => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                'activities'=> '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                'tasks'     => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
                'profile'   => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
            ];
            @endphp

            @if(auth()->user()->role === 'admin')
                {!! navLink('admin.dashboard', 'Dashboard', $icons['dashboard'], 'admin.dashboard') !!}
                {!! navLink('admin.customers', 'Customers', $icons['customers'], 'admin.customers*') !!}
                {!! navLink('admin.tickets',   'Support Tickets', $icons['tickets'],   'admin.tickets*') !!}
                {!! navLink('admin.reports',   'Reports', $icons['reports'],   'admin.reports*') !!}
            @else
                {!! navLink('customer.dashboard', 'Dashboard',       $icons['dashboard'], 'customer.dashboard') !!}
                {!! navLink('customer.tickets',   'Support Tickets', $icons['tickets'],   'customer.tickets*') !!}
            @endif

            <div class="pt-2" style="border-top:1px solid #334155; margin-top:8px;"></div>

            {!! navLink('activities.index', 'Activities', $icons['activities'], 'activities*') !!}
            {!! navLink('tasks.index',      'My Tasks',   $icons['tasks'],      'tasks*') !!}
            {!! navLink('profile',          'Profile',    $icons['profile'],    'profile') !!}
        </nav>

        <!-- Logout at bottom -->
        <div class="p-4 flex-shrink-0" style="border-top:1px solid #334155;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150"
                    style="color:#94A3B8;"
                    onmouseover="this.style.backgroundColor='#273549'; this.style.color='#F87171'"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#94A3B8'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

        <!-- Desktop top header -->
        <header class="hidden lg:flex items-center justify-between px-6 h-16 flex-shrink-0"
                style="background-color:#1E293B; border-bottom:1px solid #334155; box-shadow:0 1px 8px rgba(0,0,0,0.4);">
            <h2 class="text-xl font-semibold" style="color:#E5E7EB;">@yield('header', 'Dashboard')</h2>
            <div class="flex items-center gap-3">
                <span class="text-sm" style="color:#94A3B8;">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-150"
                        style="background-color:#334155; color:#E5E7EB;"
                        onmouseover="this.style.backgroundColor='#475569'"
                        onmouseout="this.style.backgroundColor='#334155'">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-4 sm:p-6" style="background-color:#0F172A;">
            <!-- Mobile page title -->
            <h2 class="lg:hidden text-lg font-semibold mb-4" style="color:#E5E7EB;">@yield('header', 'Dashboard')</h2>
            @yield('content')
        </main>
    </div>
</div>

<script>
const sidebar   = document.getElementById('sidebar');
const backdrop  = document.getElementById('sidebar-backdrop');
const menuIcon  = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    backdrop.classList.remove('hidden');
    menuIcon.classList.add('hidden');
    closeIcon.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    backdrop.classList.add('hidden');
    menuIcon.classList.remove('hidden');
    closeIcon.classList.add('hidden');
    document.body.style.overflow = '';
}
document.getElementById('sidebar-toggle').addEventListener('click', () => {
    sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
});
backdrop.addEventListener('click', closeSidebar);
// Close on resize to desktop
window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeSidebar(); });
</script>

<!-- ── AI Chatbot Widget ─────────────────────────────── -->
<div id="chatbot-widget" style="position:fixed; bottom:24px; right:24px; z-index:9999; font-family:sans-serif;">

    <!-- Bubble button -->
    <button id="chatbot-toggle"
        onclick="toggleChat()"
        style="width:56px; height:56px; border-radius:50%; border:none; cursor:pointer;
               background-color:#22D3EE; color:#0F172A; box-shadow:0 4px 20px rgba(34,211,238,0.5);
               display:flex; align-items:center; justify-content:center; margin-left:auto;">
        <svg id="chat-open-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <svg id="chat-close-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Chat window -->
    <div id="chatbot-box"
         style="display:none; flex-direction:column; width:320px; height:430px;
                border-radius:16px; overflow:hidden; margin-bottom:12px;
                background-color:#1E293B; border:1px solid #334155;
                box-shadow:0 8px 32px rgba(0,0,0,0.5);">

        <!-- Header -->
        <div style="background-color:#0F172A; padding:14px 16px;
                    border-bottom:1px solid #334155; display:flex; align-items:center; gap:10px;">
            <div style="width:32px; height:32px; border-radius:50%; background-color:rgba(34,211,238,0.15);
                        border:2px solid #22D3EE; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="16" height="16" fill="none" stroke="#22D3EE" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div style="font-size:13px; font-weight:600; color:#E5E7EB;">CRM Assistant</div>
                <div style="font-size:11px; color:#34D399;">● Online</div>
            </div>
        </div>

        <!-- Messages -->
        <div id="chatbot-messages"
             style="flex:1; overflow-y:auto; padding:14px; display:flex; flex-direction:column; gap:10px;
                    scrollbar-width:thin; scrollbar-color:#334155 transparent;">
            <!-- Welcome message -->
            <div style="display:flex; gap:8px; align-items:flex-start;">
                <div style="width:26px; height:26px; border-radius:50%; background:rgba(34,211,238,0.15);
                            border:1px solid #22D3EE; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="12" height="12" fill="none" stroke="#22D3EE" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div style="background-color:#0F172A; color:#E5E7EB; font-size:13px; padding:10px 12px;
                            border-radius:0 12px 12px 12px; max-width:85%; line-height:1.5; border:1px solid #334155;">
                    Hi! I'm your CRM Assistant 👋 Ask me anything about tickets, tasks, activities, or your account!
                </div>
            </div>
        </div>

        <!-- Quick suggestions -->
        <div id="chatbot-suggestions"
             style="padding:0 12px 8px; display:flex; flex-wrap:wrap; gap:6px;">
            @foreach([
                'How do I create a ticket?',
                'How to add a task?',
                'What are Activities?',
                'How to update my profile?',
            ] as $q)
            <button onclick="sendSuggestion('{{ $q }}')"
                style="font-size:11px; padding:4px 10px; border-radius:20px; border:1px solid #334155;
                       background:transparent; color:#94A3B8; cursor:pointer; transition:all 0.15s;"
                onmouseover="this.style.borderColor='#22D3EE'; this.style.color='#22D3EE';"
                onmouseout="this.style.borderColor='#334155'; this.style.color='#94A3B8';">
                {{ $q }}
            </button>
            @endforeach
        </div>

        <!-- Input -->
        <div style="padding:10px 12px; border-top:1px solid #334155; display:flex; gap:8px; align-items:center;">
            <input id="chatbot-input" type="text" placeholder="Type your question..."
                onkeydown="if(event.key==='Enter') sendMessage()"
                style="flex:1; padding:9px 12px; border-radius:10px; font-size:13px;
                       background-color:#0F172A; border:1px solid #334155; color:#E5E7EB; outline:none;"
                onfocus="this.style.borderColor='#22D3EE'" onblur="this.style.borderColor='#334155'">
            <button onclick="sendMessage()" id="send-btn"
                style="width:36px; height:36px; border-radius:10px; border:none; cursor:pointer; flex-shrink:0;
                       background-color:#22D3EE; color:#0F172A; display:flex; align-items:center; justify-content:center;
                       transition:background-color 0.15s;"
                onmouseover="this.style.backgroundColor='#06B6D4'" onmouseout="this.style.backgroundColor='#22D3EE'">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const messagesBox = document.getElementById('chatbot-messages');
const inputBox    = document.getElementById('chatbot-input');
const sendBtn     = document.getElementById('send-btn');

function toggleChat() {
    const box       = document.getElementById('chatbot-box');
    const openIcon  = document.getElementById('chat-open-icon');
    const closeIcon = document.getElementById('chat-close-icon');
    const isOpen    = box.style.display === 'flex';
    box.style.display      = isOpen ? 'none' : 'flex';
    openIcon.style.display  = isOpen ? 'block' : 'none';
    closeIcon.style.display = isOpen ? 'none'  : 'block';
}

function appendMessage(text, sender) {
    const isUser = sender === 'user';
    const wrap   = document.createElement('div');
    wrap.style.cssText = `display:flex; gap:8px; align-items:flex-start; ${isUser ? 'flex-direction:row-reverse;' : ''}`;

    const avatar = document.createElement('div');
    avatar.style.cssText = `width:26px; height:26px; border-radius:50%; flex-shrink:0; display:flex;
        align-items:center; justify-content:center; font-size:11px; font-weight:700;
        ${isUser
            ? 'background:rgba(129,140,248,0.2); border:1px solid #818CF8; color:#818CF8;'
            : 'background:rgba(34,211,238,0.15); border:1px solid #22D3EE; color:#22D3EE;'}`;
    avatar.textContent = isUser ? 'You' : 'AI';

    const bubble = document.createElement('div');
    bubble.style.cssText = `font-size:13px; padding:10px 12px; line-height:1.5; max-width:85%;
        ${isUser
            ? 'background-color:#818CF8; color:#fff; border-radius:12px 0 12px 12px;'
            : 'background-color:#0F172A; color:#E5E7EB; border-radius:0 12px 12px 12px; border:1px solid #334155;'}`;
    bubble.textContent = text;

    wrap.appendChild(avatar);
    wrap.appendChild(bubble);
    messagesBox.appendChild(wrap);
    messagesBox.scrollTop = messagesBox.scrollHeight;
}

function appendTyping() {
    const wrap = document.createElement('div');
    wrap.id = 'typing-indicator';
    wrap.style.cssText = 'display:flex; gap:8px; align-items:flex-start;';
    wrap.innerHTML = `
        <div style="width:26px;height:26px;border-radius:50%;background:rgba(34,211,238,0.15);
                    border:1px solid #22D3EE;display:flex;align-items:center;justify-content:center;
                    font-size:11px;font-weight:700;color:#22D3EE;flex-shrink:0;">AI</div>
        <div style="background-color:#0F172A;border:1px solid #334155;border-radius:0 12px 12px 12px;
                    padding:10px 14px;display:flex;gap:4px;align-items:center;">
            <span style="width:6px;height:6px;border-radius:50%;background:#94A3B8;
                         animation:bounce 1s infinite 0s;display:inline-block;"></span>
            <span style="width:6px;height:6px;border-radius:50%;background:#94A3B8;
                         animation:bounce 1s infinite 0.2s;display:inline-block;"></span>
            <span style="width:6px;height:6px;border-radius:50%;background:#94A3B8;
                         animation:bounce 1s infinite 0.4s;display:inline-block;"></span>
        </div>`;
    messagesBox.appendChild(wrap);
    messagesBox.scrollTop = messagesBox.scrollHeight;
}

function removeTyping() {
    const t = document.getElementById('typing-indicator');
    if (t) t.remove();
}

async function sendMessage() {
    const text = inputBox.value.trim();
    if (!text) return;

    // Hide suggestions after first message
    document.getElementById('chatbot-suggestions').style.display = 'none';

    appendMessage(text, 'user');
    inputBox.value    = '';
    inputBox.disabled = true;
    sendBtn.disabled  = true;
    appendTyping();

    try {
        const res  = await fetch('{{ route("chatbot.reply") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ message: text }),
        });
        const data = await res.json();
        removeTyping();
        appendMessage(data.reply || 'Sorry, something went wrong.', 'bot');
    } catch (e) {
        removeTyping();
        appendMessage('Network error. Please try again.', 'bot');
    } finally {
        inputBox.disabled = false;
        sendBtn.disabled  = false;
        inputBox.focus();
    }
}

function sendSuggestion(text) {
    inputBox.value = text;
    sendMessage();
}
</script>

<style>
@keyframes bounce {
    0%,80%,100% { transform:translateY(0); }
    40%          { transform:translateY(-6px); }
}
</style>
<!-- ── End Chatbot Widget ──────────────────────────────── -->

</body>
</html>

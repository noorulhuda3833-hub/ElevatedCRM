<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ElevatedCRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color:#0F172A; color:#E5E7EB;">

<header class="fixed top-0 left-0 w-full z-50" style="background-color:#1E293B; border-bottom:1px solid #334155; box-shadow:0 2px 10px rgba(0,0,0,0.4);">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold flex-shrink-0" style="color:#22D3EE;">ElevatedCRM</a>

            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-1">
                @foreach(['home'=>'Home','about'=>'About','services'=>'Services','features'=>'Features','contact'=>'Contact'] as $r=>$l)
                <a href="{{ route($r) }}" class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150"
                   style="{{ request()->routeIs($r) ? 'color:#22D3EE; background-color:rgba(34,211,238,0.1);' : 'color:#94A3B8;' }}"
                   onmouseover="this.style.color='#E5E7EB'" onmouseout="this.style.color='{{ request()->routeIs($r) ? '#22D3EE' : '#94A3B8' }}'">{{ $l }}</a>
                @endforeach
            </div>

            <div class="flex items-center gap-2">
                <!-- Desktop auth -->
                <div class="hidden md:flex items-center gap-2">
                    @guest
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-semibold transition-colors" style="background-color:rgba(34,211,238,0.15); color:#22D3EE; border:1px solid rgba(34,211,238,0.3);" onmouseover="this.style.backgroundColor='rgba(34,211,238,0.25)'" onmouseout="this.style.backgroundColor='rgba(34,211,238,0.15)'">Sign Up</a>
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-semibold transition-colors" style="background-color:#22D3EE; color:#0F172A;" onmouseover="this.style.backgroundColor='#06B6D4'" onmouseout="this.style.backgroundColor='#22D3EE'">Login</a>
                    @else
                        <a href="{{ auth()->user()->role==='admin' ? route('admin.dashboard') : route('customer.dashboard') }}" class="px-4 py-2 rounded-md text-sm font-semibold" style="background-color:#22D3EE; color:#0F172A;">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                            <button type="submit" class="px-4 py-2 rounded-md text-sm font-semibold" style="background-color:#334155; color:#E5E7EB;">Logout</button>
                        </form>
                    @endguest
                </div>

                <!-- Mobile hamburger -->
                <button id="nav-toggle" class="md:hidden p-2 rounded-lg" style="color:#E5E7EB;">
                    <svg id="nav-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="nav-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col gap-1 pt-2" style="border-top:1px solid #334155;">
                @foreach(['home'=>'Home','about'=>'About','services'=>'Services','features'=>'Features','contact'=>'Contact'] as $r=>$l)
                <a href="{{ route($r) }}" class="px-3 py-2 rounded-md text-sm font-medium" style="{{ request()->routeIs($r) ? 'color:#22D3EE; background-color:rgba(34,211,238,0.1);' : 'color:#94A3B8;' }}" onclick="closeMobileNav()">{{ $l }}</a>
                @endforeach
                <div class="flex gap-2 mt-2 pt-2" style="border-top:1px solid #334155;">
                    @guest
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-2 rounded-md text-sm font-semibold" style="background-color:rgba(34,211,238,0.15); color:#22D3EE; border:1px solid rgba(34,211,238,0.3);">Sign Up</a>
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-2 rounded-md text-sm font-semibold" style="background-color:#22D3EE; color:#0F172A;">Login</a>
                    @else
                        <a href="{{ auth()->user()->role==='admin' ? route('admin.dashboard') : route('customer.dashboard') }}" class="flex-1 text-center px-4 py-2 rounded-md text-sm font-semibold" style="background-color:#22D3EE; color:#0F172A;">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">@csrf
                            <button type="submit" class="w-full px-4 py-2 rounded-md text-sm font-semibold" style="background-color:#334155; color:#E5E7EB;">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="h-16"></div>
<main>@yield('content')</main>

<footer style="background-color:#1E293B; border-top:1px solid #334155;">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-lg font-semibold mb-3" style="color:#22D3EE;">ElevatedCRM</h3>
                <p class="text-sm" style="color:#94A3B8;">Your trusted CRM solution for managing customer relationships effectively.</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold mb-3 uppercase tracking-wider" style="color:#E5E7EB;">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    @foreach(['home'=>'Home','about'=>'About','services'=>'Services','contact'=>'Contact'] as $r=>$l)
                    <li><a href="{{ route($r) }}" style="color:#94A3B8;" onmouseover="this.style.color='#E5E7EB'" onmouseout="this.style.color='#94A3B8'">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold mb-3 uppercase tracking-wider" style="color:#E5E7EB;">Contact</h3>
                <ul class="space-y-2 text-sm" style="color:#94A3B8;">
                    <li>info@elevatedcrm.com</li>
                    <li>(123) 456-7890</li>
                    <li>123 CRM Street</li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold mb-3 uppercase tracking-wider" style="color:#E5E7EB;">Follow Us</h3>
                <div class="flex gap-3">
                    @foreach(['M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z', 'M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z', 'M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z'] as $path)
                    <a href="#" style="color:#94A3B8;" onmouseover="this.style.color='#22D3EE'" onmouseout="this.style.color='#94A3B8'">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-8 pt-6 text-center text-sm" style="border-top:1px solid #334155; color:#94A3B8;">
            &copy; {{ date('Y') }} ElevatedCRM. All rights reserved.
        </div>
    </div>
</footer>

<script>
const navToggle = document.getElementById('nav-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const navOpen = document.getElementById('nav-open');
const navClose = document.getElementById('nav-close');
function closeMobileNav() {
    mobileMenu.classList.add('hidden');
    navOpen.classList.remove('hidden');
    navClose.classList.add('hidden');
}
navToggle.addEventListener('click', () => {
    const isOpen = !mobileMenu.classList.contains('hidden');
    if (isOpen) { closeMobileNav(); }
    else {
        mobileMenu.classList.remove('hidden');
        navOpen.classList.add('hidden');
        navClose.classList.remove('hidden');
    }
});
window.addEventListener('resize', () => { if (window.innerWidth >= 768) closeMobileNav(); });
</script>

<!-- ── Public AI Chatbot Widget ──────────────────────────── -->
<div id="chatbot-widget" style="position:fixed; bottom:24px; right:24px; z-index:9999; font-family:sans-serif;">

    <!-- Bubble button -->
    <button id="chatbot-toggle" onclick="toggleChat()"
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
                    Hi! 👋 I'm the ElevatedCRM Assistant. Ask me anything about our CRM system!
                </div>
            </div>
        </div>

        <!-- Quick suggestions -->
        <div id="chatbot-suggestions" style="padding:0 12px 8px; display:flex; flex-wrap:wrap; gap:6px;">
            @foreach([
                'What is ElevatedCRM?',
                'How do I register?',
                'What features are available?',
                'How to contact support?',
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
                       background-color:#22D3EE; color:#0F172A; display:flex; align-items:center; justify-content:center;"
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
    box.style.display       = isOpen ? 'none'  : 'flex';
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

    document.getElementById('chatbot-suggestions').style.display = 'none';
    appendMessage(text, 'user');
    inputBox.value    = '';
    inputBox.disabled = true;
    sendBtn.disabled  = true;
    appendTyping();

    try {
        const res  = await fetch('{{ route("chatbot.guest") }}', {
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
<!-- ── End Public Chatbot Widget ──────────────────────────── -->

</body>
</html>

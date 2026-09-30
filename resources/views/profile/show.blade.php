@extends('layouts.dashboard')
@section('title', 'My Profile')
@section('header', 'My Profile')

@section('content')
<style>
.frm-input {
    width:100%; padding:0.7rem 1rem; border-radius:0.5rem; font-size:0.875rem;
    background-color:#0A1628; border:1.5px solid #253548; color:#F1F5F9;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s;
    -webkit-text-fill-color:#F1F5F9; font-family:inherit;
}
.frm-input::placeholder { color:#64748B; }
.frm-input:focus { border-color:#22D3EE; box-shadow:0 0 0 3px rgba(34,211,238,0.12); }
.frm-input:-webkit-autofill, .frm-input:-webkit-autofill:focus {
    -webkit-box-shadow:0 0 0 1000px #0A1628 inset; -webkit-text-fill-color:#F1F5F9;
}
.frm-label { display:block; font-size:0.8125rem; font-weight:500; margin-bottom:0.5rem; color:#CBD5E1; }
</style>

<div class="max-w-xl mx-auto">

    @if(session('status'))
    <div class="mb-4 px-4 py-3 rounded-xl text-sm flex items-center gap-2"
         style="background:rgba(34,211,238,0.08); border:1px solid rgba(34,211,238,0.25); color:#22D3EE;">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('status') }}
    </div>
    @endif

    <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(145deg,#1A2A3F,#152030); border:1px solid #253548; box-shadow:0 8px 32px rgba(0,0,0,0.4);">

        <!-- Profile header -->
        <div class="px-6 py-5" style="border-bottom:1px solid #253548; background:rgba(0,0,0,0.2);">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,rgba(34,211,238,0.2),rgba(129,140,248,0.2)); color:#22D3EE; border:1.5px solid rgba(34,211,238,0.3); letter-spacing:-0.5px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-semibold text-lg" style="color:#F1F5F9;">{{ auth()->user()->name }}</h2>
                    <p class="text-sm" style="color:#94A3B8;">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="px-6 py-6 space-y-5">
            @csrf @method('PUT')

            <!-- Name -->
            <div>
                <label class="frm-label">Full Name <span style="color:#F87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="frm-input" placeholder="Your full name">
                @error('name')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
            </div>

            <!-- Email -->
            <div>
                <label class="frm-label">Email Address <span style="color:#F87171;">*</span></label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                       class="frm-input" placeholder="your@email.com">
                @error('email')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
            </div>

            <!-- Password section -->
            <div class="rounded-xl p-5 space-y-4" style="background:rgba(0,0,0,0.2); border:1px solid #253548;">
                <div>
                    <h3 class="text-sm font-semibold mb-0.5" style="color:#94A3B8;">Change Password</h3>
                    <p class="text-xs" style="color:#475569;">Leave blank to keep your current password</p>
                </div>
                <div>
                    <label class="frm-label">New Password</label>
                    <input type="password" name="password"
                           class="frm-input" placeholder="Min. 8 characters">
                    @error('password')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="frm-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="frm-input" placeholder="Re-enter new password">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-1" style="border-top:1px solid #253548;">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all"
                        style="background-color:#22D3EE; color:#0F172A;"
                        onmouseover="this.style.backgroundColor='#06B6D4'; this.style.boxShadow='0 4px 14px rgba(34,211,238,0.3)'"
                        onmouseout="this.style.backgroundColor='#22D3EE'; this.style.boxShadow='none'">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

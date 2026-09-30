@extends('layouts.app')

@section('content')
<style>
.frm-input {
    width:100%; padding:0.75rem 0.75rem 0.75rem 2.75rem; border-radius:0.5rem; font-size:0.875rem;
    background-color:#0A1628; border:1.5px solid #253548; color:#F1F5F9;
    outline:none; transition:border-color 0.2s, box-shadow 0.2s; -webkit-text-fill-color:#F1F5F9;
}
.frm-input::placeholder { color:#64748B; }
.frm-input:focus { border-color:#22D3EE; box-shadow:0 0 0 3px rgba(34,211,238,0.15); }
.frm-input:-webkit-autofill, .frm-input:-webkit-autofill:focus {
    -webkit-box-shadow:0 0 0 1000px #0A1628 inset; -webkit-text-fill-color:#F1F5F9;
}
</style>
<div class="min-h-screen flex items-center justify-center py-12 px-4"
     style="background:linear-gradient(135deg,#060E1F 0%,#0F172A 40%,#131F35 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:radial-gradient(circle at 1px 1px,rgba(34,211,238,0.04) 1px,transparent 0);background-size:40px 40px;"></div>
    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 rounded-2xl flex items-center justify-center mb-4" style="background:rgba(34,211,238,0.15);border:1.5px solid rgba(34,211,238,0.4);">
                <svg class="w-7 h-7" style="color:#22D3EE;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h1 class="text-2xl font-bold" style="color:#F1F5F9;">Reset Password</h1>
            <p class="mt-2 text-sm" style="color:#94A3B8;">We'll send you a reset link by email</p>
        </div>
        <div class="p-8 rounded-2xl" style="background:linear-gradient(145deg,#1A2A3F,#152030);border:1px solid #253548;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
            @if (session('status'))
            <div class="mb-5 px-4 py-3 rounded-lg text-sm" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);color:#34D399;">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-2" style="color:#CBD5E1;">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input type="email" name="email" required value="{{ old('email') }}" class="frm-input @error('email') !border-red-500 @enderror" placeholder="you@example.com">
                    </div>
                    @error('email')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-3 rounded-lg text-sm font-semibold transition-all" style="background:#22D3EE;color:#0F172A;" onmouseover="this.style.backgroundColor='#06B6D4'" onmouseout="this.style.backgroundColor='#22D3EE'">Send Reset Link</button>
            </form>
            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-sm transition-colors" style="color:#22D3EE;" onmouseover="this.style.color='#67E8F9'" onmouseout="this.style.color='#22D3EE'">← Back to sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection

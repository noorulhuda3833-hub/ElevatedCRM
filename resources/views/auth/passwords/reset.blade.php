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
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 rounded-2xl flex items-center justify-center mb-4" style="background:rgba(34,211,238,0.15);border:1.5px solid rgba(34,211,238,0.4);">
                <svg class="w-7 h-7" style="color:#22D3EE;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <h1 class="text-2xl font-bold" style="color:#F1F5F9;">Set New Password</h1>
        </div>
        <div class="p-8 rounded-2xl" style="background:linear-gradient(145deg,#1A2A3F,#152030);border:1px solid #253548;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color:#CBD5E1;">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg></div>
                        <input type="email" name="email" required value="{{ $email ?? old('email') }}" class="frm-input" placeholder="you@example.com">
                    </div>
                    @error('email')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color:#CBD5E1;">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                        <input type="password" name="password" required class="frm-input" placeholder="Min. 8 characters">
                    </div>
                    @error('password')<p class="mt-1.5 text-xs" style="color:#F87171;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color:#CBD5E1;">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        <input type="password" name="password_confirmation" required class="frm-input" placeholder="Re-enter new password">
                    </div>
                </div>
                <button type="submit" class="w-full py-3 rounded-lg text-sm font-semibold transition-all" style="background:#22D3EE;color:#0F172A;" onmouseover="this.style.backgroundColor='#06B6D4'" onmouseout="this.style.backgroundColor='#22D3EE'">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

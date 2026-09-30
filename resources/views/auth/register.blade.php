@extends('layouts.app')

@section('content')
<style>
.form-input {
    width: 100%;
    padding: 0.75rem 0.75rem 0.75rem 2.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    background-color: #0A1628;
    border: 1.5px solid #253548;
    color: #F1F5F9;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-text-fill-color: #F1F5F9;
}
.form-input::placeholder { color: #64748B; }
.form-input:focus {
    border-color: #22D3EE;
    box-shadow: 0 0 0 3px rgba(34,211,238,0.15);
}
.form-input:-webkit-autofill,
.form-input:-webkit-autofill:hover,
.form-input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px #0A1628 inset;
    -webkit-text-fill-color: #F1F5F9;
    caret-color: #F1F5F9;
    border-color: #22D3EE;
}
</style>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
     style="background: linear-gradient(135deg, #060E1F 0%, #0F172A 40%, #131F35 70%, #0A1628 100%);">

    <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, rgba(34,211,238,0.04) 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="w-full max-w-md space-y-8 relative z-10">

        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl flex items-center justify-center mb-5"
                 style="background: linear-gradient(135deg, rgba(129,140,248,0.2), rgba(34,211,238,0.2)); border: 1.5px solid rgba(129,140,248,0.4); box-shadow: 0 0 24px rgba(129,140,248,0.15);">
                <svg class="w-8 h-8" style="color:#818CF8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold tracking-tight" style="color:#F1F5F9;">Join ElevatedCRM</h1>
            <p class="mt-2 text-sm" style="color:#94A3B8;">Create your account to get started</p>
        </div>

        <!-- Card -->
        <div class="p-8 rounded-2xl"
             style="background: linear-gradient(145deg, #1A2A3F, #152030); border: 1px solid #253548; box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 1px 0 rgba(255,255,255,0.05) inset;">

            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf
                @php
                $fields = [
                    ['name','name','Full Name','text','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','Your full name'],
                    ['email','email','Email Address','email','M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207','you@example.com'],
                    ['password','password','Password','password','M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z','Create a strong password'],
                    ['password_confirmation','confirm','Confirm Password','password','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','Re-enter your password'],
                ];
                @endphp

                @foreach($fields as [$field, $id, $label, $type, $icon, $placeholder])
                <div>
                    <label for="{{ $id }}" class="block text-sm font-medium mb-2" style="color:#CBD5E1;">{{ $label }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4.5 w-4.5" style="color:#475569; width:1.1rem; height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                            </svg>
                        </div>
                        <input id="{{ $id }}" name="{{ $field }}" type="{{ $type }}"
                               {{ $type !== 'password' ? 'autocomplete='.$field : '' }}
                               {{ $id !== 'confirm' ? 'required' : '' }}
                               value="{{ in_array($field, ['name','email']) ? old($field) : '' }}"
                               class="form-input @error($field) !border-red-500 @enderror"
                               placeholder="{{ $placeholder }}">
                    </div>
                    @error($field)
                    <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#F87171;">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                @endforeach

                <!-- Terms -->
                <label class="flex items-start gap-3 cursor-pointer pt-1">
                    <input id="terms" name="terms" type="checkbox" required
                           class="mt-0.5 h-4 w-4 rounded flex-shrink-0" style="accent-color:#22D3EE;">
                    <span class="text-sm leading-relaxed" style="color:#94A3B8;">
                        I agree to the
                        <a href="#" style="color:#22D3EE;" onmouseover="this.style.color='#67E8F9'" onmouseout="this.style.color='#22D3EE'">Terms of Service</a>
                        and
                        <a href="#" style="color:#22D3EE;" onmouseover="this.style.color='#67E8F9'" onmouseout="this.style.color='#22D3EE'">Privacy Policy</a>
                    </span>
                </label>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-3 px-4 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition-all duration-200"
                        style="background-color:#22D3EE; color:#0F172A; letter-spacing:0.01em;"
                        onmouseover="this.style.backgroundColor='#06B6D4'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 16px rgba(34,211,238,0.3)'"
                        onmouseout="this.style.backgroundColor='#22D3EE'; this.style.transform='none'; this.style.boxShadow='none'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Create Account
                </button>

                <!-- Divider -->
                <div class="relative pt-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full" style="border-top: 1px solid #253548;"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 text-xs" style="background-color:#1A2A3F; color:#64748B;">Already have an account?</span>
                    </div>
                </div>

                <!-- Login link -->
                <a href="{{ route('login') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg text-sm font-medium transition-all duration-200"
                   style="border: 1.5px solid #253548; color:#CBD5E1; text-decoration:none;"
                   onmouseover="this.style.backgroundColor='#1E3A5F'; this.style.borderColor='#475569'"
                   onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#253548'">
                    <svg class="w-4 h-4" style="color:#22D3EE;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign in instead
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

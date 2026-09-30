@extends('layouts.app')

@section('content')
<style>
.form-input {
    width: 100%;
    padding: 0.75rem 0.75rem 0.75rem 2.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    background-color: #0F172A;
    border: 1.5px solid #334155;
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
    -webkit-box-shadow: 0 0 0 1000px #0F172A inset;
    -webkit-text-fill-color: #F1F5F9;
    caret-color: #F1F5F9;
    border-color: #22D3EE;
}
.btn-primary {
    width: 100%;
    padding: 0.8rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    background-color: #22D3EE;
    color: #0F172A;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.15s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    letter-spacing: 0.01em;
}
.btn-primary:hover {
    background-color: #06B6D4;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(34,211,238,0.3);
}
.btn-secondary {
    width: 100%;
    padding: 0.8rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    background-color: transparent;
    color: #E2E8F0;
    border: 1.5px solid #334155;
    cursor: pointer;
    transition: background-color 0.2s, border-color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
}
.btn-secondary:hover {
    background-color: #1E3A5F;
    border-color: #475569;
    color: #F1F5F9;
}
</style>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
     style="background: linear-gradient(135deg, #060E1F 0%, #0F172A 40%, #131F35 70%, #0A1628 100%);">

    <!-- Subtle grid overlay -->
    <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, rgba(34,211,238,0.04) 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">

        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl flex items-center justify-center mb-5"
                 style="background: linear-gradient(135deg, rgba(34,211,238,0.2), rgba(129,140,248,0.2)); border: 1.5px solid rgba(34,211,238,0.4); box-shadow: 0 0 24px rgba(34,211,238,0.15);">
                <svg class="w-8 h-8" style="color:#22D3EE;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold tracking-tight" style="color:#F1F5F9;">Welcome Back</h1>
            <p class="mt-2 text-sm" style="color:#94A3B8;">Sign in to your <span style="color:#22D3EE; font-weight:500;">ElevatedCRM</span> account</p>
        </div>

        <!-- Form Card -->
        <div class="p-8 rounded-2xl relative"
             style="background: linear-gradient(145deg, #1A2A3F, #152030); border: 1px solid #253548; box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 1px 0 rgba(255,255,255,0.05) inset;">

            <form class="space-y-5" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-2" style="color:#CBD5E1;">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required autocomplete="email"
                               value="{{ old('email') }}"
                               class="form-input @error('email') border-red-500 @enderror"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#F87171;">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium mb-2" style="color:#CBD5E1;">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5" style="color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="form-input @error('password') border-red-500 @enderror"
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs flex items-center gap-1" style="color:#F87171;">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 rounded" style="accent-color:#22D3EE;">
                        <span class="text-sm" style="color:#94A3B8;">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm font-medium transition-colors"
                           style="color:#22D3EE;"
                           onmouseover="this.style.color='#67E8F9'"
                           onmouseout="this.style.color='#22D3EE'">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div class="pt-1">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign in to your account
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative pt-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full" style="border-top: 1px solid #253548;"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 text-xs" style="background-color:#1A2A3F; color:#64748B;">New to ElevatedCRM?</span>
                    </div>
                </div>

                <!-- Register Link -->
                <a href="{{ route('register') }}" class="btn-secondary">
                    <svg class="w-4 h-4" style="color:#818CF8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create new account
                </a>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs" style="color:#475569;">
            By continuing, you agree to our
            <a href="#" style="color:#22D3EE;" onmouseover="this.style.color='#67E8F9'" onmouseout="this.style.color='#22D3EE'">Terms of Service</a>
            and
            <a href="#" style="color:#22D3EE;" onmouseover="this.style.color='#67E8F9'" onmouseout="this.style.color='#22D3EE'">Privacy Policy</a>
        </p>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/login_page.css') }}">
</head>

<body class="bg-white font-sans overflow-hidden">
    <div class="flex h-screen">
        <!-- Left Panel -->
        <div class="relative w-[40%] flex items-center justify-center px-6 bg-white overflow-hidden">

            <!-- Top Right fuckiign Smooth Side Blob -->
            <svg class="absolute top-0 right-0 z-0 pointer-events-none" width="360" height="260" viewBox="0 0 360 260"
                fill="none" xmlns="http://www.w3.org/2000/svg" style="right:-60px; top:-40px;">
                <path fill="#3188CFFF"
                    d="M360,0 Q330,90 270,120 Q210,150 180,90 Q150,30 90,60 Q30,90 0,0 L360,0Z" />
            </svg>

            <!-- Bottom Left fuckiign Smooth Side Blob -->
            <svg class="absolute bottom-0 left-0 z-0 pointer-events-none" width="420" height="300" viewBox="0 0 420 300"
                fill="none" xmlns="http://www.w3.org/2000/svg" style="left:-120px; bottom:-60px;">
                <path fill="#3188CFFF"
                    d="M0,300 Q60,200 140,170 Q220,140 260,210 Q300,280 380,250 Q420,230 420,300 L0,300Z" />
            </svg>

            <!-- Login Form -->
            <div class="relative z-10 w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mx-auto mb-10 p-5">
                    <img src="{{ asset('assets/Sample/syllabease.png') }}" alt="SyllabEase Logo" class="mx-auto w-60">
                </div>

                <!-- Headings -->
                <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Login
                </h2>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <div class="relative">
                            <!-- Modern User Icon (Heroicons) -->
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25v-.75A5.25 5.25 0 019.75 14.25h4.5a5.25 5.25 0 015.25 5.25v.75" />
                                </svg>
                            </span>
                            <input
                                id="email"
                                type="email"
                                class="w-full rounded-lg border border-gray-200 p-3 pl-12 pr-12 text-sm shadow-sm focus:border-[#F4A100] focus:ring-[#F4A100] transition-colors duration-200 @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="Email address"
                            />
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-blue-700 hover:underline">Forgot?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <!-- Modern Lock Icon (Heroicons) -->
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V7.5a4.5 4.5 0 10-9 0v3m12 0A2.25 2.25 0 0121 12.75v6A2.25 2.25 0 0118.75 21h-13.5A2.25 2.25 0 013 18.75v-6A2.25 2.25 0 015.25 10.5h13.5z" />
                                </svg>
                            </span>
                            <input
                                id="password"
                                type="password"
                                class="w-full rounded-lg border border-gray-200 p-3 pl-12 pr-12 text-sm shadow-sm focus:border-[#F4A100] focus:ring-[#F4A100] transition-colors duration-200 @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Password"
                            />
                            <button type="button" id="togglePassword" tabindex="-1" class="absolute right-3 top-1/2 -translate-y-1/2 focus:outline-none">
    <!-- Eye icon (show) - hidden by default -->
    <svg id="eyeOpen" class="w-5 h-5 text-gray-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 5-7 9-9 9s-9-4-9-9 7-9 9-9 9 4 9 9z" />
    </svg>

    <!-- Eye-off icon (hide) - shown by default -->
    <svg id="eyeClosed" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-4-9-7s4-7 9-7c1.657 0 3.21.41 4.5 1.125M19.5 14.625A9.956 9.956 0 0021 12c0-3-4-7-9-7m0 0c-1.657 0-3.21.41-4.5 1.125M3 3l18 18" />
    </svg>
</button>

                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full bg-blue5 hover:bg-blue-700 text-white font-semibold py-2 mt-2 rounded transition-colors duration-200">
                        Login
                    </button>
                </form>

                <!-- Bottom Text -->
                <p class="mt-4 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue5 font-semibold hover:underline">Create Account</a>
                </p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="hidden lg:block w-[60%] relative">
            <img src="{{ asset('assets/ustp_pic.jpg') }}" alt="USTP Campus" class="w-full h-full object-cover" />
            <div class="absolute inset-0" style="background: #dfaa0c; opacity: 0.15;"></div>
        </div>
    </div>

    <!-- Add this script just before </body> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeOpen.classList.toggle('hidden', !isPassword);
                eyeClosed.classList.toggle('hidden', isPassword);
            });
        });
    </script>
</body>

</html>

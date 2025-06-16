<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .yellow-input {
            border: 2px solid #ffd600 !important;
            background: #fff !important;
        }

        .yellow-input:focus {
            border-color: #ffd600 !important;
            box-shadow: 0 0 0 2px #ffe06633;
        }

        .yellow-btn {
            background: #ffd600 !important;
            color: #222 !important;
            font-weight: 700;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .yellow-btn:hover {
            background: #ffea80 !important;
        }
    </style>
</head>

<body class="bg-white font-sans overflow-hidden">
    <div class="flex h-screen">
        <!-- Left Panel -->
        <div class="relative w-[40%] flex items-center justify-center px-6 bg-white overflow-hidden">

            <!-- Top Right fuckiign Smooth Side Blob -->
            <svg class="absolute top-0 right-0 z-0 pointer-events-none" width="360" height="260" viewBox="0 0 360 260"
                fill="none" xmlns="http://www.w3.org/2000/svg" style="right:-60px; top:-40px;">
                <path fill="#1769aa"
                    d="M360,0 Q330,90 270,120 Q210,150 180,90 Q150,30 90,60 Q30,90 0,0 L360,0Z" />
            </svg>

            <!-- Bottom Left fuckiign Smooth Side Blob -->
            <svg class="absolute bottom-0 left-0 z-0 pointer-events-none" width="420" height="300" viewBox="0 0 420 300"
                fill="none" xmlns="http://www.w3.org/2000/svg" style="left:-120px; bottom:-60px;">
                <path fill="#1769aa"
                    d="M0,300 Q60,200 140,170 Q220,140 260,210 Q300,280 380,250 Q420,230 420,300 L0,300Z" />
            </svg>

            <!-- Login Form -->
            <div class="relative z-10 w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mx-auto mb-20">
                    <img src="{{ asset('assets/Sample/syllabease.png') }}" alt="SyllabEase Logo" class="mx-auto w-90 ">
                </div>

                <!-- Headings -->
                <div class="mb-6 text-left">
                    <h2 class="text-3xl font-bold text-gray-800">Get Started</h2>
                    <p class="text-sm text-gray-600">
                        Welcome to <span class="text-yellow-500 font-semibold">SyllabEase</span>
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="flex items-center mt-1 rounded-md px-3 py-2 yellow-input">
                            <svg class="w-5 h-5 text-blue-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v.217l-8 4.8-8-4.8V5zM2 7.383V15a2 2 0 002 2h12a2 2 0 002-2V7.383l-7.445 4.467a1 1 0 01-1.11 0L2 7.383z" />
                            </svg>
                            <input type="email" name="email" id="email" placeholder="example@example.com"
                                value="{{ old('email') }}" required
                                class="w-full bg-transparent text-gray-700 focus:outline-none text-sm border-none shadow-none focus:ring-0" />
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-blue-700 hover:underline">Forgot?</a>
                            @endif
                        </div>
                        <div class="flex items-center mt-1 rounded-md px-3 py-2 yellow-input">
                            <svg class="w-5 h-5 text-blue-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 8a5 5 0 0110 0v1h1a1 1 0 011 1v7a1 1 0 01-1 1H4a1 1 0 01-1-1v-7a1 1 0 011-1h1V8zm8 0a3 3 0 10-6 0v1h6V8z"
                                    clip-rule="evenodd" />
                            </svg>
                            <input type="password" name="password" id="password" placeholder="Your Password" required
                                class="w-full bg-transparent text-gray-700 focus:outline-none text-sm border-none shadow-none focus:ring-0" />
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full yellow-btn py-2 mt-2">
                        Sign up
                    </button>
                </form>

                <!-- Bottom Text -->
                <p class="mt-4 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-yellow-500 font-semibold hover:underline">Create Account</a>
                </p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="hidden lg:block w-[60%] relative">
            <img src="{{ asset('assets/ustp_pic.jpg') }}" alt="USTP Campus" class="w-full h-full object-cover" />
            <div class="absolute inset-0" style="background: #dfaa0c; opacity: 0.15;"></div>
        </div>
    </div>
</body>

</html>

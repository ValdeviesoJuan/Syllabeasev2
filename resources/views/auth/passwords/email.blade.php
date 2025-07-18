<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="/css/pass_reset.css"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Reset Password</title>
</head>

<body class="bg-white">
    <section class="relative flex flex-wrap lg:h-screen lg:items-center">
        <div class="w-full flex items-center justify-center min-h-screen px-4 py-8 sm:px-6 sm:py-12 lg:w-1/2 lg:px-8 lg:py-24">
            <div class="
                bg-white 
                bg-opacity-90 
                shadow-[0_4px_20px_rgba(0,0,0,0.08)] 
                rounded-2xl 
                lg:rounded-l-2xl lg:rounded-r-none
                backdrop-blur-md
                p-8 sm:p-10 max-w-md w-full
                transition-all
            ">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                   <a href="{{ route('login') }}">
                        <img src="{{ asset('assets/Sample/syllabease.png') }}" alt="SyllabEase Logo" class="mx-auto w-60">
                    </a>

                </div>
                <h1 class="text-xl font-bold text-gray-900 mb-2 text-left">Forgot Password</h1>
                <p class="text-gray-500 text-sm text-left mb-6">
                    Already have an account?
                    <a class="text-[#F4A100] font-semibold hover:underline" href="{{ route('login') }}">Sign in</a>
                </p>
                <form method="POST" action="{{ route('password.email') }}" class=   "space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <div class="relative">
                            <input
                                id="email"
                                type="email"
                                class="w-full rounded-lg border border-gray-200 p-3 pr-12 text-sm shadow-sm focus:border-[#F4A100] focus:ring-[#F4A100] transition-colors duration-200"
                                @error('email') is-invalid @enderror
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="Email address"
                            />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <!-- Envelope Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#F4A100]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2" stroke="currentColor" fill="none"/>
                                    <path d="M3 7l9 6 9-6" stroke-width="2" stroke="currentColor" fill="none"/>
                                </svg>
                            </span>
                            @error('email')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue5 hover:bg-blue-700 text-white font-semibold p-3 rounded-lg transition-colors duration-200 text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10l9-6 9 6-9 6-9-6zm0 0v6a9 9 0 009 9 9 9 0 009-9v-6" />
                        </svg>
                        Send Password Reset Link
                    </button>
                    @if (session('status'))
                        <div class="text-green-600 text-sm text-center mt-2">
                            {{ session('status') }}
                        </div>
                    @endif
                </form>
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        No account?
                        <a class="text-blue5 font-semibold hover:underline" href="{{ route('register') }}">Sign up</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-blue5 relative h-64 w-full sm:h-96 lg:h-full lg:w-1/2">
            <img alt=""
                src="/assets/forgotpass-vector.png"
                class="absolute inset-0 h-full w-full object-cover" />
        </div>
    </section>
</body>

</html>

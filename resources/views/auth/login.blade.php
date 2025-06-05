<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="/css/user_logins.css"> --}}
    <title>SyllabEase</title>
    <link rel="stylesheet" href="/css/loading.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
</head>

<body>
    <div class="">
        <div class="dark:bg-gray-900">
            <div class="flex justify-center h-screen bg-white">
                <div class="hidden bg-cover lg:block lg:w-2/3 opacity-85"
                    style="background-image: url('/assets/USTP-CDO.jpg')">
                    <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40"></div>
                </div>

                <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                    <div class="flex-1">
                        <div class="text-center">
                            <img src="/assets/Sample/syllabease.png" alt="">
                            {{-- <h2 class="text-4xl font-bold text-center text-gray-700 dark:text-white"></h2> --}}

                            <p class="mt-3 text-gray-500 dark:text-gray-300">Sign in to access your account</p>
                        </div>

                        <div class="mt-8">
                            <form method="POST" id = "form" action="{{ route('login') }}">
                                @csrf
                                <div>
                                    <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" placeholder="example@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        class="email_input @error('email') is-invalid @enderror block w-full px-4 py-2 mt-4 mb-[-14px] text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert"><br>
                                            <strong class="message_alert text-red text-sm">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mt-6">
                                    <div class="flex justify-between mb-2">
                                        <label for="password"
                                            class="text-sm text-gray-600 dark:text-gray-200 mt-4">Password</label>
                                    </div>

                                    <input type="password" name="password" id="password" placeholder="Your Password" required autocomplete="current-password"
                                        class="pass_input @error('password') is-invalid @enderror block w-full px-4 py-2 mt-4 text-gray-700 placeholder-gray-400 bg-transparent border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="message_alert text-red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="mt-6">
                                    <button
                                        class="w-full px-4 bg-blue5 py-2 tracking-wide text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                        {{ __('Sign in') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                    <a class="hover:text-blue3 m-auto flex justify-center mt-2" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                </div>
                            </form>

                            <p class="mt-12 text-md text-center text-gray-400">Don&#x27;t have an account yet? <a
                                    href="{{ route('register') }}"
                                    class="text-blue5 text-lg focus:outline-none focus:underline hover:text-blue3">Sign up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

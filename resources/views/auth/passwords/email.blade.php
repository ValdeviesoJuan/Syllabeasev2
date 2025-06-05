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

<body class="bg-slate-100">
    <section class="relative flex flex-wrap lg:h-screen lg:items-center">
        <div class="w-full px-4 py-12 sm:px-6 sm:py-16 lg:w-1/2 lg:px-8 lg:py-24">
            <div class="mx-auto max-w-lg text-center">
                <h1 class="text-2xl font-bold sm:text-3xl">Forgot Password</h1>

                <p class="mt-4 text-gray-500 text-md">
                    Already have an account? <a class="text-blue5 text-lg hover:underline" href="{{ route('login') }}">Sign in</a>
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="mx-auto mb-0 mt-8 max-w-md space-y-4">
                <div>
                    <label for="email" class="sr-only">Email</label>

                    <div class="relative">
                        <input type="email" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong class="invalid_text">{{ $message }}</strong>
                                </span>
                            @enderror

                        <span class="absolute inset-y-0 end-0 grid place-content-center px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="send_btn text-lg flex justify-center bg-blue3 hover:bg-blue5 text-white p-4 rounded-lg">
                    <button type="submit" class="btn_text text-center cursor-pointer ">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>

                <div class="flex justify-center">
                    <div class=" mt-12">
                        <p class="text-md text-gray-500">
                            No account?
                            <a class="text-blue5 text-lg hover:underline" href="{{ route('register') }}">Sign up</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <div class=" bg-blue5 relative h-64 w-full sm:h-96 lg:h-full lg:w-1/2">
            <img alt=""
                src="/assets/forgotpass-vector.png"
                class="absolute inset-0 h-full w-full object-cover" />
        </div>
    </section>
</body>

</html>

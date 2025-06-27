<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
</head>



<body>
    <div class="min-h-screen flex">
        <!-- Left: Full Image -->
        <div class="hidden lg:block lg:w-1/2 h-screen pr-8">
            <img src="/assets/reg-img1.png" alt="Register"
            class="w-full h-full object-cover" style="object-position: 1% center;" />
        </div>
        <!-- Right: Form -->
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 min-h-screen bg-white">
            <div class="w-full max-w-md">
                <div class="text-center">
                    <img class="w-64 m-auto" src="/assets/Sample/syllabease.png" alt="">
                    <p class="mt-3 text-gray-500 dark:text-gray-300">Please fill out all the fields.</p>
                </div>
                <form class="reg-form" id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="rounded p-4 mb-6 bg-white bg-opacity-90">
                        <div class="mt-4">
                            <div class="lg:col-span-4">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-2">
                                    <div>
                                        <label for="id">Employee Number</label>
                                        <input id="id" type="text"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('id') is-invalid @enderror"
                                            name="id" value="{{ old('id') }}" required autocomplete="id"
                                            autofocus />
                                    </div>
                                    <div>
                                        <label for="firstname">First Name</label>
                                        <input id="firstname" type="text"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('firstname') is-invalid @enderror"
                                            name="firstname" value="{{ old('firstname') }}" required
                                            autocomplete="firstname" autofocus />
                                    </div>
                                    <div>
                                        <label for="lastname">Last Name</label>
                                        <input type="text" id="lastname"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('lastname') is-invalid @enderror"
                                            name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname"
                                            autofocus />
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="w-1/2">
                                            <label for="prefix">Prefix</label>
                                            <input type="text" name="prefix" id="prefix" placeholder="ex. Engr."
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                                value="{{ old('prefix') }}" autofocus />
                                        </div>
                                        <div class="w-1/2">
                                            <label for="suffix">Suffix</label>
                                            <input type="text" name="suffix" id="suffix" placeholder="ex. PhD"
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                                value="{{ old('suffix') }}" autofocus />
                                        </div>
                                    </div>
                                    <div>
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" required autocomplete="phone" autofocus
                                            placeholder="09xxxxxxxxx" />
                                    </div>
                                    <div>
                                        <label for="email">Email Address</label>
                                        <input type="text" name="email" id="email"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="example@gmail.com" />
                                    </div>
                                    <div>
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('password') is-invalid @enderror"
                                            value="" required autocomplete="new-password" placeholder="" />
                                    </div>
                                    <div>
                                        <label for="password-confirm">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password-confirm"
                                            class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required
                                            autocomplete="new-password" placeholder="" />
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <div class="errormessage">
                                        @foreach (['id', 'firstname', 'lastname', 'phone', 'email', 'password', 'suffix', 'prefix'] as $field)
                                            @error($field)
                                                <p class="text-red-500 text-xs mt-1" role="alert">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="submit"
                                class="bg-blue5 hover:bg-blue-700 text-white font-semibold py-2 px-12 rounded transition-colors duration-200">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <div class="m-auto flex justify-center mt-4">
                            Already Have an Account?
                            <a class="text-blue5 font-semibold hover:underline ml-2" href="{{ route('login') }}">Sign In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

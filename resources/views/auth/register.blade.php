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

<style>
    /* body {
        background-image: url('../assets/reg-img1.png');
        background-repeat: no-repeat;
        background-size: cover;
        margin: 0%;
        background-attachment: fixed;
    } */

    @media (max-width: 768px) {
        body {
            background-size: contain;
        }
    }

</style>

<body>
    <div class="">
        <div class="dark:bg-gray-900">
            <div class="flex justify-center h-screen bg-white">
                <div class="hidden bg-cover lg:block lg:w-6/12 opacity-85"
                    style="background-image: url('/assets/reg-img1.png')">
                    <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40"></div>
                </div>

                <div class="flex items-center w-full max-w-3xl px-6 mx-auto lg:w-2/2">
                    <div class="flex-1">
                        <div class="text-center">
                            <img class="w-96 m-auto" src="/assets/Sample/syllabease.png" alt="">
                            <p class="mt-3 text-gray-500 dark:text-gray-300">Please fill out all the fields.</p>
                        </div>

                        <div class="">
                            <form class="reg-form" id="register-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="rounded p-4 px-4 md:p-1 mb-6">
                                    <div class="mt-4">
                                        {{-- <div class="text-gray-600 pb-4">
                                            <p class="font-medium text-3xl">Personal Details</p>
                                            <p>Please fill out all the fields.</p>
                                        </div> --}}
                
                                        <div class="lg:col-span-4">
                                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                                <div class="md:col-span-5">
                                                    <label for="id">Employee Number</label>
                                                    <input id="id" type="text"
                                                        class="h-10 @error('id') is-invalid @enderror border mt-1 rounded px-4 w-full bg-gray-50"
                                                        name="id" value="{{ old('id') }}" required autocomplete="id"
                                                        autofocus />
                                                </div>
                
                                                <div class="md:col-span-5">
                                                    <label for="firstname">First Name</label>
                                                    <input id="firstname" type="text"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('firstname') is-invalid @enderror"
                                                        name="firstname" value="{{ old('firstname') }}" required
                                                        autocomplete="firstname" autofocus />
                                                </div>
                
                                                <div class="md:col-span-5">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" id="lastname"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('lastname') is-invalid @enderror"
                                                        name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname"
                                                        autofocus />
                                                </div>
                
                                                <div class="md:col-span-2">
                                                    <label for="prefix">Prefix</label>
                                                    <input type="text" name="prefix" id="prefix" placeholder="ex. Engr."
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                                        value="{{ old('prefix') }}" autofocus placeholder="" />
                                                </div>
                
                                                <div class="md:col-span-3">
                                                    <label for="suffix">Suffix</label>
                                                    <input type="text" name="suffix" id="suffix" placeholder="ex. PhD"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                                        value="{{ old('suffix') }}" autofocus />
                                                </div>
                
                                                <div class="md:col-span-5">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('phone') is-invalid @enderror"
                                                        value="{{ old('phone') }}" required autocomplete="phone" autofocus
                                                        placeholder="09xxxxxxxxx" />
                                                </div>
                
                                                <div class="md:col-span-5">
                                                    <label for="email">Email Address</label>
                                                    <input type="text" name="email" id="email"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" required autocomplete="email"
                                                        placeholder="example@gmail.com" />
                                                </div>
                
                                                <div class="md:col-span-3">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" id="password"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 @error('password') is-invalid @enderror"
                                                        value="" required autocomplete="new-password" placeholder="" />
                                                </div>
                
                                                <div class="md:col-span-2">
                                                    <label for="password-confirm">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" id="password-confirm"
                                                        class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required
                                                        autocomplete="new-password" placeholder="" />
                                                </div>
                                                <div class="errormessage">
                                                    @foreach (['id', 'firstname', 'lastname', 'phone', 'email', 'password', 'suffix', 'prefix'] as $field)
                                                        @error($field)
                                                            <p class="" role="alert">
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
                                            class="bg-blue5 hover:bg-blue3 text-white font-semibold py-2 px-12 rounded">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                    <div class="m-auto flex justify-center mt-4">
                                        Already Have an Account? <a class=" hover:underline text-blue5 ml-2" href="{{ route('login') }}">Sign In</a> 
                                    </div>                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

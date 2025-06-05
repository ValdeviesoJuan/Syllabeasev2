@extends('layouts.allNav')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="/css/edit_user.css"> -->
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-image: url("{{ asset('assets/wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain;
        }
        </style>
</head>

<body>
    <div class="min-h-screen -mt-[120px] flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] w-[560px] p-6 px-8 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-4 w-[300px] m-auto mb-6" src="/assets/Change Password.png" alt="SyllabEase Logo">
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="ml-11">
                                <div class="form-group">
                                    <label class="flex" for="current_password">Current Password</label>
                                    <input type="password" class="form-control px-1 py-[6px] w-[300px] border rounded border-gray" px-1 py-[6px] w-[300px] border rounded border-gray @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required autocomplete="current-password" autofocus>
                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="flex" for="new_password">New Password</label>
                                    <input type="password" class="form-control px-1 py-[6px] w-[300px] border rounded border-gray" @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required autocomplete="new-password">
                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="flex" for="new_password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control px-1 py-[6px] w-[300px] border rounded border-gray" id="new_password_confirmation" name="new_password_confirmation" required autocomplete="new-password-confirmation">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary text-white font-semibold px-6 py-2 rounded-lg m-2 mt-8 mb-4 bg-blue">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 left-0 w-2/6 shadow-2xl pop-up bg-opacity-50 m-3">
    @if (session('success'))
    <div class="bg-green2 border border-green text-green px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}.</span>
    </div>
    @elseif (session('error'))
    <div role="alert">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Error
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <p>{{ session('error') }}.</p>
        </div>
    </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $('.pop-up').fadeIn();
        setTimeout(function() {
            $('.pop-up').fadeOut();
        }, 2000);
    });
</script>
</body>

</html>

@endsection
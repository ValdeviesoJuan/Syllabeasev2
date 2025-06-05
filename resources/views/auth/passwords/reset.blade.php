<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/confirm_pass.css">
    <title>Reset Password Page</title>
</head>
<body>
    

<div class="container">
    <div class="">
        <div class="resetPass_container">
            <div class="card">
                <img class="syllab_logo" src="/assets/Sample/syllabease.png" alt="SyllabEase Logo">
                <div class="resetpass_text">{{ __('Reset Password') }}</div><br>


                {{-- Reset pass token message alert --}}
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong class="token_alert">{{ $message }}</strong>
                    </span>
                @enderror

                {{-- password message alert --}}
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong class="message_alert">{{ $message }}</strong>
                    </span>
                @enderror

                <div class="reset_pass_container">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="email" type="email" class="resetpass_input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                <br>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="password" placeholder="password" type="password" class="resetpass_input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            
                                
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input id="password-confirm" placeholder="confirm password" type="password" class="resetpass_input" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div><br>

                        <div class="send_btn">
                            <button type="submit" class="btn_text">
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                        <div class="backbtn">
                            <a class="goback" href="/login" id="haveAcc">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
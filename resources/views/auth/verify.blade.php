<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="/css/emailver.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sample/se.png') }}">
</head>

<body>

    <div class="container">
        <nav class="syllabease_navbar">
            <div class="syllabeaseLogo">
                <img class="syllab_logo" src="/assets/Sample/syllabease.png" alt="">

                <div class="logout">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="flex text-black hover:text-black px-4 py-3 hover:bg-seThird">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </nav>
    </div>

    <div class="container_card">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="emailcon">
                    <div class="card">
                        <img class="emailver_logo" src="/assets/check-mail.png" alt="Email verification">
                        <div class="header">Verify Your Email Address</div>

                        <div class="card-body" id="alert">
                            @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                            @endif
                            A fresh verification link has been sent to your
                            email address. Before proceeding, please check your email for a verification link.
                            If you did not receive the email
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                            <div class="btncontainer"> 
                                <button type="submit" id="submit" class="clickbtn btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>
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
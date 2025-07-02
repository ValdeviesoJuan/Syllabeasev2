@extends('layouts.allNav')
@section('content')
@include('layouts.accessModal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Home Page</title>
    <link rel="stylesheet" href="/css/home_user.css">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            background-image: url("{{ asset('assets/ustp_pic.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            image-rendering: auto; 
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(248, 189, 12, 0.18);
            z-index: 0;
            pointer-events: none; 
        }

        .login-container {
            position: relative;
            background: #faf6e8;
            border-radius: 16px;
            padding: 32px 24px;
            max-width: 460px;
            margin: 60px auto;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            z-index: 1;
        }

        .login-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: #333;
        }

        .role-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(4, auto);
            gap: 16px;
            width: 100%;
            max-width: 400px;
        }

        .role-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #d7ecf9;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 1rem;
            color: #1a3557;
            font-weight: 500;
            min-width: 0;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .role-btn:hover {
            background: #c3dff3;
        }

        .role-icon {
            font-size: 1.4rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img class="mx-auto mb-4 w-[240px]" src="/assets/Sample/syllabease.png" alt="SyllabEase">
        
        <div class="login-title">Login as</div>

        @php
            $href = '';
            $roleCount = count($myRoles);

            if ($roleCount == 1) {
                $myRole = $myRoles[0];

                switch ($myRole->role_id) {
                    case 1: $href = route('admin.home'); break;
                    case 2: $href = route('dean.home'); break;
                    case 3: $href = route('chairperson.home'); break;
                    case 4: $href = route('bayanihanleader.home'); break;
                    case 5: $href = route('bayanihanteacher.home'); break;
                    case 6: $href = route('auditor.home'); break;
                    default: $href = '#'; break;
                }

                echo "<script>window.location.href = '{$href}';</script>";
            }
        @endphp

        @php
            $userHasAccount = isset($myRoles) && count($myRoles) > 0;

            if (!$userHasAccount) {
                // Default role if no roles are assigned
                $myRoles = [
                    (object)[
                        'role_id' => 1,
                        'role_name' => 'Admin'
                    ]
                ];
            }
        @endphp

        <div class="role-buttons">
            <div class="role-grid">
                @foreach($myRoles as $myRole)
                    @php
                        $href = match($myRole->role_id) {
                            1 => route('admin.home'),
                            2 => route('dean.home'),
                            3 => route('chairperson.home'),
                            4 => route('bayanihanleader.home'),
                            5 => route('bayanihanteacher.home'),
                            6 => route('auditor.home'),
                            default => '#',
                        };

                        $icons = [
                            1 => 'fa-solid fa-user-shield',      
                            2 => 'fa-solid fa-user-graduate',    
                            3 => 'fa-solid fa-briefcase',        
                            4 => 'fa-solid fa-people-group',     
                            5 => 'fa-solid fa-chalkboard-user', 
                            6 => 'fa-solid fa-user-check',       
                        ];
                        $icon = $icons[$myRole->role_id] ?? 'fa-solid fa-key';
                    @endphp

                    <a href="{{ $href }}" class="role-btn">
                        <span class="role-icon"><i class="{{ $icon }}"></i></span>
                        {{ $myRole->role_name }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</body>
</html>
@endsection

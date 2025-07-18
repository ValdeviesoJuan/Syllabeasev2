@extends('layouts.blSidebar')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
</head>

    @if(auth()->user())
        @php
            $notif = auth()->user()->unreadNotifications
                ->where('type', \App\Notifications\DeadlineSetNotification::class)
                ->first();
        @endphp

        @if($notif)
            <div id="floating-alert" class="fixed top-6 right-6 bg-[#FEF3C7] border-l-4 border-[#F59E0B] text-[#92400E] px-6 py-4 rounded shadow-lg z-50 w-96 flex items-start space-x-3">
                <!-- Icon -->
                <svg class="w-6 h-6 text-[#F59E0B] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>

                <!-- Message -->
                <div class="flex-1 text-sm font-medium">
                    {{ $notif->data['message'] ?? 'New Notification' }}
                </div>

                <!-- Dismiss Button -->
                <button onclick="dismissNotif('{{ route('notifications.markRead', ['id' => $notif->id]) }}')"
                        class="ml-4 text-sm text-[#92400E] hover:text-[#B45309] font-semibold underline">
                    Dismiss
                </button>
            </div>

            <script>
                function dismissNotif(url) {
                    fetch(url)
                        .then(() => {
                            document.getElementById('floating-alert')?.remove();
                        });
                }
            </script>
        @endif
    @endif
<body>
    <div class="mt-[6%] ml-[4px]">
        <livewire:b-l-create-tos />
    </div>
    <div class="m-auto pb-12 p-8 bg-white mt-[10px] p-2 shadow-lg rounded  w-11/12">
        <div class="flex justify-center align-items-center">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden mb-6">
                    <div class="font-bold text-4xl text-[#201B50]"> Table of Specifications </div>
                </div>
            </div>
        </div>
        <livewire:b-l-tos />
    </div>
</body>

</html>
@endsection

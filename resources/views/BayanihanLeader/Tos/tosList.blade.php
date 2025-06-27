<!-- @-extends('layouts.blNav') -->
@extends('layouts.blSidebar')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
                {{-- <div class="-ml-[1.5%] -mt-[10px] mb-6">
                        <livewire:b-l-create-tos />
                    </div> --}}
            </div>

        </div>
        <livewire:b-l-tos />
        <!-- <div class='overflow-x-auto w-full'>
            <table class='border-collapse py-12 w-[95%] bg-white border m-auto justify-center'>
                <thead class="bg-gray-900">
                    <tr class="bg-blue text-white text-left text-lg pb-2 border border-black">
                        <th class="font-bold text-sm uppercase px-6 py-4"> Term </th>
                        <th class="font-bold text-sm uppercase px-6 py-4"> School Year </th>
                        <th class="font-bold text-sm uppercase px-6 py-4"> Semester </th>
                        <th class="font-bold text-sm uppercase px-6 py-4 text-center"> Course Code </th>
                        <th class="font-bold text-sm uppercase px-6 py-4"> Status </th>
                        <th class="font-bold text-sm uppercase px-6 py-4 text-center"> </th>
                        {{-- <th class="font-bold text-sm uppercase px-6 py-4"> </th> --}}
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#e5e7eb] bg-[#f9fafb]">
                    @foreach($toss as $tos)
                    <tr>
                        <td class="px-6 py-4 font-bold">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p>{{$tos->tos_term}}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <p class=""> {{$tos->bg_school_year}}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class=""> {{$tos->course_semester}}</p>
                        </td>

                        <td class="px-6 py-4 text-center"> <span class="">{{$tos->course_code}}</span> </td>
                        <td class="px-6 py-4">
                            <p class=""> {{$tos->tos_status}}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- <form action="{{ route('admin.editCurr', $curriculum->curr_id) }}" method="GET"> --}}
                            @csrf
                            <a href="{{ route('bayanihanleader.viewTos', $tos->tos_id) }}" class="bg-blue px-4 py-1 rounded-lg text-sm shadow-lg text-white uppercase">
                                view</a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}} -->
        </div>
    </div>
    </div>
</body>

</html>
@endsection

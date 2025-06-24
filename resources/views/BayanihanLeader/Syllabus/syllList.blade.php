<!-- @-extends('layouts.blNav') -->
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
                background-color: #EEEEEE;
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
        <div class="m-auto p-8 bg-white mt-[5%] shadow-lg rounded-lg  w-11/12">
            <span class="flex flex-block justify-between items-center">
                <h1 class="font-bold text-4xl text-[#201B50] mb-8">List of Syllabus</h1>
                <div
                    class="mb-5 ml-11 mt-2 pt-2 w-[200px] hover:scale-105 transition ease-in-out bg-blue3 py-2 text-white rounded px-2 hover:bg-blue shadow-lg">
                    <form action="{{ route('bayanihanleader.createSyllabus') }}" method="GET">
                        @csrf
                        <button type="submit" class="flex m-auto text-ml gap-2">
                            <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5"
                                    stroke-linecap="round"></path>
                                <path
                                    d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7"
                                    stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                            <div class="right-0 justify-end">
                                Create Syllabus
                            </div>
                        </button>
                    </form>
                </div>
            </span>
            <livewire:b-l-syllabus-table />
        </div>
        </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var syll = <?php echo json_encode($syll ?? null); ?>;
                var dueDate = syll && syll.dl_syll ? new Date(syll.dl_syll) : null;

                if (dueDate) {
                    function updateRemainingTime() {
                        var now = new Date();
                        var timeDifference = dueDate - now;
                        var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                        var remainingTimeElement = document.getElementById('remaining-time');
                        remainingTimeElement.innerText = 'Remaining: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' +
                            seconds + 's';
                    }

                    updateRemainingTime();
                    setInterval(updateRemainingTime, 1000);
                }
            });
        </script>
    </body>

    </html>
@endsection
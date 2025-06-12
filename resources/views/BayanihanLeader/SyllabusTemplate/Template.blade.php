
@extends('layouts.blNav')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <style>
        body {
            background-color: #eaeaea;
        }

        .resize {
            resize: both;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-3xl font-bold mb-6 text-center text-blue-700">SyllabEase: Syllabus Builder</h1>

        {{-- Countdown Timer (if any) --}}
        <div id="remaining-time" class="text-right text-sm text-gray-600 mb-4"></div>

        {{-- Draggable, Resizable Sections --}}
        <div id="syllabus-sections" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach ($sections as $section)
                <div 
                    class="section-item resize overflow-auto min-w-[200px] min-h-[100px] max-w-full max-h-[600px] bg-gray-100 p-4 rounded-lg shadow cursor-move"
                    data-id="{{ $section['id'] }}"
                >
                    <h3 class="font-semibold text-lg mb-2">{{ $section['name'] }}</h3>
                    <textarea class="w-full border border-gray-300 rounded p-2 resize-none" rows="3" placeholder="Enter content..."></textarea>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-6">
            <button 
                id="saveOrderBtn" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Save Section Order
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Countdown Timer
            var syll = @json($syll ?? null);
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
                    remainingTimeElement.innerText = 'Remaining: ' + days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
                }

                updateRemainingTime();
                setInterval(updateRemainingTime, 1000);
            }

            // SortableJS
            const el = document.getElementById('syllabus-sections');
            new Sortable(el, {
                animation: 150,
                swap: true,
                swapClass: 'bg-yellow-100'
            });

            // Save Order Button
            document.getElementById('saveOrderBtn').addEventListener('click', () => {
                const sectionOrder = Array.from(el.children).map(item => item.dataset.id);

                fetch("{{ route('save.section.order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ order: sectionOrder })
                })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => alert('Something went wrong.'));
            });
        });
    </script>
</body>
</html>

@endsection
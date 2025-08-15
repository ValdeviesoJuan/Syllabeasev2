@extends('layouts.blNav')
@section('content')
@include('layouts.modal')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
    </style>
</head>

<body>
    <div class="flex flex-col justify-center mt-10 mx-auto">
        <div class="relative mt-20 flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-xl shadow-lg p-3 mx-auto border border-white bg-white">
            <div>
                <img class="edit_user_img text-center mt-4 mb-6 w-[250px] m-auto mb-2" src="/assets/Create TOS.png" alt="SyllabEase Logo">
            </div>
            <div class="pl-4 mt-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Course Code: </span>
                <span>{{$syllabus->course_code}}</span>
            </div>

            <div class="pl-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">S.Y. & Semester:</span>
                <span>{{$syllabus->bg_school_year . ' - ' . $syllabus->course_semester}}</span>
            </div>

            <div class="m-8">
                <form action="{{ route('bayanihanleader.storeTos', $syll_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tos_term" class="flex mb-1 font-semibold">Term</label>
                        <select name="tos_term" id="tos_term" class="border border-[#a8a29e] rounded w-[250px] p-2" onchange="toggleTopics()">
                            <option value="Midterm">Midterm</option>
                            <option value="Final">Final</option>
                        </select>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2 mr-6"> 
                        <div class="mb-3">
                            <label for="tos_no_items" class="flex mb-1 font-semibold">Total No. of Test Items</label>
                            <input type="number" name="tos_no_items" id="tos_no_items" class="border border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                        <div class="mb-3">
                            <label for="tos_cpys" class="flex mb-1 font-semibold">Curricular Program/Year/Section</label>
                            <input type="text" name="tos_cpys" id="tos_cpys" class="border border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                    </div>

                    <!-- Midterm Topics -->
                    <div class="mb-6" id="midtermTopicsContainer">
                        <label class="font-semibold block mb-2">Select Midterm Topics</label>
                        <div id="midtermTopicsBox" class="border border-[#a8a29e] bg-white rounded p-4 w-[830px]">
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($midtermTopics as $topic)
                                    <label class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 transition rounded px-3 py-2 border border-[#a8a29e]">
                                        <input type="checkbox" name="selected_topics[]" value="{{ $topic }}" class="accent-blue-600 w-4 h-4" checked>
                                        <span class="text-sm text-gray-700">{{ $topic }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Final Topics -->
                    <div class="mb-6 hidden" id="finalTopicsContainer">
                        <label class="font-semibold block mb-2">Select Final Topics</label>
                        <div id="finalTopicsBox" class="border border-[#a8a29e] bg-white rounded p-4">
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($finalTopics as $topic)
                                    <label class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 transition rounded px-3 py-2 border border-gray-200">
                                        <input type="checkbox" name="selected_topics[]" value="{{ $topic }}" class="accent-blue-600 w-4 h-4" checked>
                                        <span class="text-sm text-gray-700">{{ $topic }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <p class="font-semibold text-xl text-center mb-4">Cognitive Level</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p>Knowledge (Max 50%)</p>
                            <input type="number" name="col_1_per" id="col_1_per" class="cognitive-input border border-[#a8a29e] rounded w-[400px] p-2" min="0" max="50" value="25" required>
                        </div>
                        <div>
                            <p>Comprehension</p>
                            <input type="number" name="col_2_per" id="col_2_per" class="cognitive-input border border-[#a8a29e] rounded w-[400px] p-2" min="0" value="25" required>
                        </div>
                        <div>
                            <p>Application / Analysis</p>
                            <input type="number" name="col_3_per" id="col_3_per" class="cognitive-input border border-[#a8a29e] rounded w-[400px] p-2" min="0" value="25" >
                        </div>
                        <div>
                            <p>Synthesis / Evaluation</p>
                            <input type="number" name="col_4_per" id="col_4_per" class="cognitive-input border border-[#a8a29e] rounded w-[400px] p-2" min="0" value="25" >
                        </div>
                    </div>

                    <div id="feedback" class="text-red font-bold mt-8"></div>
                    <div id="currentTotal" class="font-bold mt-2"></div>

                    <div class="flex justify-center mb-4 mt-4">
                        <button type="submit"
                            class="whitespace-nowrap w-50 rounded-xl hover:scale-105 transition ease-in-out p-2 text-black font-semibold flex items-center gap-2 max-w-full"
                            style="background: #d7ecf9;" onmouseover="this.style.background='#c3dff3';"
                            onmouseout="this.style.background='#d7ecf9';">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8v8M8 12h8" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="1.5"/>
                            </svg>
                            Create TOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    function toggleTopics() {
        const term = document.getElementById('tos_term').value;
        const midtermBox = document.getElementById('midtermTopicsContainer');
        const finalBox = document.getElementById('finalTopicsContainer');

        if (term === 'Midterm') {
            midtermBox.classList.remove('hidden');
            finalBox.classList.add('hidden');
        } else {
            midtermBox.classList.add('hidden');
            finalBox.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleTopics);
</script>

<script>
    const inputs = {
        knowledge: document.getElementById('col_1_per'),
        comprehension: document.getElementById('col_2_per'),
        application: document.getElementById('col_3_per'),
        synthesis: document.getElementById('col_4_per')
    };

    const feedbackDiv = document.getElementById('feedback');
    const currentTotalDiv = document.getElementById('currentTotal');

    Object.values(inputs).forEach(input => {
        input.addEventListener('input', () => {
            if (input.id === 'col_1_per') {
                const val = parseFloat(input.value) || 0;
                if (val > 50) {
                    alert('Knowledge should not exceed 50% as per CITL policy.');
                    input.value = 0;
                }
            }

            let total = 0;
            Object.values(inputs).forEach(inp => {
                total += parseFloat(inp.value) || 0;
            });

            currentTotalDiv.textContent = `Current Total: ${total.toFixed(2)}%`;

            if (total !== 100) {
                feedbackDiv.textContent = 'Total should be 100%';
                feedbackDiv.classList.add('text-red');
            } else {
                feedbackDiv.textContent = '';
                feedbackDiv.classList.remove('text-red');
            }
        });
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        let total = 0;
        Object.values(inputs).forEach(inp => {
            total += parseFloat(inp.value) || 0;
        });

        if (total !== 100) {
            e.preventDefault();
            feedbackDiv.textContent = 'Cannot create TOS. Total must be exactly 100%.';
            feedbackDiv.classList.add('text-red');
        }
    });
</script>

</html>
@endsection

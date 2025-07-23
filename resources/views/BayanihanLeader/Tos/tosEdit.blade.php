@extends('layouts.blNav')
@section('content')
@include('layouts.modal')
<!DOCTYPE html>
<html lang="en">

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
                <img class="edit_user_img text-center mt-4 mb-6 w-[200px] m-auto mb-2" src="/assets/Edit TOS.png" alt="SyllabEase Logo">
            </div>

            <div class="pl-4 mt-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">Course Code: </span>
                <span>{{ $syllabus->course_code }}</span>
            </div>

            <div class="pl-4 ml-4">
                <span style="font-family: 'Roboto', sans-serif; font-weight: bold">S.Y. & Semester:</span>
                <span>{{ $syllabus->bg_school_year . ' - ' . $syllabus->course_semester }}</span>
            </div>

            <div class="m-8">
                <form id="tosForm" action="{{ route('bayanihanleader.updateTos', ['syll_id' => $tos->syll_id, 'tos_id' => $tos_id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- TOS Term Selector (example) -->
                    <div class="mb-6">
                        <label for="tos_term" class="block text-sm font-medium text-gray-700 mb-1">TOS Term</label>
                        <select name="tos_term" id="tos_term" class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                            <option value="Midterm" {{ old('tos_term', $tos->tos_term) === 'Midterm' ? 'selected' : '' }}>Midterm</option>
                            <option value="Final" {{ old('tos_term', $tos->tos_term) === 'Final' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>

                    <!-- Midterm Topics -->
                    <div id="midtermTopicsBox" class="bg-white border border-gray-300 rounded-xl shadow-sm p-4 mb-6 @if(old('tos_term', $tos->tos_term) !== 'Midterm') hidden @endif">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Select Midterm Topics</h4>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($midtermTopics as $topic)
                                <label class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 transition rounded-lg px-3 py-2 border border-gray-200">
                                    <input 
                                        type="checkbox" 
                                        name="selected_topics[]" 
                                        value="{{ $topic }}" 
                                        class="accent-blue-600 w-4 h-4"
                                        @if(in_array($topic, old('selected_topics', $selectedTopics ?? []))) checked @endif
                                    >
                                    <span class="text-sm text-gray-700">{{ $topic }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Final Topics -->
                    <div id="finalTopicsBox" class="bg-white border border-gray-300 rounded-xl shadow-sm p-4 mb-6 @if(old('tos_term', $tos->tos_term) !== 'Final') hidden @endif">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Select Final Topics</h4>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($finalTopics as $topic)
                                <label class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 transition rounded-lg px-3 py-2 border border-gray-200">
                                    <input 
                                        type="checkbox" 
                                        name="selected_topics[]" 
                                        value="{{ $topic }}" 
                                        class="accent-blue-600 w-4 h-4"
                                        @if(in_array($topic, old('selected_topics', $selectedTopics ?? []))) checked @endif
                                    >
                                    <span class="text-sm text-gray-700">{{ $topic }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2 mr-6">
                        <div class="mb-3">
                            <label for="tos_no_items" class="flex">Total No. of Test Items</label>
                            <input type="number" value="{{ $tos->tos_no_items }}" name="tos_no_items" id="tos_no_items" class="border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>

                        <div class="mb-3">
                            <label for="tos_cpys" class="flex">Curricular Program/Year/Section:</label>
                            <input type="text" value="{{ $tos->tos_cpys }}" name="tos_cpys" id="tos_cpys" class="border w-max border-[#a8a29e] rounded w-[400px] p-2" required>
                        </div>
                    </div>

                    <p class="font-semibold text-xl text-center mb-4">Cognitive Level</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p>Knowledge (Max 50%)</p>
                            <input type="number" value="{{ $tos->col_1_per }}" name="col_1_per" id="col_1_per" class="cognitive-input border border-[#a8a29e] rounded w-[200px] p-2" min="0" max="50">
                        </div>
                        <div>
                            <p>Comprehension</p>
                            <input type="number" value="{{ $tos->col_2_per }}" name="col_2_per" id="col_2_per" class="cognitive-input border border-[#a8a29e] rounded w-[200px] p-2" min="0">
                        </div>
                        <div>
                            <p>Application / Analysis</p>
                            <input type="number" value="{{ $tos->col_3_per }}" name="col_3_per" id="col_3_per" class="cognitive-input border border-[#a8a29e] rounded w-[200px] p-2" min="0">
                        </div>
                        <div>
                            <p>Synthesis / Evaluation</p>
                            <input type="number" value="{{ $tos->col_4_per }}" name="col_4_per" id="col_4_per" class="cognitive-input border border-[#a8a29e] rounded w-[200px] p-2" min="0">
                        </div>
                    </div>

                    <div id="feedback" class="text-red font-bold mt-8"></div>
                    <div id="currentTotal" class="font-bold mt-2"></div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary font-semibold text-white px-6 py-2 rounded-lg m-2 mt-30 mb-4 bg-blue">Update TOS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById('tos_term').addEventListener('change', function () {
        const term = this.value;
        const midtermBox = document.getElementById('midtermTopicsBox');
        const finalBox = document.getElementById('finalTopicsBox');

        if (term === 'Midterm') {
            midtermBox.classList.remove('hidden');
            finalBox.classList.add('hidden');
        } else if (term === 'Final') {
            finalBox.classList.remove('hidden');
            midtermBox.classList.add('hidden');
        }
    });
</script>

<script>
    document.getElementById('tos_term').addEventListener('change', function () {
        const term = this.value;
        const midtermBox = document.getElementById('midtermTopicsBox');
        const finalBox = document.getElementById('finalTopicsBox');

        if (term === 'Midterm') {
            midtermBox.classList.remove('hidden');
            finalBox.classList.add('hidden');
        } else if (term === 'Final') {
            finalBox.classList.remove('hidden');
            midtermBox.classList.add('hidden');
        }
    });

    // Ensure correct box shows on initial page load
    document.getElementById('tos_term').dispatchEvent(new Event('change'));
</script>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const inputs = {
            knowledge: document.getElementById('col_1_per'),
            comprehension: document.getElementById('col_2_per'),
            application: document.getElementById('col_3_per'),
            synthesis: document.getElementById('col_4_per')
        };

        const feedbackDiv = document.getElementById('feedback');
        const currentTotalDiv = document.getElementById('currentTotal');
        const form = document.getElementById('tosForm');

        function updateTotal() {
            let total = 0;
            Object.values(inputs).forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            currentTotalDiv.textContent = `Current Total: ${total.toFixed(2)}%`;
            if (total !== 100) {
                feedbackDiv.textContent = 'Total should be 100%';
            } else {
                feedbackDiv.textContent = '';
            }
        }

        Object.values(inputs).forEach(input => {
            input.addEventListener('input', () => {
                if (input.id === 'col_1_per' && parseFloat(input.value) > 50) {
                    alert('Knowledge should not exceed 50%');
                    input.value = 50;
                }
                updateTotal();
            });
        });

        form.addEventListener('submit', (e) => {
            let total = 0;
            Object.values(inputs).forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            if (total !== 100) {
                alert('Total should not exceed 100%');
                e.preventDefault();
                feedbackDiv.textContent = 'Cannot update TOS. Total must be exactly 100%.';
            }
        });

        updateTotal();
    });
</script>

</html>
@endsection

@extends('layouts.blNav')
@section('content')
@include('layouts.modal')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabease</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }
        table,
        tbody,
        tr,
        td,
        th{
            border: 1px solid black;
        }
    </style>

</head>

<body>
    <div class="pt-9 pb-2">
        <div class="flex flex-col border-2 border-green3 bg-white bg-opacity-75 w-[500px] rounded-lg h-[70px] mx-auto">
            <p class="text-center mt-1">
                The cells within the cognitive level are designed to be editable, allowing users to input and modify information as needed.
            </p>
        </div>
    </div>

    <div class="p-2 justify-center m-auto text-center">
        <div class="relative mt-2 w-[90%] flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-l shadow-lg p-12 mx-auto border border-white bg-white">
            <div>
                <button class="bg-blue text-white px-4 py-2 rounded-lg shadow-lg hover:scale-105 w-max transition ease-in-out" id="roundButton">Round Values</button>

                <form id="tosForm" method="post" action="{{ route('bayanihanleader.updateTosRow', $tos->tos_id) }}">
                    @csrf
                    @method('PUT')
                    <!-- TOS Table -->
                    <table id="tosTable" class="mt-4 w-full table-fixed border border-black bg-white text-sm font-serif">
                        <thead>
                            <tr>
                                <th class="w-[25%] px-2 py-1 border" rowspan="3">Topics</th>
                                <th class="w-[5%] px-2 py-1 border" rowspan="3">No. of<br>Hours</th>
                                <th class="w-[5%] px-2 py-1 border" rowspan="3">%</th>
                                <th class="w-[5%] px-2 py-1 border" rowspan="3">No. of<br>Test Items</th>
                                <th colspan="4" class="w-[45%] px-2 py-1 border text-center">Cognitive Level</th>
                                <th rowspan="2" class="w-[10%] px-2 py-1 border"></th>
                            </tr>
                            <tr> 
                                <th class="border">Knowledge</th>
                                <th class="border">Comprehension</th>
                                <th class="border">Application /<br>Analysis</th>
                                <th class="border">Synthesis /<br>Evaluation</th>
                            </tr>
                            <tr> 
                                <th class="border">{{$tos->col_1_per}}%</th>
                                <th class="border">{{$tos->col_2_per}}%</th>
                                <th class="border">{{$tos->col_3_per}}%</th>
                                <th class="border">{{$tos->col_4_per}}%</th>
                                <th class="border">Actual Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($tos_rows) > 0)
                                @foreach($tos_rows as $tos_row)
                                <tr class="hover:bg-gray-50">
                                    <input type="hidden" name="tos_r_id[]" value="{{ $tos_row->tos_r_id }}">
                                    <td class="border px-2 text-left align-center text-center">{{ $tos_row->tos_r_topic }}</td>
                                    <td class="border text-center align-center">{{ $tos_row->tos_r_no_hours }}</td>
                                    <td class="border text-center align-center">{{ $tos_row->tos_r_percent }}</td>
                                    <td class="border text-center align-center">
                                        <input type="number" name="tos_r_no_items[]" value="{{ $tos_row->tos_r_no_items }}" 
                                            class="w-full text-base text-center " step="1" and min="0" />
                                    </td>
                                    <td class="border text-center align-top">
                                        <input type="number" name="tos_r_col_1[]" value="{{ $tos_row->tos_r_col_1 }}" 
                                            class="w-full text-center" step="1" and min="0" />
                                    </td>
                                    <td class="border text-center align-top">
                                        <input type="number" name="tos_r_col_2[]" value="{{ $tos_row->tos_r_col_2 }}" 
                                            class="w-full text-center" step="1" and min="0" />
                                    </td>
                                    <td class="border text-center align-top">
                                        <input type="number" name="tos_r_col_3[]" value="{{ $tos_row->tos_r_col_3 }}" 
                                            class="w-full text-center" step="1" and min="0" />
                                    </td>
                                    <td class="border text-center align-top">
                                        <input type="number" name="tos_r_col_4[]" value="{{ $tos_row->tos_r_col_4 }}" 
                                            class="w-full text-center" step="1" and min="0" />
                                    </td>
                                    <td class="border text-center align-top" id="individualRowTotal"> </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center border py-2">No data available</td>
                            </tr>
                            @endif

                            <tr class="bg-gray-100 font-semibold">
                                <td class="text-right px-2 py-1 border">Actual Total:</td>
                                <td class="text-center border"></td>
                                <td class="text-center border"></td>
                                <td class="text-center border underline" id="actualTotalItems"></td>
                                <td class="text-center border underline" id="totalCol1"></td>
                                <td class="text-center border underline" id="totalCol2"></td>
                                <td class="text-center border underline" id="totalCol3"></td>
                                <td class="text-center border underline" id="totalCol4"></td>
                                <td class="text-center border underline" id="actualRowTotal"></td>
                            </tr>
                            <tr class="bg-gray-100 font-semibold">
                                <td class="text-right px-2 py-1 border">Expected Total:</td>
                                <td class="text-center border"></td>
                                <td class="text-center border"></td>
                                <td class="text-center border">{{$tos->tos_no_items}}</td>
                                <td class="text-center border">{{$tos->col_1_exp}}</td>
                                <td class="text-center border">{{$tos->col_2_exp}}</td>
                                <td class="text-center border">{{$tos->col_3_exp}}</td>
                                <td class="text-center border">{{$tos->col_4_exp}}</td>
                            </tr>
                            <input type="hidden" id="expectedItems" value="{{ $tos->tos_no_items }}">
                        </tbody>
                    </table>

                    <button type="submit"
                        class="mt-4 bg-blue text-white px-4 py-2 rounded-lg shadow-lg hover:scale-105 transition ease-in-out">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    function roundInputs() {
        const fieldsToRound = [
            'tos_r_no_items[]',
            'tos_r_col_1[]',
            'tos_r_col_2[]',
            'tos_r_col_3[]',
            'tos_r_col_4[]'
        ];

        fieldsToRound.forEach(fieldName => {
            document.querySelectorAll(`input[name="${fieldName}"]`).forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    input.value = Math.round(val);
                }
            });
        });
    }

    function calculateTotals() {
        let totalCol1 = 0, totalCol2 = 0, totalCol3 = 0, totalCol4 = 0, totalItems = 0;

        const rows = document.querySelectorAll('#tosTable tbody tr');
        rows.forEach(row => {
            const col1 = row.querySelector('input[name="tos_r_col_1[]"]');
            const col2 = row.querySelector('input[name="tos_r_col_2[]"]');
            const col3 = row.querySelector('input[name="tos_r_col_3[]"]');
            const col4 = row.querySelector('input[name="tos_r_col_4[]"]');
            const items = row.querySelector('input[name="tos_r_no_items[]"]');

            // Parse values or default to 0
            const val1 = col1 ? parseInt(col1.value) || 0 : 0;
            const val2 = col2 ? parseInt(col2.value) || 0 : 0;
            const val3 = col3 ? parseInt(col3.value) || 0 : 0;
            const val4 = col4 ? parseInt(col4.value) || 0 : 0;
            const itemVal = items ? parseInt(items.value) || 0 : 0;

            totalCol1 += val1;
            totalCol2 += val2;
            totalCol3 += val3;
            totalCol4 += val4;
            totalItems += itemVal;

            const rowTotal = val1 + val2 + val3 + val4;
            const totalCell = row.querySelector('#individualRowTotal');
            if (totalCell) {
                totalCell.textContent = rowTotal;
            }
        });

        const expectedItems = parseInt(document.getElementById('expectedItems').value) || 0;
        const actualRowTotal = totalCol1 + totalCol2 + totalCol3 + totalCol4;

        // Set values
        document.getElementById('totalCol1').textContent = totalCol1;
        document.getElementById('totalCol2').textContent = totalCol2;
        document.getElementById('totalCol3').textContent = totalCol3;
        document.getElementById('totalCol4').textContent = totalCol4;
        document.getElementById('actualRowTotal').textContent = totalCol1 + totalCol2 + totalCol3 + totalCol4;
        document.getElementById('actualTotalItems').textContent = totalItems;

        // Color feedback
        const actualRowEl = document.getElementById('actualRowTotal');
        const actualItemsEl = document.getElementById('actualTotalItems');

        if (actualRowTotal !== expectedItems) {
            actualRowEl.classList.add('text-red', 'font-bold');
        } else {
            actualRowEl.classList.remove('text-red', 'font-bold');
        }

        if (totalItems !== expectedItems) {
            actualItemsEl.classList.add('text-red', 'font-bold');
        } else {
            actualItemsEl.classList.remove('text-red', 'font-bold');
        }

        // Return if valid or not
        return actualRowTotal === expectedItems && totalItems === expectedItems;
    }

    // On DOM load (Page Load)
    document.addEventListener('DOMContentLoaded', function () {
        roundInputs();      // ⬅️ Automatically round values on page load
        calculateTotals();  // ⬅️ Then calculate totals

        // Recalculate on input change
        document.querySelectorAll('#tosTable input[type="number"]').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        // Button handler to round again manually
        document.getElementById('roundButton').addEventListener('click', function () {
            roundInputs();
            calculateTotals();
        });

        // ✅ Form submit prevention (NOW inside DOMContentLoaded)
        const form = document.getElementById('tosForm')
        if (form) {
            form.addEventListener('submit', function (e) {
                console.log("Submitting...");
                if (!calculateTotals()) {
                    e.preventDefault();
                    alert('Cannot submit: Actual totals do not match expected values.');
                }
            });
        }
    });
</script>
@endsection
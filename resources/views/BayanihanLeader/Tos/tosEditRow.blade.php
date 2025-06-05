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
        <div class="relative mt-2 w-[80%] flex flex-col bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-xl shadow-lg p-12 mx-auto border border-white bg-white">
            <livewire:b-l-tos-edit :tos_id="$tos_id" />
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Listen for input changes on all number input fields
            $('input[type="number"]').on('input', function() {
                updateTotals();
                updateCol();
            });

            // Initial calculation of totals on page load
            updateTotals();
            updateCol();

            function updateCol() {
                var expcol1 = parseFloat($('#expCol1').text()) || 0;
                var expcol2 = parseFloat($('#expCol2').text()) || 0;
                var expcol3 = parseFloat($('#expCol3').text()) || 0;
                var expcol4 = parseFloat($('#expCol4').text()) || 0;

                var totalCol1 = parseFloat($('#totalCol1').text()) || 0;
                var inputCol1 = parseFloat($('input#col1').text()) || 0;

                var totalCol2 = parseFloat($('#totalCol2').text()) || 0;
                var inputCol2 = parseFloat($('input#col2').text()) || 0;

                var totalCol3 = parseFloat($('#totalCol3').text()) || 0;
                var inputCol3 = parseFloat($('input#col3').text()) || 0;

                var totalCol4 = parseFloat($('#totalCol4').text()) || 0;
                var inputCol4 = parseFloat($('input#col4').text()) || 0;

                if (totalCol1 !== expcol1) {
                    $('#totalCol1').css('color', 'red'); // Change to your desired color
                    $('input#col1').css('color', 'red'); // Change to your desired color
                } else {
                    $('#totalCol1').css('color', ''); // Reset to default color
                    $('input#col1').css('color', ''); // Change to your desired color
                }
                if (totalCol2 !== expcol2) {
                    $('#totalCol2').css('color', 'red'); // Change to your desired color
                    $('input#col2').css('color', 'red'); // Change to your desired color
                } else {
                    $('#totalCol2').css('color', ''); // Reset to default color
                    $('input#col2').css('color', ''); // Change to your desired color
                }
                if (totalCol3 !== expcol3) {
                    $('#totalCol3').css('color', 'red'); // Change to your desired color
                    $('input#col3').css('color', 'red'); // Change to your desired color
                } else {
                    $('#totalCol3').css('color', ''); // Reset to default color
                    $('input#col3').css('color', ''); // Change to your desired color
                }
                if (totalCol4 !== expcol4) {
                    $('#totalCol4').css('color', 'red'); // Change to your desired color
                    $('input#col4').css('color', 'red'); // Change to your desired color
                } else {
                    $('#totalCol4').css('color', ''); // Reset to default color
                    $('input#col4').css('color', ''); // Change to your desired color
                }
            }

            function updateTotals() {
                var totalCol1 = 0,
                    totalCol2 = 0,
                    totalCol3 = 0,
                    totalCol4 = 0;

                // Loop through each row and update totals
                $('tr:not(:last-child)').each(function() {
                    var col1 = parseFloat($(this).find('input#col1').val()) || 0;
                    var col2 = parseFloat($(this).find('input#col2').val()) || 0;
                    var col3 = parseFloat($(this).find('input#col3').val()) || 0;
                    var col4 = parseFloat($(this).find('input#col4').val()) || 0;
                    var cell = $(this).find('td.cell');
                    var totalRow = col1 + col2 + col3 + col4;

                    var totalRowCell = $(this).find('td#TotalRow');
                    totalRowCell.text(totalRow.toFixed(2));

                    totalCol1 += col1;
                    totalCol2 += col2;
                    totalCol3 += col3;
                    totalCol4 += col4;

                    var tosRNoItemsCell = $(this).find('td#tos_r_no_items');
                    if (totalRow != parseFloat(tosRNoItemsCell.text())) {
                        totalRowCell.css('color', 'red'); // Change to your desired color
                        $(this).find('input[type="number"]').css('color', 'red'); // Change input color
                        cell.css('color', 'red');

                    } else {
                        totalRowCell.css('color', ''); // Reset to default color
                        $(this).find('input[type="number"]').css('color', ''); // Change input color
                        cell.css('color', '');
                    }
                });

                // Update the total cells
                $('td#totalCol1').text(totalCol1.toFixed(2));
                $('td#totalCol2').text(totalCol2.toFixed(2));
                $('td#totalCol3').text(totalCol3.toFixed(2));
                $('td#totalCol4').text(totalCol4.toFixed(2));
            }
            function roundInputValues() {
            $('input[type="number"]').each(function() {
                var currentValue = parseFloat($(this).val());
                if (!isNaN(currentValue)) {
                    var roundedValue = Math.round(currentValue);
                    $(this).val(roundedValue);
                }
            });
        }
        $('#roundButton').on('click', function() {
            roundInputValues();
            updateTotals();
            updateCol();
        });

        });
    </script>
</body>

</html>

@endsection
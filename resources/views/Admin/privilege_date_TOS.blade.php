@extends('layouts.adminSidebar')
@include('layouts.modal')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')

    <style>
        body {
            background-image: url("{{ asset('assets/Wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
            background-color: #EEEEEE;
        }

        .action-btn {
            background: #d7ecf9;
            transition: all 0.2s ease-in-out;
        }

        .action-btn:hover {
            background: #c3dff3;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="p-4 shadow-lg bg-white border-dashed rounded-lg mt-16">
        <h1 class="text-lg font-bold">Override Privilege Date for TOS</h1>

        <div class='overflow-x-auto w-full rounded-xl overflow-hidden mt-5'>
            <table class='w-full bg-white border-none shadow-lg table-auto overflow-scroll px-3 text-left whitespace-nowrap rounded-xl'>
                <thead>
                    <tr class="bg-blue text-white text-base">
                        <th class="px-4 py-2 font-bold">ID</th>
                        <th class="px-4 py-2 font-bold">TOS SUBMITTED</th>
                        <th class="px-4 py-2 font-bold"></th>
                        <th class="px-4 py-2 font-bold">CHANGE DATE SUBMISSION</th>
                        <th class="px-4 py-2 font-bold text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 text-black text-sm bg-white">
                    <tr>
                        <td class="px-4 py-2">001</td>
                        <td class="px-4 py-2">2025-07-15</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2">
                            <input type="date" class="border rounded px-2 py-1 w-full">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button
                                class="action-btn   rounded-xl p-2 font-semibold text-black flex items-center gap-2 justify-center mx-auto"
                                onmouseover="this.style.background='#c3dff3';"
                                onmouseout="this.style.background='#d7ecf9';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Submit
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-2">002</td>
                        <td class="px-4 py-2">2025-07-18</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2">
                            <input type="date" class="border rounded px-2 py-1 w-full">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button
                                class="action-btn   rounded-xl p-2 font-semibold text-black flex items-center gap-2 justify-center mx-auto"
                                onmouseover="this.style.background='#c3dff3';"
                                onmouseout="this.style.background='#d7ecf9';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Submit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-5 flex justify-center">
                <span class="text-gray-600 text-sm">Page 1 of 1</span>
            </div>
        </div>
    </div>
</body>

</html>
@endsection

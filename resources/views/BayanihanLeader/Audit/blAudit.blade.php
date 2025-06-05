@extends('layouts.BLsyllabus')
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
        .bg svg {
            transform: scaleY(-1);
            min-width: '1880'
        }

        body {
            background-image: url("{{ asset('assets/wave.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            background-size: contain;
        }

        table,
        tr,
        td,
        th {
            border: 1px solid;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sample/se.png') }}">
</head>

<body>
        <div class="mx-16 pt-12">
            <div class="overflow-x-auto">
                <table class="w-full p-6 text-2xs text-left whitespace-nowrap">
                    <colgroup>
                        <col>
                        <col>
                        <col>
                        <col class="w-16">
                        <col>
                    </colgroup>
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="p-3">Action</th>
                            <th class="p-3">User</th>
                            <th class="p-3">Old Values</th>
                            <th class="p-3">New Values</th>
                            <th class="p-3">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="border-b text-black divide-y divide-[#e5e7eb] bg-[#f9fafb] ">
                        @foreach ($audits as $audit)
                        <tr>
                            <td class="px-3 py-2">{{ $audit->event }}</td>
                            <td class="px-3 py-2">
                                <p>{{ $audit->user->firstname . ' ' . $audit->user->lastname }}</p>
                            </td>
                            <!-- <td>{{ $audit->auditable_type }}</td> -->
                            <!-- <td>{{ $audit->auditable_id }}</td> -->
                            <td class="px-3 py-2">
                                @foreach ($audit->old_values as $key => $value)
                                    <strong>{{ $key }}:</strong> {{ $value }}<br>
                                @endforeach
                            </td>
                            <td class="px-3 py-2">
                                @foreach ($audit->new_values as $key => $value)
                                    <p><strong>{{ $key }}:</strong> {{ $value }}<br></p>
                                @endforeach
                            </td>
                            <td class="px-3 py-2">
                                <p>{{ $audit->created_at }}</p>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

</body>

</html>
@endsection
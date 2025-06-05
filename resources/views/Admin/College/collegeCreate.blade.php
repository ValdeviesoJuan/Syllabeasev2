<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')

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
            background-image: url("{{ asset('assets/Wave1.png') }}");
            background-repeat: no-repeat;
            background-position: top;
            background-attachment: fixed;
            min-width: 100vh;
            background-size: contain;
        }
        </style>
</head>

<body>
    <div class="p-4 mt-14 flex items-center justify-center">
        <div class="max-w-md bg-gradient-to-r from-[#FFF] to-[#dbeafe] bg-slate-100 w-[500px] p-6 rounded-lg shadow-lg">
            <img class="edit_user_img text-center mt-2 w-[280px] m-auto mb-2" src="/assets/Create College.png" alt="SyllabEase Logo">
            {{-- <h1 class="text-center p-3 text-2xl font-semibold">Assign Chairman</h1> --}}
            <form class="text-center" action="{{ route('admin.storeCollege') }}" method="POST">
                @csrf
                <div class="grid gap-6 ml-4 mb-6 md:grid-cols-3">
                    <div class="mt-2">
                        <div>
                            <label for="college_code">College Code</label>
                        </div>
                        <input type="text" name="college_code" id="college_description" class="px-1 py-[6px] w-[170px] border rounded border-gray" required></input>
                    </div>
                    <div class="m-2 ml-14">
                        <div>
                            <label for="college_status">Status</label>
                        </div>
                        <select name="college_status" id="college_status" class="px-1 py-[6px] w-[170px] border rounded border-gray" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="m-2">
                    <div>
                        <label class="mr-[55%]" for="college_description">College Description</label>
                    </div>
                    <input type="text" name="college_description" id="college_description" class="px-1 py-[6px] w-[350px] border rounded border-gray" required></input>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="text-white px-6 py-2 font-semibold rounded-lg m-2 mt-8 mb-4 bg-blue">Create College</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
@endsection
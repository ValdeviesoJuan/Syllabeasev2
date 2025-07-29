<!-- @-extends('layouts.adminNav') -->
@extends('layouts.adminSidebar')
@include('layouts.modal')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
        table,
        tbody{
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="p-4 shadow-lg bg-white border-dashed rounded-lg dark:border-gray-700 mt-24">
            <div class="" id="whole">
                <div class="w-full overflow-x-auto">
                    <div class="mx-4 mt-4 display-flex whitespace-nowrap content-start">
                        <div class="flex overflow-hidden">
                            <h2 class="text-4xl mb-4 flex text-left text-black font-semibold leadi ">USERS</h2>
                        </div>
                    
                        <a href="{{ route('fileUserExport') }}"
                            style="display: flex; align-items: center; gap: 10px; background: #d7ecf9; border: none; border-radius: 10px; padding: 12px 24px; font-size: 1rem; color: #1a3557; font-weight: 500; min-width: 0; justify-content: center; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06); cursor: pointer; transition: background 0.3s ease; text-decoration: none;"
                            class="absolute content-start"
                            onmouseover="this.style.background='#c3dff3';"
                            onmouseout="this.style.background='#d7ecf9';"
                        >
                            <!-- Download Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12l4.5 4.5m0 0l4.5-4.5m-4.5 4.5V3"/>
                            </svg>
                            Export data
                        </a>

                        <!-- na add ni gels -->
                        <div class="import whitespace-nowrap">
                            <form action="{{ route('fileUserImport') }}" method="POST" enctype="multipart/form-data" class="relative w-full px-4 max-w-full float-right inline-block text-right">
                                @csrf
                                <button type="submit"
                                    class="import_btn flex items-center gap-2 float-right"
                                    style="background: #d7ecf9; border: none; border-radius: 10px; padding: 5px 24px; font-size: 1rem; color: #1a3557; font-weight: 500; justify-content: center; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06); cursor: pointer; transition: background 0.3s ease;"
                                    onmouseover="this.style.background='#c3dff3';"
                                    onmouseout="this.style.background='#d7ecf9';"
                                    id="importBtn"
                                    disabled
                                >

                                    <!-- Upload Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12l-4.5-4.5m0 0L7.5 12m4.5-4.5V21" />
                                    </svg>
                                    Import data
                                </button>
                                <button class="custom_file ">
                                    <input type="file" name="file" class="custom-file-input relative w-full mt-[-5px] -mr-10" style="border:none; border-radius:15px" id="customFile">
                                </button>
                            </form>
                        </div>
                    </div> 
                    <livewire:admin-user-table />
                </div>
<script>
    $(document).ready(function() {
        $('.dropdown-menu').hide();

        $('.edit-btn').click(function(e) {
            e.preventDefault();
            $('.dropdown-menu').not($(this).next('.dropdown-menu')).hide();
            $(this).next('.dropdown-menu').toggle();
        });

        // para ma close
        $(document).click(function(e) {
            if (!$(e.target).closest('.edit-btn').length && !$(e.target).closest('.dropdown-menu').length) {
                $('.dropdown-menu').hide();
            }
        });

        // Enable import button only if file is selected
        $('#customFile').on('change', function() {
            if ($(this).val()) {
                $('#importBtn').prop('disabled', false);
            } else {
                $('#importBtn').prop('disabled', true);
            }
        });
    });
</script>
</script>
</body>

</html>
@endsection
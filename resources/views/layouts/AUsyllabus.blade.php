<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // JS for Searchable Select
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 
        });
    </script>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }

        function dropdownTeam() {
            var dropdown = document.getElementById('dropdownTeam');
            dropdown.classList.toggle('hidden');
        }

        function dropDownComment() {
            var dropdown = document.getElementById('dropDownComment');
            dropdown.classList.toggle('hidden');
        }
        function dropdownVersion() {
            var dropdown = document.getElementById('dropdownVersion');
            dropdown.classList.toggle('hidden');
        }
    </script>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
    <style>
        @media only screen and (min-width: 768px) {
            .parent:hover .child {
                opacity: 1;
                height: auto;
                overflow: none;
                transform: translateY(0);
                transition: opacity 0.3s ease-in-out, height 0.3s ease-in-out, transform 0.3s ease-in-out;

            }

            .child {
                opacity: 0;
                height: 0;
                overflow: hidden;
                transform: translateY(-10%);
                transition: opacity 0.3s ease-in-out, height 0.3s ease-in-out, transform 0.3s ease-in-out;
            }
        }
    </style>
    <livewire:styles />
    <x-head.tinymce-config />
</head>

<body class="box-border">
    <div class=" ">
        <div class="relative">
            <div class="fixed top-0 z-50">
                <nav class="w-screen flex px-6 md:shadow-lg items-center relative bg-blue py-1">
                    <img class="w-48 text-lg font-bold md:py-0 py-4" src="/assets/Sample/syllabease4.png" alt="SyllabEase">
                    <div class="border-2 border-solid border-white rounded-full text-white ml-2">
                        <button class="flex p-0.5 relative">
                            <div class="bg-white rounded-full">
                                <svg fill="#1148b1" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                    <path d="M44,63.3c0-3.4,1.1-7.2,2.9-10.2c2.1-3.7,4.5-5.2,6.4-8c3.1-4.6,3.7-11.2,1.7-16.2c-2-5.1-6.7-8.1-12.2-8
                                s-10,3.5-11.7,8.6c-2,5.6-1.1,12.4,3.4,16.6c1.9,1.7,3.6,4.5,2.6,7.1c-0.9,2.5-3.9,3.6-6,4.6c-4.9,2.1-10.7,5.1-11.7,10.9
                                c-1,4.7,2.2,9.6,7.4,9.6h21.2c1,0,1.6-1.2,1-2C45.8,72.7,44,68.1,44,63.3z M64,48.3c-8.2,0-15,6.7-15,15s6.7,15,15,15s15-6.7,15-15
                                S72.3,48.3,64,48.3z M66.6,64.7c-0.4,0-0.9-0.1-1.2-0.2l-5.7,5.7c-0.4,0.4-0.9,0.5-1.2,0.5c-0.5,0-0.9-0.1-1.2-0.5
                                c-0.6-0.6-0.6-1.7,0-2.5l5.7-5.7c-0.1-0.4-0.2-0.7-0.2-1.2c-0.2-2.6,1.9-5,4.5-5c0.4,0,0.9,0.1,1.2,0.2c0.2,0,0.2,0.2,0.1,0.4
                                L66,58.9c-0.2,0.1-0.2,0.5,0,0.6l1.7,1.7c0.2,0.2,0.5,0.2,0.7,0l2.5-2.5c0.1-0.1,0.4-0.1,0.4,0.1c0.1,0.4,0.2,0.9,0.2,1.2
                                C71.6,62.8,69.4,64.9,66.6,64.7z" />
                                </svg>
                            </div>
                            <div class="mt mx-1 text-[13px]">
                                <a href="{{ route('home') }}">Auditor</a>
                            </div>
                        </button>
                    </div>

                    <!-- Role Reminder ni siya -->
                    <!-- <div class="role-reminder fixed left-[324px] top-6 opacity-0 transition-opacity duration-500 ease-in-out">
                        <div class="fixed w-4 h-4 transform -translate-x-1/2 bg-white rotate-45 top-8"></div>
                        <div class="absolute bg-white rounded-lg shadow-lg p-4 h-36 w-48 shadow-xl">
                            <p class="font-semibold text-yellow">Important Note:</p>
                            <p class="mt-2">
                                Click here to switch role.
                            </p>
                            <button class="absolute bottom-0 right-0 mb-3 mr-3 text-blue">Got it.</button>
                        </div>
                    </div> -->

                    <div class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative top-full left-0 right-0">
                        <!-- history button -->
                        <a href="{{ route('bayanihanteacher.viewAudit', $syll_id) }}" method="post" class="hover:bg-blue3 rounded-full cursor-pointer w-8 h-8 mx-1 flex justify-center md:inline-flex items-center justify-center">
                            <svg width="25px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 5.67541V3C3 2.44772 2.55228 2 2 2C1.44772 2 1 2.44772 1 3V7C1 8.10457 1.89543 9 3 9H7C7.55229 9 8 8.55229 8 8C8 7.44772 7.55229 7 7 7H4.52186C4.54218 6.97505 4.56157 6.94914 4.57995 6.92229C5.621 5.40094 7.11009 4.22911 8.85191 3.57803C10.9074 2.80968 13.173 2.8196 15.2217 3.6059C17.2704 4.3922 18.9608 5.90061 19.9745 7.8469C20.9881 9.79319 21.2549 12.043 20.7247 14.1724C20.1945 16.3018 18.9039 18.1638 17.0959 19.4075C15.288 20.6513 13.0876 21.1909 10.9094 20.9247C8.73119 20.6586 6.72551 19.605 5.27028 17.9625C4.03713 16.5706 3.27139 14.8374 3.06527 13.0055C3.00352 12.4566 2.55674 12.0079 2.00446 12.0084C1.45217 12.0088 0.995668 12.4579 1.04626 13.0078C1.25994 15.3309 2.2082 17.5356 3.76666 19.2946C5.54703 21.3041 8.00084 22.5931 10.6657 22.9188C13.3306 23.2444 16.0226 22.5842 18.2345 21.0626C20.4464 19.541 22.0254 17.263 22.6741 14.6578C23.3228 12.0526 22.9963 9.30013 21.7562 6.91897C20.5161 4.53782 18.448 2.69239 15.9415 1.73041C13.4351 0.768419 10.6633 0.756291 8.14853 1.69631C6.06062 2.47676 4.26953 3.86881 3 5.67541Z" fill="#ffffff" />
                                <path d="M12 5C11.4477 5 11 5.44771 11 6V12.4667C11 12.4667 11 12.7274 11.1267 12.9235C11.2115 13.0898 11.3437 13.2344 11.5174 13.3346L16.1372 16.0019C16.6155 16.278 17.2271 16.1141 17.5032 15.6358C17.7793 15.1575 17.6155 14.546 17.1372 14.2698L13 11.8812V6C13 5.44772 12.5523 5 12 5Z" fill="#ffffff" />
                            </svg>
                        </a>
                        <!-- Version button -->
                        <a onclick="dropdownVersion()" class="hover:bg-blue3 rounded-full cursor-pointer w-8 h-8 flex justify-center md:inline-flex items-center justify-center">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>version_fill</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="System" transform="translate(-1488.000000, -48.000000)" fill-rule="nonzero">
                                        <g id="version_fill" transform="translate(1488.000000, 48.000000)">
                                            <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero">
                                            </path>
                                            <path d="M20.2451,14.75 C21.18,15.3637 21.1371,16.7868 20.1165,17.3263 L12.9348,21.1225 C12.35,21.4316 11.6503,21.4316 11.0655,21.1225 L3.88381,17.3263 C2.86325,16.7868 2.82034,15.3638 3.75508,14.75 L3.817995,14.7892 L3.817995,14.7892 L11.0654,18.6222 C11.6502,18.9313 12.35,18.9313 12.9347,18.6222 L20.1164,14.826 C20.1612,14.8023 20.2041,14.7769 20.2451,14.75 Z M20.2451,10.75 C21.1393522,11.3370174 21.138982,12.6645822 20.2440771,13.2510586 L20.1165,13.3263 L12.9348,17.1225 C12.4031636,17.4035 11.7765686,17.4290455 11.227667,17.1991364 L11.0655,17.1225 L3.88381,13.3263 C2.86325,12.7868 2.82034,11.3638 3.75508,10.75 L3.817995,10.7892 L3.817995,10.7892 L11.0654,14.6222 C11.5970364,14.9032 12.223714,14.9287455 12.7725555,14.6988364 L12.9347,14.6222 L20.1164,10.826 C20.1612,10.8023 20.2041,10.7769 20.2451,10.75 Z M12.9347,2.87782 L20.1164,6.67404 C21.1818,7.23718 21.1818,8.76316 20.1164,9.32629 L12.9347,13.1225 C12.35,13.4316 11.6502,13.4316 11.0654,13.1225 L3.88373,9.32629 C2.81838,8.76315 2.81838,7.23718 3.88373,6.67404 L11.0654,2.87782 C11.6502,2.56872 12.35,2.56872 12.9347,2.87782 Z" id="形状" fill="#ffffff">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        <!-- Version Dropdown -->
                        <div id="dropdownVersion" class="hidden pt-2 px-3 pb-7 transition duration-300 md:absolute top-full right-0 md:w-[350px] bg-white bg-opacity-90 md:shadow-lg md:rounded">
                            <div class="text-gray">
                                Syllabus Versions
                            </div>

                            @foreach($syllabusVersions as $syllabusVersion)
                                @php
                                $currentRouteMatches = request()->route()->getName() === 'auditor.commentSyllabus' &&
                                request()->route('syll_id') == $syllabusVersion->syll_id;
                                $bgColorClass = $currentRouteMatches ? 'bg-blue2' : 'bg-white';
                                @endphp

                                <a href="{{ route('auditor.commentSyllabus', $syllabusVersion->syll_id) }}" class="">
                                    <div class="p-2 flex justify-between hover:bg-blue2 rounded {{ $bgColorClass }}">
                                        <div class="flex flex-row">
                                            Version {{ $syllabusVersion->version }}
                                        </div>
                                        <div class="flex items-center">
                                            <div class="text-gray text-sm italic pr-5">
                                                {{ $syllabusVersion->status }}
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="text-gray text-sm italic pr-5">
                                                {{ $syllabusVersion->chair_submitted_at }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <a onclick="dropDownComment()" id="modeButton" class="hover:bg-blue2 bg-blue3 rounded-full cursor-pointer w-[180px] px-2 h- flex justify-center md:inline-flex items-center justify-center">
                            @if(request()->route()->getName() == 'auditor.commentSyllabus')
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @else
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8477 1.87868C19.6761 0.707109 17.7766 0.707105 16.605 1.87868L2.44744 16.0363C2.02864 16.4551 1.74317 16.9885 1.62702 17.5692L1.03995 20.5046C0.760062 21.904 1.9939 23.1379 3.39334 22.858L6.32868 22.2709C6.90945 22.1548 7.44285 21.8693 7.86165 21.4505L22.0192 7.29289C23.1908 6.12132 23.1908 4.22183 22.0192 3.05025L20.8477 1.87868ZM18.0192 3.29289C18.4098 2.90237 19.0429 2.90237 19.4335 3.29289L20.605 4.46447C20.9956 4.85499 20.9956 5.48815 20.605 5.87868L17.9334 8.55027L15.3477 5.96448L18.0192 3.29289ZM13.9334 7.3787L3.86165 17.4505C3.72205 17.5901 3.6269 17.7679 3.58818 17.9615L3.00111 20.8968L5.93645 20.3097C6.13004 20.271 6.30784 20.1759 6.44744 20.0363L16.5192 9.96448L13.9334 7.3787Z" fill="#ffffff" />
                            </svg>
                            @endif

                            <div id="modeText" class="mx-2 text-white text-sm">
                                @if(request()->route()->getName() == 'auditor.commentSyllabus')
                                Comment Mode
                                @else
                                Editing Mode
                                @endif
                            </div>
                            <div>
                                <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z" />
                                </svg>
                            </div>
                        </a>

                        <!-- Comment Dropdown -->
                        <div id="dropDownComment" class="hidden mt-1 transition duration-300 md:absolute top-full right-[90px] md:w-[200px] bg-white bg-opacity-90 md:shadow-lg md:rounded">
                            <a href="{{ route('auditor.commentSyllabus', $syll_id) }}" method="post" class="flex flex-row items-center my-2 mx-1 rounded shadow  hover:border hover:border-gray3">
                                <div class="mx-2 my-2">
                                    <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#454545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="text-gray2">
                                    Comment Mode
                                </div>
                            </a>
                            <a href="{{ route('generateSyllabusPDF', $syll_id) }}" method="post" class="flex flex-row items-center my-2 mx-1 rounded shadow  hover:border hover:border-gray3">
                                <div class="mx-2 my-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / Download">
                                            <path id="Vector" d="M6 21H18M12 3V17M12 17L17 12M12 17L7 12" stroke="#454545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-gray2">
                                Export as DOCX
                                </div>
                            </a>
                        </div>

                    <!-- bteam button -->
                    <a onclick="dropdownTeam()" class="hover:bg-blue3 rounded-full cursor-pointer w-8 h-8 flex justify-center md:inline-flex items-center justify-center">
                        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.54831C10.7255 5.54831 9.69231 6.58817 9.69231 7.87089C9.69231 9.15362 10.7255 10.1935 12 10.1935C13.2745 10.1935 14.3077 9.15362 14.3077 7.87089C14.3077 6.58817 13.2745 5.54831 12 5.54831ZM8.15385 7.87089C8.15385 5.73302 9.87583 3.99992 12 3.99992C14.1242 3.99992 15.8462 5.73302 15.8462 7.87089C15.8462 10.0088 14.1242 11.7419 12 11.7419C9.87583 11.7419 8.15385 10.0088 8.15385 7.87089Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4825 14.8386C8.91318 14.8386 7.64103 16.119 7.64103 17.6984C7.64103 17.7292 7.64361 17.754 7.64706 17.7726C7.64752 17.7751 7.64798 17.7774 7.64844 17.7795C8.05927 18.0084 9.22185 18.4515 12 18.4515C14.7781 18.4515 15.9407 18.0084 16.3516 17.7795C16.352 17.7774 16.3525 17.7751 16.3529 17.7726C16.3564 17.754 16.359 17.7292 16.359 17.6984C16.359 16.119 15.0868 14.8386 13.5175 14.8386H10.4825ZM6.10256 17.6984C6.10256 15.2638 8.06352 13.2902 10.4825 13.2902H13.5175C15.9365 13.2902 17.8974 15.2638 17.8974 17.6984C17.8974 18.1328 17.7512 18.7483 17.17 19.0921C16.4639 19.5098 15.0065 19.9999 12 19.9999C8.99348 19.9999 7.53615 19.5098 6.82998 19.0921C6.24882 18.7483 6.10256 18.1328 6.10256 17.6984Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.642 5.60438C16.7529 5.19162 17.1752 4.94744 17.5853 5.059C18.9891 5.44084 19.9487 6.82831 19.9487 8.38702C19.9487 10.0344 18.8254 11.5422 17.2199 11.7363C16.7981 11.7873 16.4151 11.4845 16.3645 11.06C16.3138 10.6355 16.6147 10.25 17.0365 10.199C17.7387 10.1141 18.4103 9.39004 18.4103 8.38702C18.4103 7.43484 17.8314 6.72989 17.1839 6.55375C16.7738 6.4422 16.5312 6.01715 16.642 5.60438Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4245 13.9162C18.5058 13.4966 18.9098 13.2227 19.3267 13.3046C20.8794 13.6093 22 14.9784 22 16.5705V16.989C22 17.3864 21.8816 17.9868 21.3303 18.3414C20.9857 18.5631 20.4635 18.7915 19.6739 18.9523C19.2575 19.0371 18.8517 18.7661 18.7674 18.347C18.6832 17.9279 18.9524 17.5194 19.3688 17.4347C19.9544 17.3154 20.2853 17.1655 20.4558 17.0651L20.456 17.0637C20.4592 17.045 20.4615 17.0201 20.4615 16.989V16.5705C20.4615 15.7192 19.8624 14.9873 19.0322 14.8243C18.6153 14.7425 18.3432 14.3359 18.4245 13.9162Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.35797 11.1697C7.24713 11.5824 6.82481 11.8266 6.41469 11.715C5.01092 11.3332 4.05128 9.94573 4.05128 8.38702C4.05128 6.73965 5.1746 5.2318 6.78005 5.03771C7.20186 4.98671 7.58487 5.28952 7.63554 5.71404C7.6862 6.13857 7.38534 6.52405 6.96354 6.57504C6.2613 6.65994 5.58974 7.384 5.58974 8.38702C5.58974 9.3392 6.16857 10.0442 6.81608 10.2203C7.2262 10.3318 7.46882 10.7569 7.35797 11.1697Z" fill="#ffffff" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.57552 13.9162C5.4942 13.4966 5.09025 13.2227 4.67327 13.3046C3.1206 13.6093 2 14.9784 2 16.5705V16.989C2 17.3864 2.11838 17.9868 2.66968 18.3414C3.01428 18.5631 3.53653 18.7915 4.32609 18.9523C4.74249 19.0371 5.14834 18.7661 5.23259 18.347C5.31683 17.9279 5.04757 17.5194 4.63117 17.4347C4.04556 17.3154 3.71472 17.1655 3.54423 17.0651L3.544 17.0637C3.54082 17.045 3.53846 17.0201 3.53846 16.989V16.5705C3.53846 15.7192 4.1376 14.9873 4.96776 14.8243C5.38474 14.7425 5.65684 14.3359 5.57552 13.9162Z" fill="#ffffff" />
                        </svg>
                    </a>
                    <!-- Team Dropdown -->
                    <div id="dropdownTeam" class="hidden pt-2 px-3 pb-7 transition duration-300 md:absolute top-full right-0 md:w-[350px] bg-white bg-opacity-90 md:shadow-lg md:rounded">
                        <div class="font-semibold tracking-wide text-lg">
                            {{$syll->course_code}}-{{$syll->course_title}}
                        </div>
                        <div class="font-semibold tracking-wide text-gray2">
                            {{$syll->course_semester}} SY {{$syll->bg_school_year}}
                        </div>
                        <div class="text-gray">
                            People with access
                        </div>

                        @foreach($bLeaders as $bLeader)
                        <div class="mt-2 flex flex justify-between">
                            <div class="flex flex-row">
                                <div class="border-2 border-gray bg-green rounded-full w-[30px] h-[30px] flex items-center justify-center mr-2 my-auto">
                                    <div class="text-white ">
                                        {{ Str::upper(substr($bLeader->firstname, 0, 1)) . Str::upper(substr($bLeader->lastname, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex">
                                        {{ $bLeader->firstname . $bLeader->lastname }}
                                    </div>

                                    <div class="text-sm text-gray">
                                        {{ $bLeader->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="role text-gray text-sm italic pr-5">
                                    Leader
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- Member -->
                        @foreach($bMembers as $bMember)
                        <div class="mt-2 flex flex justify-between">
                            <div class="flex flex-row">
                                <div class="border-2 border-gray bg-pink rounded-full w-[30px] h-[30px] flex items-center justify-center mr-2 my-auto">
                                    <div class="text-white ">
                                        {{ Str::upper(substr($bMember->firstname, 0, 1)) . Str::upper(substr($bMember->lastname, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex">
                                        {{ $bMember->firstname . $bMember->lastname }}
                                    </div>

                                    <div class="text-sm text-gray">
                                        {{ $bMember->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="role text-gray text-sm italic pr-5">
                                    Member
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="md:px-2 ml-auto md:flex md:space-x-3 absolute md:relative top-full left-0 right-0">
                        <div class="relative parent">
                            <!-- User Avatar and Initials -->
                            <a class="cursor-pointer border-2 w-8 h-8 flex justify-center md:inline-flex text-white hover:text-beige items-center hover:bg-seThird bg-yellow rounded-full bg-white justify-center" onclick="toggleDropdown()">
                                <div class="text-white text-sm">
                                    {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                </div>
                            </a>
    
                            <!-- User Profile Dropdown -->
                            <div id="dropdown" class="px-3 pb-7 transition duration-300 md:absolute top-full right-0 md:w-[350px] bg-white bg-opacity-90 md:shadow-lg md:rounded hidden">
                                <div class="flex flex-row">
                                    <!-- SyllabEase Logo -->
                                    <div>
                                        <img class="w-[125px] text-lg font-bold md:py-0 py-4 m-2" src="/assets/sample/syllabease.png" alt="SyllabEase">
                                    </div>
    
                                    <!-- Logout and SyllabEase Name -->
                                    <div class="flex items-center ml-auto">
                                        <div class="text-sm text-yellow pr-4">
                                            <a class="mt-2 flex hover:underline hover:underline-offset-4" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="">
                                                Sign out
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
    
                                <!-- User Information -->
                                <div class="mt-4 flex flex-row">
                                    <!-- User Avatar with Initials -->
                                    <div class="bg-yellow rounded-full w-[80px] h-[80px] flex items-center justify-center mr-3">
                                        <div class="text-white text-3xl">
                                            {{ Str::upper(substr(Auth::user()->firstname, 0, 1)) . Str::upper(substr(Auth::user()->lastname, 0, 1)) }}
                                        </div>
                                    </div>
    
                                    <!-- User Name, Email, and Profile Link -->
                                    <div>
                                        <div class="font-semibold text-lg">
                                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                        </div>
                                        <div>
                                            {{ Auth::user()->email }}
                                        </div>
                                        <div class="text-blue underline underline-offset-4">
                                            <a href="{{ route('profile.edit') }}">My Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            </nav>
        </div>
    </div>
    <main>
        <div class="mt-16">
            @yield('content')
        </div>

    </main>
    </div>
        <livewire:scripts />

</body>

</html>
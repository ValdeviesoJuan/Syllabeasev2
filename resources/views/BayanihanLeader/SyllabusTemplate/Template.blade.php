@extends('layouts.blNav')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
</head>

<body class="p-6 bg-gray-100">


        <!-- Cleaned Static Syllabus Template (No PHP or Logic) -->
        
            <table class="mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white">
            <tr>
                <th colspan="2" class="relative font-medium border-2 border-solid px-4 py-6">
                <!-- Absolute drag button in top-left corner -->
                <div class="absolute top-0 left-0">
                    <button class="p-1" title="Drag">
                        <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                    </button>
                </div>
                <span class="font-bold">COLLEGE NAME</span><br>
                </th>
                <th class="font-medium border-2 border-solid text-left px-4 w-2/6">
                <span class="font-bold underline underline-offset-4">Syllabus<br></span>
                Course Title : <span class="font-bold"></span><br>
                Course Code: <br>
                Credits: <br>
                </th>
            </tr>

            <tr>
                <td class="relative border-2 border-solid font-medium text-sm text-left px-4 text-justify align-top">
                    <!-- Absolute drag button in top-left corner -->
                    <div class="absolute top-0 left-0">
                        <button class="p-1" title="Drag">
                            <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                        </button>
                    </div>
                    <!-- VISION -->
                    <div class="mt-2 mb-8">
                        <span class="font-bold pt-4 block">USTP Vision<br><br></span>
                        <p></p>
                    </div>
                    <!-- MISSION -->
                    <div class="mb-8">
                        <span class="font-bold">USTP Mission<br><br></span>
                        <ul class="list-disc ml-8">
                        <li></li>
                        <li></li>
                        <li></li>
                        </ul>
                    </div>
                 <!-- PEO -->
                    <div class="mb-8">
                        <span class="font-bold">Program Educational Objectives<br><br></span>
                        <p><span class="font-semibold">PEO1:</span> </p>
                        <p><span class="font-semibold">PEO2:</span> </p>
                    </div>
                    <!-- PO -->
                    <div class="mb-8">
                        <span class="font-bold">Program Outcomes<br><br></span>
                        <p><span class="font-semibold">A:</span> </p>
                        <p><span class="font-semibold">B:</span> </p>
                    </div>
                
                </td>

                <td colspan="2" class="align-top">
                    
                        <table class="my-4 mx-0 w-full">
                            <div class="relative">
                                <!-- Absolute drag button in top-left corner -->
                                <div class="absolute bottom-[-26px] left-0">
                                    <button class="p-1" title="Drag">
                                        <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                                    </button>
                                </div>
                                <tr>
                                    <td class="border-2 border-solid font-medium text-left px-4 w-1/2">
                                        Semester/Year: <br>
                                        Class Schedule: <br>
                                        Bldg./Rm. No.: 
                                    </td>
                                    <td class="border-2 border-solid font-medium text-left px-4">
                                        Pre-requisite(s): <br>
                                        Co-requisite(s): 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-2 border-solid font-medium text-left px-4">
                                        Instructor: <br>
                                        Email: <br>
                                        Phone: 
                                    </td>
                                    <td class="border-2 border-solid font-medium text-left px-4">
                                        Consultation Schedule: <br>
                                        Bldg./Rm. No.: 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-2 border-solid font-medium text-left px-4">
                                        <span class="font-bold">I. Course Description:</span><br>
                                        
                                    </td>
                                </tr>
                            </div>

                            <div class="relative">
                                <tr>
                                    <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4">
                                        <!-- Absolute drag button in top-left corner -->
                                        <div class="absolute top-[-7px] left-0">
                                            <button class="p-1" title="Drag">
                                                <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                                            </button>
                                        </div>
                                        <span class="font-bold pt-4 block">II. Course Outcomes:</span>
                                        <table class="mt-4 border border-solid w-full">
                                        <tr>
                                            <th class="border-2">Course Outcomes (CO)</th>
                                            <th class="border-2"></th>
                                            <th class="border-2"></th>
                                        </tr>
                                        <tr>
                                            <td class="border-2">CO1: Understand basic concepts</td>
                                            <td class="border-2 text-center"></td>
                                            <td class="border-2 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border-2">CO2: Apply design thinking</td>
                                            <td class="border-2 text-center"></td>
                                            <td class="border-2 text-center"></td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                            </div>

                    <div class="relative">  
                        <tr>
                            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4">
                                 <!-- Absolute drag button in top-left corner -->
                                <div class="absolute top-0 left-0">
                                    <button class="p-1" title="Drag">
                                        <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                                    </button>
                                </div>   
                                <span class="font-bold pt-8 block">III. Course Outline:</span><br>
                                <table class="mt-2 border border-solid w-full">
                                <tr>
                                    <th class="border-2">Time</th>
                                    <th class="border-2">ILO</th>
                                    <th class="border-2">Topics</th>
                                    <th class="border-2">Readings</th>
                                    <th class="border-2">Activities</th>
                                    <th class="border-2">Assessment</th>
                                    <th class="border-2">Grading</th>
                                </tr>
                                <tr>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                    <td class="border-2"></td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </div>

                    <div class="relative"> 
                        <tr>
                            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4">
                                <!-- Absolute drag button in top-left corner -->
                                <div class="absolute top-0 left-0">
                                    <button class="p-1" title="Drag">
                                        <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                                    </button>
                                </div>   
                                <span class="font-bold pt-8 block">IV. Course Requirements:</span><br>
                                
                            </td>
                        </tr>
                    </div>

                    <div class="relative"> 
                        
                        <tr>  
                            <td colspan="2" class="relative">
                                 <!-- Absolute drag button in top-left corner -->
                                <div class="absolute top-8 left-0 pl-1">
                                    <button class="p-1" title="Drag">
                                        <img src="{{ asset('assets/drag.svg') }}" alt="Drag" class="w-[25px] h-[25px]">
                                    </button>
                                </div> 
                                <table class="w-full border-2 border-black text-center mt-8">
                                <tr>
                                    <td class="border border-black p-4">
                                    Prepared By:<br><br><br>
                                    ___________________________<br>
                                    <span class="font-bold">INSTRUCTOR NAME</span><br>
                                    Instructor
                                    </td>
                                    <td class="border border-black p-4">
                                    Checked and Recommended for Approval:<br><br><br>
                                    ___________________________<br>
                                    <span class="font-bold">CHAIRPERSON NAME</span><br>
                                    Chairperson, Department
                                    </td>
                                    <td class="border border-black p-4">
                                    Approved by:<br><br><br>
                                    ___________________________<br>
                                    <span class="font-bold">DEAN NAME</span><br>
                                    Dean, College
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </div>
                    </table>
                </td>
            </tr>
            </table>



    <script>
        const sections = document.querySelectorAll('.resize-box');

        interact('.resize-box')
            .draggable({
                listeners: {
                    move(event) {
                        const target = event.target;
                        let x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        let y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    },
                    end(event) {
                        const dragged = event.target;
                        const dragRect = dragged.getBoundingClientRect();

                        sections.forEach(box => {
                            if (box === dragged) return;
                            const rect = box.getBoundingClientRect();
                            const overlap = !(dragRect.right < rect.left || dragRect.left > rect.right || dragRect.bottom < rect.top || dragRect.top > rect.bottom);

                            if (overlap) {
                                // Swap innerHTML and height
                                const tempContent = box.innerHTML;
                                const tempHeight = box.style.height;

                                box.innerHTML = dragged.innerHTML;
                                dragged.innerHTML = tempContent;

                                box.style.height = dragged.style.height;
                                dragged.style.height = tempHeight;
                            }
                        });

                        dragged.style.transform = 'translate(0px, 0px)';
                        dragged.removeAttribute('data-x');
                        dragged.removeAttribute('data-y');
                    }
                }
            })
            .resizable({
                edges: { left: false, right: false, bottom: true, top: true },
                modifiers: [
                    interact.modifiers.restrictSize({
                        min: { height: 80 },
                        max: { height: 600 }
                    })
                ],
                listeners: {
                    move(event) {
                        let target = event.target;
                        let height = event.rect.height;
                        target.style.height = `${height}px`;
                    }
                }
            });
    </script>
</body>

</html>
@endsection

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
    <!-- InteractJS (single import) -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
</head>

<body class="p-6 bg-gray-100">
    <!-- ================== OUTER SYLLABUS TABLE ================== -->
    <table class="table-fixed mt-2 mx-auto border-2 border-solid w-10/12 font-serif text-sm bg-white">
        <!-- ---------------------------------------------------------------- Row 1  -->
        <tr>
            <!-- College name spanning first two columns -->
            <th colspan="2" class="relative font-medium border-2 border-solid px-4 py-6">
                <div class="absolute top-0 left-0">
                    <button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button>
                </div>
                <span class="font-bold">COLLEGE NAME</span>
            </th>
            <!-- Syllabus header (3rd column) -->
            <th class="relative font-medium border-2 border-solid text-left px-4 w-2/6">
                <div class="absolute top-0 left-0">
                    <button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button>
                </div>
                <span class="font-bold underline underline-offset-4">Syllabus</span><br>
                Course Title : <span class="font-bold"></span><br>
                Course Code : <br>
                Credits     : <br>
            </th>
        </tr>

        <!-- ---------------------------------------------------------------- Row 2  (Vision/Mission + Course Description) -->
        <tr>
            <!-- LEFT column: Vision / Mission (rowspan to cover next 4 rows) -->
            <td rowspan="4" class="relative border-2 border-solid font-medium text-sm text-left px-4 text-justify align-top">
                <div class="absolute top-0 left-0">
                    <button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button>
                </div>
                <!-- VISION -->
                <div class="mt-2 mb-8"><span class="font-bold pt-4 block">USTP Vision<br><br></span></div>
                <!-- MISSION -->
                <div class="mb-8"><span class="font-bold">USTP Mission<br><br></span></div>
                <!-- PEO -->
                <div class="mb-8"><span class="font-bold">Program Educational Objectives<br><br></span></div>
                <!-- PO -->
                <div class="mb-8"><span class="font-bold">Program Outcomes<br><br></span></div>
            </td>

            <!-- RIGHT column: I. Course Description (own cell) -->
            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4 align-top">
                <div class="absolute top-0 left-0">
                    <button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button>
                </div>

                <!-- === Course Info sub‑table (restored) === -->
                <table class="my-4 w-full">
                    <tr>
                        <td class="border-2 font-medium text-left px-4 w-1/2">
                            Semester/Year: <br>
                            Class Schedule: <br>
                            Bldg./Rm. No.: 
                        </td>
                        <td class="border-2 font-medium text-left px-4">
                            Pre-requisite(s): <br>
                            Co-requisite(s): 
                        </td>
                    </tr>
                    <tr>
                        <td class="border-2 font-medium text-left px-4">
                            Instructor: <br>
                            Email: <br>
                            Phone: 
                        </td>
                        <td class="border-2 font-medium text-left px-4">
                            Consultation Schedule: <br>
                            Bldg./Rm. No.: 
                        </td>
                    </tr>
                </table>

                <span class="font-bold">I. Course Description:</span><br><br>
            </td>
        </tr>

        <!-- ---------------------------------------------------------------- Row 3  : II. Course Outcomes -->
        <tr>
            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4 align-top">
                <div class="absolute top-0 left-0"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                <span class="font-bold">II. Course Outcomes:</span>
                <table class="mt-4 border w-full border-solid">
                    <tr><th class="border-2">Course Outcomes (CO)</th><th class="border-2"></th><th class="border-2"></th></tr>
                    <tr><td class="border-2">CO1: Understand basic concepts</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                    <tr><td class="border-2">CO2: Apply design thinking</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                </table>
            </td>
        </tr>

        <!-- ---------------------------------------------------------------- Row 4  : III. Course Outline -->
        <tr>
            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4 align-top">
                <div class="absolute top-0 left-0"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                <span class="font-bold">III. Course Outline:</span>
                <table class="mt-2 border w-full border-solid">
                    <tr>
                        <th class="border-2">Time</th><th class="border-2">ILO</th><th class="border-2">Topics</th><th class="border-2">Readings</th><th class="border-2">Activities</th><th class="border-2">Assessment</th><th class="border-2">Grading</th>
                    </tr>
                    <tr>
                        <td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ---------------------------------------------------------------- Row 5  : IV. Course Requirements -->
        <tr>
            <td colspan="2" class="relative border-2 border-solid font-medium text-left px-4 align-top">
                <div class="absolute top-0 left-0"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                <span class="font-bold">IV. Course Requirements:</span><br><br>
            </td>
        </tr>

        <!-- ---------------------------------------------------------------- Row 6  : Signatures -->
        <tr>
            <td colspan="3" class="relative align-top">
                <div class="absolute top-0 left-0 pl-1"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                <table class="w-full border-2 border-black text-center mt-8">
                    <tr>
                        <td class="border border-black p-4">Prepared By:<br><br><br>___________________________<br><span class="font-bold">INSTRUCTOR NAME</span><br>Instructor</td>
                        <td class="border border-black p-4">Checked and Recommended for Approval:<br><br><br>___________________________<br><span class="font-bold">CHAIRPERSON NAME</span><br>Chairperson, Department</td>
                        <td class="border border-black p-4">Approved by:<br><br><br>___________________________<br><span class="font-bold">DEAN NAME</span><br>Dean, College</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===================== DRAG / RESIZE SCRIPT v8 ===================== -->
    <script>
    document.addEventListener('DOMContentLoaded',()=>{
        const master=document.querySelector('table.table-fixed')||document.querySelector('table');
        const CELL='td,th';
        const topCell=n=>{let c=n.closest(CELL);while(c&&c.parentElement&&c.parentElement.closest('table')!==master){c=c.parentElement.closest(CELL);}return c;};

        /* -------- swap helper (keeps explicit width/height) ---------- */
        function swap(a,b){
            [a.style.width,b.style.width]=[b.style.width,a.style.width];
            [a.style.height,b.style.height]=[b.style.height,a.style.height];
            const ca=a.cloneNode(true), cb=b.cloneNode(true);
            ca._bound=cb._bound=false;
            a.replaceWith(cb); b.replaceWith(ca);
            [ca,cb].forEach(bindCell);
        }

        /* -------- add small SE‑corner handle for clarity ------------- */
        const addHandle=c=>{if(c.querySelector('[data-resize]'))return;const h=document.createElement('div');h.dataset.resize='1';h.className='absolute bottom-0 right-0 w-3 h-3 bg-gray-400 cursor-se-resize';c.appendChild(h);c.style.position=c.style.position||'relative';};

        /* -------- core binding routine --------------------------------- */
        function bindCell(cell){
            if(!cell||cell._bound) return;
            const dragBtn=cell.querySelector('button[title="Drag"]');
            if(!dragBtn) return;          // <‑‑ NOW we only bind outer sections
            cell._bound=true; addHandle(cell);

            /* DRAG ----------------------------------------------*/
            dragBtn.style.cursor='move';
            interact(dragBtn).draggable({listeners:{
                move(ev){const tgt=topCell(ev.target);const x=(+tgt.dataset.x||0)+ev.dx,y=(+tgt.dataset.y||0)+ev.dy;tgt.style.transform=`translate(${x}px,${y}px)`;tgt.dataset.x=x;tgt.dataset.y=y;},
                end(ev){const src=topCell(ev.target);src.style.transform='';delete src.dataset.x;delete src.dataset.y;const dst=topCell(document.elementFromPoint(ev.client.x,ev.client.y));if(dst&&dst!==src)swap(src,dst);} } });

            /* RESET base min size each bind */
            cell.style.minWidth='150px'; cell.style.minHeight='40px';

            /* RESIZE (edges) ------------------------------------*/
            interact(cell).resizable({
                edges:{left:true,right:true,top:true,bottom:true},
                modifiers:[interact.modifiers.restrictSize({min:{width:150,height:40},max:{width:2500,height:1200}})],
                listeners:{
                    move(ev){Object.assign(ev.target.style,{width:`${ev.rect.width}px`,height:`${ev.rect.height}px`});},
                    end(ev){}
                }
            });
        }

        master.querySelectorAll(CELL).forEach(bindCell);
    });
    </script>

</body>

</html>
@endsection

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
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 2fr 2fr 3fr;
            grid-template-areas:
                "college college syllabus"
                "vision course course"
                "vision outcomes outcomes"
                "vision outline outline"
                "vision reqs reqs"
                "signatures signatures signatures";
            gap: 1px;
            width: 1024px;
            margin: 1rem auto;
            grid-auto-flow: dense;
            background: white;
            font-family: serif;
            font-size: 0.875rem;
            overflow: hidden;
        }

        .section {
            position: relative;
            border: 2px solid black;
            padding: 1rem;
            background-color: white;
            overflow: auto;
            min-width: 150px;
            min-height: 60px;
            box-sizing: border-box;
            resize: none; /* interactJS handles resizing */
        }

        .handle {
            position: absolute;
            top: 0;
            left: 0;
        }

        .drag-over {
            outline: 3px gray;
            background-color:rgb(120, 122, 124); /* optional: light gray highlight */
        }


        #college-name { grid-area: college; }
        #syllabus { grid-area: syllabus; }
        #vision-mission { grid-area: vision; }
        #course-desc { grid-area: course; }
        #course-outcomes { grid-area: outcomes; }
        #course-outline { grid-area: outline; }
        #course-reqs { grid-area: reqs; }
        #signatures { grid-area: signatures; }
    </style>
</head>

<body class="p-6 bg-gray-100">

        <div class="flex justify-end mb-6 px-4">
    <form action="{{ route('syllabus.template') }}" method="GET">
            @csrf    
        <button class="bg-yellow hover:scale-105 transition ease-in-out text-white px-4 py-2 rounded-lg shadow">
            Save Template
        </button>
    </div>

    <div class="grid-container">
        @php
            $sections = [
                'college-name' => 'COLLEGE NAME',
                'syllabus' => 'Syllabus',
                'vision-mission' => 'Vision & Mission',
                'course-desc' => 'Course Description',
                'course-outcomes' => 'Course Outcomes',
                'course-outline' => 'Course Outline',
                'course-reqs' => 'Course Requirements',
                'signatures' => 'Signatures'
            ];
        @endphp

        <div class="section" id="college-name">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <span class="font-bold">COLLEGE NAME</span>
        </div>

        <div class="section" id="syllabus">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <span class="font-bold underline underline-offset-4">Syllabus</span><br>
            Course Title : <span class="font-bold"></span><br>
            Course Code : <br>
            Credits     : <br>
        </div>

        <div class="section" id="vision-mission">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <div class="mt-2 mb-8"><span class="font-bold pt-4 block">USTP Vision<br><br></span></div>
            <div class="mb-8"><span class="font-bold">USTP Mission<br><br></span></div>
            <div class="mb-8"><span class="font-bold">Program Educational Objectives<br><br></span></div>
            <div class="mb-8"><span class="font-bold">Program Outcomes<br><br></span></div>
        </div>

        <div class="section" id="course-desc">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <table class="my-4 w-full">
                <tr>
                    <td class="border-2 font-medium text-left px-4 w-1/2">Semester/Year:<br>Class Schedule:<br>Bldg./Rm. No.:</td>
                    <td class="border-2 font-medium text-left px-4">Pre-requisite(s):<br>Co-requisite(s):</td>
                </tr>
                <tr>
                    <td class="border-2 font-medium text-left px-4">Instructor:<br>Email:<br>Phone:</td>
                    <td class="border-2 font-medium text-left px-4">Consultation Schedule:<br>Bldg./Rm. No.:</td>
                </tr>
            </table>
            <span class="font-bold">I. Course Description:</span><br><br>
        </div>

        <div class="section" id="course-outcomes">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <span class="font-bold">II. Course Outcomes:</span>
            <table class="mt-4 border w-full border-solid">
                <tr><th class="border-2">Course Outcomes (CO)</th><th class="border-2"></th><th class="border-2"></th></tr>
                <tr><td class="border-2">CO1: Understand basic concepts</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                <tr><td class="border-2">CO2: Apply design thinking</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
            </table>
        </div>

        <div class="section" id="course-outline">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <span class="font-bold">III. Course Outline:</span>
            <table class="mt-2 border w-full border-solid">
                <tr>
                    <th class="border-2">Time</th><th class="border-2">ILO</th><th class="border-2">Topics</th><th class="border-2">Readings</th><th class="border-2">Activities</th><th class="border-2">Assessment</th><th class="border-2">Grading</th>
                </tr>
                <tr>
                    <td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td>
                </tr>
            </table>
        </div>

        <div class="section" id="course-reqs">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <span class="font-bold">IV. Course Requirements:</span><br><br>
        </div>

        <div class="section" id="signatures">
            <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
            <table class="w-full border-2 border-black text-center mt-8">
                <tr>
                    <td class="border border-black p-4">Prepared By:<br><br><br>___________________________<br><span class="font-bold">INSTRUCTOR NAME</span><br>Instructor</td>
                    <td class="border border-black p-4">Checked and Recommended for Approval:<br><br><br>___________________________<br><span class="font-bold">CHAIRPERSON NAME</span><br>Chairperson, Department</td>
                    <td class="border border-black p-4">Approved by:<br><br><br>___________________________<br><span class="font-bold">DEAN NAME</span><br>Dean, College</td>
                </tr>
            </table>
        </div>
    </div>
</body>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const grid     = document.querySelector(".grid-container");
    const sections = document.querySelectorAll(".section");
    let   dragSource = null;

    /* =========  DRAG‑AND‑SWAP (unchanged logic)  ========= */
    sections.forEach(section => {
        const handle = section.querySelector(".handle button");
        if (!handle) return;

        handle.style.cursor = "move";
        section.setAttribute("draggable", true);

        section.addEventListener("dragstart", e => {
            dragSource = section;
            e.dataTransfer.effectAllowed = "move";
        });
        section.addEventListener("dragend", () => dragSource = null);

        section.addEventListener("dragover", e => { e.preventDefault(); section.classList.add("drag-over"); });
        section.addEventListener("dragleave", () => section.classList.remove("drag-over"));

        section.addEventListener("drop", e => {
            e.preventDefault();
            section.classList.remove("drag-over");
            if (dragSource === section) return;

            const srcArea = dragSource.style.gridArea || getComputedStyle(dragSource).gridArea;
            const tgtArea = section   .style.gridArea || getComputedStyle(section)   .gridArea;

            dragSource.style.gridArea = tgtArea;
            section   .style.gridArea = srcArea;

            /* nuke any explicit px sizing so each stretches in its new slot */
            [dragSource, section].forEach(card => {
                card.style.width  = "";
                card.style.height = "";
            });
        });
    });

    /* =========  FILL BLANK GAP  (only change: pin the row)  ========= */
    grid.addEventListener("dragover", e => e.preventDefault());

    grid.addEventListener("drop", e => {
        if (!dragSource) return;

        const rect   = grid.getBoundingClientRect();

        /* Which column? ------------------------------------------------- */
        const colWidth = rect.width / 3;                               // 3 template columns
        const colNum   = Math.min(Math.floor((e.clientX - rect.left) / colWidth) + 1, 3);

        /* Which row?  We assume the six template rows have equal height. */
        const rowHeight = rect.height / 6;                             // 6 template rows
        const rowNum    = Math.min(Math.floor((e.clientY - rect.top)  / rowHeight) + 1, 6);

        dragSource.style.gridArea   = "unset";                         // override old named area
        dragSource.style.gridColumn = colNum;                          // explicit column
        dragSource.style.gridRow    = rowNum;                          // explicit row

        dragSource.style.width  = "";
        dragSource.style.height = "";

        dragSource = null;
    });

    /* =========  RESIZE (same as before)  ========= */
    interact(".section").resizable({
        edges: {left:true,right:true,top:true,bottom:true},
        listeners: {
            move (event) {
                const tgt      = event.target;
                const gridRect = tgt.closest(".grid-container").getBoundingClientRect();
                const tgtRect  = tgt.getBoundingClientRect();

                let w = event.rect.width,
                    h = event.rect.height;

                const maxRight = gridRect.left + gridRect.width;
                if (tgtRect.left + event.deltaRect.left + w > maxRight)
                    w = maxRight - tgtRect.left;

                if (w < 150) w = 150;
                if (h < 60)  h = 60;

                tgt.style.width  = `${w}px`;
                tgt.style.height = `${h}px`;

                tgt.style.transform = "";
            }
        },
        modifiers: [interact.modifiers.restrictEdges({outer:"parent", endOnly:true})],
        inertia:true
    });

});
</script>



</html>
@endsection

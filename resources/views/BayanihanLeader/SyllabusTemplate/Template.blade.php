
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
        <!-- GridStack 9.x (HTML5 drag+resize build) -->
    <link href="https://cdn.jsdelivr.net/npm/gridstack@9.4.0/dist/gridstack.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gridstack@9.4.0/dist/gridstack-h5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 2fr 2fr 3fr;
            grid-template-rows: repeat(6,minmax(60px,auto)); /* ← NEW */
            position:relative;   /* ← gives the hi overlay the correct origin   */
            gap: 1px;
            width: 1024px;
            margin: 1rem auto;
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


    
    </style>
</head>

<body class="p-6 bg-gray-100">


    <div class="flex justify-between mb-6 px-4">
        <button id="undoBtn" class="bg-gray-300 hover:scale-105 transition ease-in-out text-black px-4 py-2 rounded-lg shadow">
            Undo
        </button>

        <form action="{{ route('syllabus.template') }}" method="GET">
            @csrf
            <button id="doneBtn" type="button" class="bg-yellow hover:scale-105 transition ease-in-out text-white px-4 py-2 rounded-lg shadow">
                Done
            </button>
        </form>
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

    <div id="saveModal"
            class="fixed inset-0 flex items-center justify-center bg-white/10 backdrop-blur-sm hidden">
        <div class="bg-white w-80 p-6 rounded-lg shadow-lg z-50">  <!-- <- z‑index -->
            <h2 class="text-lg font-bold mb-4">Save Template</h2>

            <label class="block text-sm font-medium">Template Name:</label>
            <input id="tplName"
                type="text"
                class="w-full border rounded p-2 mb-3"
                placeholder="e.g. Midterm Syllabus">

            <div class="flex justify-end gap-2">
            <button id="modCancel"
                    class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400">
                Cancel
            </button>
            <button id="modSave"
                    class="px-3 py-1 rounded bg-yellow text-white hover:brightness-110">
                Save
            </button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // ───────── Undo Feature ─────────
            const undoBtn = document.getElementById('undoBtn');
            const historyStack = [];

            function captureLayout() {
                const snapshot = {};
                document.querySelectorAll('.section').forEach(sec => {
                    snapshot[sec.id] = {
                        col: +sec.dataset.col,
                        row: +sec.dataset.row,
                        colSpan: +sec.dataset.colSpan,
                        rowSpan: +sec.dataset.rowSpan
                    };
                });
                historyStack.push(snapshot);
            }

            function applyLayout(snapshot) {
                Object.entries(snapshot).forEach(([id, pos]) => {
                    const el = document.getElementById(id);
                    if (el) applyPos(el, pos);
                });
            }

            if (undoBtn) {
                undoBtn.addEventListener('click', () => {
                    if (historyStack.length > 0) {
                        const last = historyStack.pop();
                        applyLayout(last);
                    } else {
                        alert("Nothing to undo.");
                    }
                });
            }

        /* ───────── 1 · Initial numeric coords (unchanged) ───────── */
        const layout = {
            "college-name":   { col: 1, row: 1, colSpan: 2, rowSpan: 1 },
            "syllabus":       { col: 3, row: 1, colSpan: 1, rowSpan: 1 },
            "vision-mission": { col: 1, row: 2, colSpan: 1, rowSpan: 4 },
            "course-desc":    { col: 2, row: 2, colSpan: 2, rowSpan: 1 },
            "course-outcomes":{ col: 2, row: 3, colSpan: 2, rowSpan: 1 },
            "course-outline": { col: 2, row: 4, colSpan: 2, rowSpan: 1 },
            "course-reqs":    { col: 2, row: 5, colSpan: 2, rowSpan: 1 },
            "signatures":     { col: 1, row: 6, colSpan: 3, rowSpan: 1 },
        };

        const grid      = document.querySelector(".grid-container");
        const sections  = document.querySelectorAll(".section");
        let   dragSrc   = null;
        let   gapRect   = null;

        Object.entries(layout).forEach(([id,pos]) => {
            const el = document.getElementById(id);
            if (el) applyPos(el, pos);
        });

        function applyPos(el, pos) {
            el.style.gridColumn = `${pos.col} / span ${pos.colSpan}`;
            el.style.gridRow    = `${pos.row} / span ${pos.rowSpan}`;
            el.dataset.col      = pos.col;
            el.dataset.row      = pos.row;
            el.dataset.colSpan  = pos.colSpan;
            el.dataset.rowSpan  = pos.rowSpan;
            el.style.width = el.style.height = "";
        }

        function trackEnds(templateProp, totalPx) {
            const parts = templateProp.split(/\s+/);
            const pxParts = parts.filter(p => p.endsWith('px'));
            if (pxParts.length === parts.length) {
                let acc = 0; return parts.map(p => acc += parseFloat(p));
            }
            const frTotal = parts.reduce((s,p)=>s+parseFloat(p),0);
            let acc=0;
            return parts.map(p => acc += totalPx * (parseFloat(p)/frTotal));
        }

        function getColLines() {
            return trackEnds(
                getComputedStyle(grid).gridTemplateColumns,
                grid.getBoundingClientRect().width
            );
        }
        function getRowLines() {
            return trackEnds(
                getComputedStyle(grid).gridTemplateRows,
                grid.getBoundingClientRect().height
            );
        }

        function colFromX(clientX) {
            const rect = grid.getBoundingClientRect();
            const x = clientX - rect.left;
            const lines = getColLines();
            if (x < 0 || x > lines.at(-1)) return null;
            if (x <= lines[0]) return 1;
            if (x <= lines[1]) return 2;
            return 3;
        }
        function rowFromY(clientY) {
            const rect = grid.getBoundingClientRect();
            const y = clientY - rect.top;
            const lines = getRowLines();
            if (y < 0 || y > lines.at(-1)) return null;
            for (let i = 0; i < lines.length; i++) {
            if (y <= lines[i]) return i + 1;
            }
            return null;
        }

        const hi = Object.assign(document.createElement("div"), {
            style: `
            position:absolute;pointer-events:none;display:none;
            background:rgba(120,122,124,.25);border:2px dashed gray;z-index:40;`
        });
        grid.appendChild(hi);
        function showHi(rect) {
            const colLines = [0, ...getColLines()];
            const rowLines = [0, ...getRowLines()];
            const left  = colLines[rect.col-1];
            const top   = rowLines[rect.row-1];
            const width  = colLines[rect.col-1+rect.colSpan] - left;
            const height = rowLines[rect.row-1+rect.rowSpan] - top;
            Object.assign(hi.style,{
            left:left+"px",top:top+"px",width:width+"px",height:height+"px",display:"block"
            });
        }
        const hideHi = () => hi.style.display="none";

        function getRows() { return getRowLines().length; }
        function buildOcc(exclude=null) {
            const occ = Array.from({length:getRows()+1},() => Array(4).fill(false));
            sections.forEach(el=>{
            if (el===exclude) return;
            const c0=+el.dataset.col, r0=+el.dataset.row;
            const cs=+el.dataset.colSpan, rs=+el.dataset.rowSpan;
            for(let r=r0;r<r0+rs;r++) for(let c=c0;c<c0+cs;c++) occ[r][c]=true;
            });
            return occ;
        }

        sections.forEach(sec=>{
            const btn = sec.querySelector(".handle button"); if(!btn) return;
            btn.style.cursor="move"; sec.draggable=true;

            sec.addEventListener("dragstart",e=>{
            dragSrc=sec; gapRect=null; e.dataTransfer.effectAllowed="move";
            });
            sec.addEventListener("dragend",()=>{dragSrc=null;hideHi();});

            sec.addEventListener("dragover",e=>{
            e.preventDefault(); sec.classList.add("drag-over");
            });
            sec.addEventListener("dragleave",()=>sec.classList.remove("drag-over"));

            sec.addEventListener("drop",e=>{
            e.preventDefault(); sec.classList.remove("drag-over");
            if(dragSrc===sec) return;
            captureLayout();
            const srcPos={col:dragSrc.dataset.col,row:dragSrc.dataset.row,
                            colSpan:dragSrc.dataset.colSpan,rowSpan:dragSrc.dataset.rowSpan};
            const tgtPos={col:sec.dataset.col,row:sec.dataset.row,
                            colSpan:sec.dataset.colSpan,rowSpan:sec.dataset.rowSpan};
            applyPos(dragSrc,tgtPos); applyPos(sec,srcPos);
            });
        });

        grid.addEventListener("dragover",e=>{
            if(!dragSrc) return; e.preventDefault();
            const col=colFromX(e.clientX),row=rowFromY(e.clientY);
            if(!col||!row) {hideHi();gapRect=null;return;}

            const elUnder = document.elementFromPoint(e.clientX,e.clientY);
            if(elUnder && elUnder.closest(".section") && elUnder.closest(".section")!==dragSrc){
            hideHi();gapRect=null;return;
            }

            const occ = buildOcc(dragSrc);
            if(occ[row][col]) {hideHi();gapRect=null;return;}

            let maxCS=0; for(let c=col;c<=3 && !occ[row][c];c++) maxCS++;
            if(maxCS===0){hideHi();gapRect=null;return;}

            let maxRS=0,rows=getRows(),go=true;
            for(let r=row;r<=rows&&go;r++){
            for(let c=col;c<col+maxCS;c++){ if(occ[r][c]){go=false;break;} }
            if(go) maxRS++; else break;
            }

            gapRect={col,row,colSpan:maxCS,rowSpan:maxRS};
            showHi(gapRect);
        });

        grid.addEventListener("drop",e=>{
            e.preventDefault(); hideHi();
            if(dragSrc && gapRect){
            captureLayout();
            applyPos(dragSrc,gapRect);
            }
            dragSrc=null; gapRect=null;
        });

        interact('.section').resizable({
  edges : { left:true, right:true, top:true, bottom:true },
  listeners : {
    move (ev) {
      const tgt = ev.target;
      let w = ev.rect.width,  h = ev.rect.height;
      if (w < 150) w = 150;
      if (h < 60 ) h = 60 ;
      tgt.style.width  = w + 'px';
      tgt.style.height = h + 'px';
      const dx = (parseFloat(tgt.dataset.dx) || 0) + ev.deltaRect.left;
      const dy = (parseFloat(tgt.dataset.dy) || 0) + ev.deltaRect.top;
      tgt.style.transform = `translate(${dx}px, ${dy}px)`;
      tgt.dataset.dx = dx; tgt.dataset.dy = dy;
    },
    async end (ev) {
      const tgt = ev.target;
      const dx = parseFloat(tgt.dataset.dx) || 0;
      const dy = parseFloat(tgt.dataset.dy) || 0;
      tgt.style.transform = '';
      delete tgt.dataset.dx; delete tgt.dataset.dy;
      const prevPosition = tgt.style.position || '';
      tgt.style.position = 'absolute';
      tgt.style.left = (tgt.offsetLeft + dx) + 'px';
      tgt.style.top  = (tgt.offsetTop  + dy) + 'px';
      const box = tgt.getBoundingClientRect();
      const colStart = colFromX(box.left  + 1);
      const colEnd   = colFromX(box.right - 1);
      const rowStart = rowFromY(box.top   + 1);
      const rowEnd   = rowFromY(box.bottom- 1);
      if (!colStart || !rowStart || !colEnd || !rowEnd) {
        tgt.style.position = prevPosition;
        tgt.style.left = tgt.style.top = '';
        return;
      }
      captureLayout();
      applyPos(tgt, {
        col     : colStart,
        row     : rowStart,
        colSpan : colEnd - colStart + 1,
        rowSpan : rowEnd - rowStart + 1
      });
      tgt.style.position = prevPosition;
      tgt.style.left = tgt.style.top = '';
      tgt.style.width = tgt.style.height = '';
    }
  },
  modifiers : [
    interact.modifiers.restrictEdges({ outer:'parent', endOnly:true })
  ],
  inertia : true
});

        /* The remaining save modal logic is untouched */
        const doneBtn   = document.getElementById('doneBtn');
        const saveModal = document.getElementById('saveModal');
        const modCancel = document.getElementById('modCancel');
        const modSave   = document.getElementById('modSave');
        const tplName   = document.getElementById('tplName');

        const editIdx  = localStorage.getItem('editingIndex');
        const editing  = JSON.parse(localStorage.getItem('editingTemplate') || 'null');
        if (editing) tplName.value = editing.name || '';

        doneBtn.addEventListener('click', async e => {
        e.preventDefault();
        if (editIdx !== null) {
            await saveTemplate(editing.name);
        } else {
            saveModal.classList.remove('hidden');
            tplName.focus();
        }
        });

        modSave.addEventListener('click', async () => {
        const name = tplName.value.trim();
        if (!name) { alert('Template name is required.'); return; }
        await saveTemplate(name);
        saveModal.classList.add('hidden');
        });

        [modCancel, saveModal].forEach(el =>
        el.addEventListener('click', e => {
            if (e.target === saveModal || e.target === modCancel)
            saveModal.classList.add('hidden');
        }));

        async function saveTemplate(name) {
        const canvas = await html2canvas(grid, { backgroundColor:'#ffffff' });
        const img    = canvas.toDataURL('image/png');
        const templates = JSON.parse(localStorage.getItem('templates') || '[]');

        if (editIdx !== null) {
            templates[+editIdx] = { name, img };
            localStorage.removeItem('editingIndex');
            localStorage.removeItem('editingTemplate');
        } else {
            templates.push({ name, img });
        }
        localStorage.setItem('templates', JSON.stringify(templates));

        window.location.href = "{{ route('bayanihanleader.createTemplate') }}";
        }

        });
    </script>



</body>

</html>
@endsection

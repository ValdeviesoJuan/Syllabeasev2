
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
            border: 2px solid gray;
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
            z-index: 1;
            user-select: none;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Interact.js resize handles */
        .section .resize-handle {
            position: absolute;
            z-index: 10;
            background: transparent;
        }
        .resize-handle-top {
            top: -6px;
            left: 0;
            width: 100%;
            height: 12px;
            cursor: n-resize;
        }
        .resize-handle-left {
            top: 0;
            left: -6px;
            width: 12px;
            height: 100%;
            cursor: w-resize;
        }
        .resize-handle-bottom {
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 12px;
            cursor: s-resize;
        }
        .resize-handle-right {
            top: 0;
            right: -6px;
            width: 12px;
            height: 100%;
            cursor: e-resize;
        }
        .resize-handle-corner {
            width: 16px;
            height: 16px;
            background: transparent;
        }
        .resize-handle-topleft {
            top: -8px;
            left: -8px;
            cursor: nw-resize;
        }
        .resize-handle-topright {
            top: -8px;
            right: -8px;
            cursor: ne-resize;
        }
        .resize-handle-bottomleft {
            bottom: -8px;
            left: -8px;
            cursor: sw-resize;
        }
        .resize-handle-bottomright {
            bottom: -8px;
            right: -8px;
            cursor: se-resize;
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

        #undoBtn {
            background-color: #c7c8ccff; /* light gray (Tailwind gray-100) */
            color: #111827;   /* dark gray (Tailwind gray-900) */
        }    

        #undoBtn:hover {
            background-color: #e5e7eb; /* slightly darker gray on hover (Tailwind gray-200) */
        }

        .flex-1.flex { position: relative; z-index: 0; }
        body { overflow: visible; }
        .dragging-clone {
            opacity: 0.9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        #drop-zone {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(4, 1fr);
            width: 1024px;
            height: 768px;
            position: relative;
            overflow: hidden;
        }
        #hover-highlight {
            position: absolute;
            background-color: rgba(100, 149, 237, 0.3); /* light blue */
            border: 2px solid cornflowerblue;
            pointer-events: none;
            z-index: 100;
            display: none;
        }
        #swap-highlight {
            position: absolute;
            border: 2px solid #22c55e; /* solid green */
            background: rgba(34, 197, 94, 0.15); /* light green */
            z-index: 101;
            pointer-events: none;
            display: none;
        }

        .section.swap-hover {
            background-color: rgba(59, 130, 246, 0.25); /* Tailwind blue-500 with opacity */
            transition: background 0.15s;
        }

        .section.selected {
            box-shadow: 0 0 0 3px #2563eb; /* blue outline */
            z-index: 10;
        }
    
    </style>
</head>

<body class="p-6 bg-gray-100">


    <div class="sticky top-0 z-50 bg-white flex justify-between mb-6 px-4 py-2">
        <button id="undoBtn" class="bg-gray-100 hover:scale-105 transition ease-in-out text-black px-4 py-2 rounded-lg shadow h-[44px]">
            Undo
        </button>

        <form action="{{ route('syllabus.template') }}" method="GET">
            @csrf
            <button id="doneBtn" type="button" class="bg-yellow hover:scale-105 transition ease-in-out text-white px-4 py-2 rounded-lg shadow">
                Done
            </button>   
        </form>
    </div>


    <div class="flex items-start px-4 py-6 gap-4 bg-gray-100">
        
            <!-- Sidebar (Selection) -->
            <div class="w-[350px] h-[898px] overflow-y-auto border-2 border-yellow p-4 bg-[#6495ED] space-y-4 br-2 rounded-lg">

                <!-- Clone of all sections for selection (no functional logic yet) -->
                <div class="section draggable" id="college-name">
                    <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                    <span class="font-bold">COLLEGE NAME</span>
                </div>

                <div class="section draggable" id="syllabus">
                    <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                    <span class="font-bold underline underline-offset-4">Syllabus</span><br>
                    Course Title : <span class="font-bold"></span><br>
                    Course Code : <br>
                    Credits     : <br>
                </div>

                <div class="section draggable" id="vision-mission">
                    <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                    <div class="mt-2 mb-8"><span class="font-bold pt-4 block">USTP Vision<br><br></span></div>
                    <div class="mb-8"><span class="font-bold">USTP Mission<br><br></span></div>
                    <div class="mb-8"><span class="font-bold">Program Educational Objectives<br><br></span></div>
                    <div class="mb-8"><span class="font-bold">Program Outcomes<br><br></span></div>
                </div>

                <div class="section draggable" id="course-desc">
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

                <div class="section draggable" id="course-outcomes">
                    <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                    <span class="font-bold">II. Course Outcomes:</span>
                    <table class="mt-4 border w-full border-solid">
                        <tr><th class="border-2">Course Outcomes (CO)</th><th class="border-2"></th><th class="border-2"></th></tr>
                        <tr><td class="border-2">CO1: Understand basic concepts</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                        <tr><td class="border-2">CO2: Apply design thinking</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                    </table>
                </div>

                <div class="section draggable" id="course-outline">
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

                <div class="section draggable" id="course-reqs">
                    <div class="handle"><button class="p-1" title="Drag"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]" alt="Drag"></button></div>
                    <span class="font-bold">IV. Course Requirements:</span><br><br>
                </div>

                <div class="section draggable" id="signatures">
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


            <!-- Main Container -->
            <div class="flex-1 flex justify-center">
                <div id="drop-zone" class="grid grid-cols-3 grid-rows-4 gap-0 p-0 border-2 border-gray h-[898px] w-full max-w-[1024px] bg-white shadow-md overflow-y-auto" >
                    <div id="hover-highlight"></div>
                    <div id="swap-highlight" style="display:none; position:absolute; z-index:101; pointer-events:none;"></div>
                    <!-- Empty for now, drag-and-drop will populate this -->
                </div>
            </div>
    </div>



   <script>
document.addEventListener("DOMContentLoaded", () => {
  const dropZone = document.getElementById('drop-zone');
  const highlight = document.getElementById('hover-highlight');
  let dragClone = null;
  let isFromDropZone = false;

  function getGridPosition(x, y, container) {
    const rect = container.getBoundingClientRect();
    const colWidth = rect.width / 3;
    const rowHeight = rect.height / 4;
    const col = Math.floor((x - rect.left) / colWidth) + 1;
    const row = Math.floor((y - rect.top) / rowHeight) + 1;
    return { col, row, colWidth, rowHeight };
  }

  interact('.draggable, #drop-zone .section').draggable({
    listeners: {
      start(event) {
        const original = event.target;
        isFromDropZone = original.closest('#drop-zone') !== null;

        if (isFromDropZone) {
          dragClone = original;
          dragClone.style.zIndex = 1000;
        } else {
          dragClone = original.cloneNode(true);
          dragClone.classList.add('dragging-clone');
          dragClone.style.position = 'fixed';
          dragClone.style.pointerEvents = 'none';
          dragClone.style.zIndex = 9999;
          dragClone.style.width = `${original.offsetWidth}px`;
          dragClone.style.height = `${original.offsetHeight}px`;
          document.body.appendChild(dragClone);
        }
      },

      move(event) {
        if (!dragClone) return;
        const dropRect = dropZone.getBoundingClientRect();
        let x = event.client.x - dragClone.offsetWidth / 2;
        let y = event.client.y - dragClone.offsetHeight / 2;
        x = Math.max(dropRect.left, Math.min(x, dropRect.right - dragClone.offsetWidth));
        y = Math.max(dropRect.top, Math.min(y, dropRect.bottom - dragClone.offsetHeight));

        if (!isFromDropZone) {
          dragClone.style.left = `${x}px`;
          dragClone.style.top = `${y}px`;
        }

        const { col, row, colWidth, rowHeight } = getGridPosition(event.client.x, event.client.y, dropZone);

        if (col > 0 && row > 0 && col <= 3 && row <= 4) {
          highlight.style.left = `${(col - 1) * colWidth}px`;
          highlight.style.top = `${(row - 1) * rowHeight}px`;
          highlight.style.width = `${colWidth}px`;
          highlight.style.height = `${rowHeight}px`;
          highlight.style.display = 'block';
        } else {
          highlight.style.display = 'none';
        }

        [...dropZone.querySelectorAll('.section.swap-hover')].forEach(s => s.classList.remove('swap-hover'));

        let targetSection = null;
        [...dropZone.querySelectorAll('.section')].forEach(section => {
          if (section === dragClone) return;
          const rect = section.getBoundingClientRect();
          if (
            event.client.x >= rect.left &&
            event.client.x <= rect.right &&
            event.client.y >= rect.top &&
            event.client.y <= rect.bottom
          ) {
            targetSection = section;
          }
        });

        if (targetSection) {
          targetSection.classList.add('swap-hover');
        }
      },

      end(event) {
        if (!dragClone) return;

        const { col, row } = getGridPosition(event.client.x, event.client.y, dropZone);
        const dropRect = dropZone.getBoundingClientRect();
        const centerX = event.client.x;
        const centerY = event.client.y;
        const isInside =
          centerX >= dropRect.left &&
          centerX <= dropRect.right &&
          centerY >= dropRect.top &&
          centerY <= dropRect.bottom;

        highlight.style.display = 'none';
        [...dropZone.querySelectorAll('.section.swap-hover')].forEach(s => s.classList.remove('swap-hover'));

        if (isInside) {
          let targetSection = null;
          [...dropZone.querySelectorAll('.section')].forEach(section => {
            if (section === dragClone) return;
            const rect = section.getBoundingClientRect();
            if (
              centerX >= rect.left &&
              centerX <= rect.right &&
              centerY >= rect.top &&
              centerY <= rect.bottom
            ) {
              targetSection = section;
            }
          });

          if (targetSection) {
            const dragGridCol = dragClone.style.gridColumn;
            const dragGridRow = dragClone.style.gridRow;
            const dragWidth = dragClone.style.width;
            const dragHeight = dragClone.style.height;

            const targetGridCol = targetSection.style.gridColumn;
            const targetGridRow = targetSection.style.gridRow;
            const targetWidth = targetSection.style.width;
            const targetHeight = targetSection.style.height;

            dragClone.style.gridColumn = targetGridCol;
            dragClone.style.gridRow = targetGridRow;
            dragClone.style.width = targetWidth;
            dragClone.style.height = targetHeight;

            targetSection.style.gridColumn = dragGridCol || `${col} / span 1`;
            targetSection.style.gridRow = dragGridRow || `${row} / span 1`;
            targetSection.style.width = dragWidth || '';
            targetSection.style.height = dragHeight || '';
          } else {
            let cellOccupied = false;
            [...dropZone.querySelectorAll('.section')].forEach(section => {
              const style = window.getComputedStyle(section);
              const sectionCol = parseInt(style.gridColumnStart);
              const sectionRow = parseInt(style.gridRowStart);
              if (sectionCol === col && sectionRow === row) {
                cellOccupied = true;
              }
            });

            if (cellOccupied) {
              if (!isFromDropZone) dragClone.remove();
            } else {
              if (!isFromDropZone) {
                dragClone.classList.remove('dragging-clone');
                dragClone.style.position = '';
                dragClone.style.pointerEvents = 'auto';
                dragClone.style.left = '';
                dragClone.style.top = '';
                dragClone.style.width = '';
                dragClone.style.height = '';

                if (!dragClone.classList.contains('section')) {
                  dragClone.classList.add('section');
                }

                dropZone.appendChild(dragClone);
              }

              dragClone.style.gridColumn = `${col} / span 1`;
              dragClone.style.gridRow = `${row} / span 1`;
            }
          }
        } else if (!isFromDropZone) {
          dragClone.remove();
        }

        dragClone = null;
        isFromDropZone = false;
      }
    }
  });

  dropZone.addEventListener('click', function(e) {
    const section = e.target.closest('.section');
    if (!section) return;

    [...dropZone.querySelectorAll('.section.selected')].forEach(s => s.classList.remove('selected'));
    section.classList.add('selected');
  });
});

// RESIZING LOGIC
interact('#drop-zone .section').resizable({
  edges: { left: true, right: true, bottom: true, top: true },
  listeners: {
    move(event) {
      if (!event.target.classList.contains('selected')) return;

      const target = event.target;
      const dropZone = document.getElementById('drop-zone');
      const dzRect = dropZone.getBoundingClientRect();
      const targetRect = target.getBoundingClientRect();

      let w = parseFloat(target.style.width) || target.offsetWidth;
      let h = parseFloat(target.style.height) || target.offsetHeight;
      let newW = Math.round((w + event.deltaRect.width) / 20) * 20;
      let newH = Math.round((h + event.deltaRect.height) / 20) * 20;

      // ✅ Enforce both left and right boundaries
      const leftEdge = targetRect.left + event.deltaRect.left;
      const rightEdge = targetRect.right + event.deltaRect.right;

      if (leftEdge < dzRect.left) {
        const overflow = dzRect.left - leftEdge;
        newW -= overflow;
      }

      if (rightEdge > dzRect.right) {
        const overflow = rightEdge - dzRect.right;
        newW -= overflow;
      }

      // ✅ Enforce bottom boundary
      const bottomEdge = targetRect.bottom + event.deltaRect.bottom;
      if (bottomEdge > dzRect.bottom) {
        const overflow = bottomEdge - dzRect.bottom;
        newH -= overflow;
      }

      newW = Math.max(50, newW);
      newH = Math.max(50, newH);

      target.style.width = newW + 'px';
      target.style.height = newH + 'px';

      const tRect = target.getBoundingClientRect();
      const sections = [...dropZone.querySelectorAll('.section')].filter(s => s !== target);

      sections.forEach(section => {
        const sRect = section.getBoundingClientRect();
        const overlapX = tRect.left < sRect.right && tRect.right > sRect.left;
        const overlapY = tRect.top < sRect.bottom && tRect.bottom > sRect.top;
        if (overlapX && overlapY) {
          const sTop = parseFloat(section.style.top) || section.offsetTop;
          const sLeft = parseFloat(section.style.left) || section.offsetLeft;

          const shiftY = (tRect.bottom - sRect.top) + 10;
          const maxShiftY = dzRect.bottom - sRect.bottom;
          if (shiftY <= maxShiftY) {
            section.style.top = (sTop + shiftY) + 'px';
          } else {
            section.style.height = Math.max(50, sRect.height - (shiftY - maxShiftY)) + 'px';
          }

          const shiftX = (tRect.right - sRect.left) + 10;
          const maxShiftX = dzRect.right - sRect.right;
          if (shiftX <= maxShiftX) {
            section.style.left = (sLeft + shiftX) + 'px';
          } else {
            section.style.width = Math.max(50, sRect.width - (shiftX - maxShiftX)) + 'px';
          }
        }
      });
    }
  },
  modifiers: [
    interact.modifiers.restrictEdges({ outer: 'parent' }),
    interact.modifiers.restrictSize({ min: { width: 50, height: 50 }, max: { width: 1024, height: 768 } })
  ],
  inertia: true
});
</script>




</body>

</html>
@endsection

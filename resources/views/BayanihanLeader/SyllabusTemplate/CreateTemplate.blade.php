@extends('layouts.blNav')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <title>SyllabEase</title>
    @vite('resources/css/app.css')
    <style>
        body { background:#eaeaea; }

        /* Styles only used for the hidden default layout */
        #default-layout .syllabus-grid {
            display:grid;
            grid-template-columns: 2fr 2fr 3fr;   /* same as builder */
            gap:1px;
            width:1024px;                         /* fixed width matches builder */
            font-size:12px;                       /* match small text */
        }
        #default-layout .syllabus-cell {
            border:1px solid #000;
            padding:4px;
        }
        #default-layout .two-col  { grid-column:span 2; }
        #default-layout .full-row { grid-column:span 3; }
    </style>
</head>

<body>
  <div class="p-6 bg-blue-100 min-h-screen">

      <h1 class="text-2xl font-bold text-center">Select Template</h1>

      <div class="flex justify-end mb-6 px-4">
          <form action="{{ route('syllabus.template') }}" method="GET">
              @csrf
              <button class="bg-yellow hover:scale-105 transition text-white px-4 py-2 rounded-lg shadow">
                  + Create Syllabus Template
              </button>
          </form>
      </div>

      <!-- 🔒 hidden default layout for html2canvas -->
      <div id="default-layout" class="absolute -z-10 -left-[2000px] top-0 pointer-events-none select-none w-[1024px]">
          <div class="syllabus-grid">
              <!-- Row 1 -->    
              <div class="syllabus-cell two-col" id="college-name">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>COLLEGE NAME</strong>
              </div>
              <div class="syllabus-cell" id="syllabus">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong class="underline">Syllabus</strong><br>
                  Course Title:<br>Course Code:<br>Credits:
              </div>

              <!-- Row 2 – Vision block -->
              <div class="syllabus-cell" id="vision-mission" style="grid-row: span 4">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>Vision, Mission, PEO, PO</strong><br>- Vision<br>- Mission<br>- PEO<br>- PO
              </div>

              <!-- Course Description -->
              <div class="syllabus-cell two-col" id="course-desc">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>I. Course Description</strong><br>
                  <table class="w-full my-4">
                      <tr>
                          <td class="border-2 w-1/2">Semester/Year:<br>Class Schedule:<br>Bldg./Rm. No.:</td>
                          <td class="border-2">Pre‑requisite(s):<br>Co‑requisite(s):</td>
                      </tr>
                      <tr>
                          <td class="border-2">Instructor:<br>Email:<br>Phone:</td>
                          <td class="border-2">Consultation Schedule:<br>Bldg./Rm. No.:</td>
                      </tr>
                  </table>
              </div>

              <!-- Course Outcomes -->
              <div class="syllabus-cell two-col" id="course-outcomes">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>II. Course Outcomes</strong><br>
                  <table class="mt-4 border w-full border-solid">
                      <tr><th class="border-2">Course Outcomes (CO)</th><th class="border-2"></th><th class="border-2"></th></tr>
                      <tr><td class="border-2">CO1: Understand basic concepts</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                      <tr><td class="border-2">CO2: Apply design thinking</td><td class="border-2 text-center"></td><td class="border-2 text-center"></td></tr>
                  </table>
              </div>

              <!-- Course Outline -->
              <div class="syllabus-cell two-col" id="course-outline">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>III. Course Outline</strong><br>
                  <table class="mt-2 border w-full border-solid">
                      <tr>
                          <th class="border-2">Time</th><th class="border-2">ILO</th><th class="border-2">Topics</th>
                          <th class="border-2">Readings</th><th class="border-2">Activities</th>
                          <th class="border-2">Assessment</th><th class="border-2">Grading</th>
                      </tr>
                      <tr><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td>
                          <td class="border-2"></td><td class="border-2"></td><td class="border-2"></td><td class="border-2"></td></tr>
                  </table>
              </div>

              <!-- Course Requirements -->
              <div class="syllabus-cell two-col" id="course-reqs">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <strong>IV. Course Requirements</strong><br><br>
              </div>

              <!-- Signatures -->
              <div class="syllabus-cell full-row" id="signatures">
                  <div class="handle"><button class="p-1"><img src="{{ asset('assets/drag.svg') }}" class="w-[25px] h-[25px]"></button></div>
                  <table class="w-full border-2 border-black text-center mt-8">
                      <tr>
                          <td class="border p-4">Prepared By:<br><br><br>___________________________<br><span class="font-bold">INSTRUCTOR NAME</span><br>Instructor</td>
                          <td class="border p-4">Checked and Recommended for Approval:<br><br><br>___________________________<br><span class="font-bold">CHAIRPERSON NAME</span><br>Chairperson</td>
                          <td class="border p-4">Approved by:<br><br><br>___________________________<br><span class="font-bold">DEAN NAME</span><br>Dean</td>
                      </tr>
                  </table>
              </div>
          </div>  {{-- /syllabus-grid --}}
      </div>    {{-- /#default-layout --}}

      <!-- List container -->
      <div id="template-list" class="grid gap-6 grid-cols-1 sm:grid-cols-2">

          <!-- Default template card -->
          <div class="bg-white rounded-lg shadow-md p-4 relative max-w-xl mx-auto">
              <div class="flex items-center mb-2 card-header" style="min-height:64px;">
                  <label class="inline-flex items-center mr-2">
                      <input type="radio" name="template" value="template0" class="form-radio text-green">
                  </label>

                  <p class="flex-1 text-center text-blue-600 text-lg font-semibold">
                      Default Template
                  </p>

                  <div class="flex space-x-2">
                      <button class="text-red-600 hover:text-red-800 rounded px-2" title="Delete">
                          <img src="{{ asset('assets/delete.svg') }}" class="w-5 h-5">
                      </button>
                      <button class="text-yellow-500 hover:text-yellow-700 rounded px-2" title="View">
                          <img src="{{ asset('assets/view.svg') }}" class="w-5 h-5">
                      </button>
                      <button class="text-blue-500 hover:text-blue-700 rounded px-2" title="Edit">
                          <img src="{{ asset('assets/edit.svg') }}" class="w-5 h-5">
                      </button>
                  </div>
              </div>

              <div class="relative">
                    <img id="default-preview" src="" alt="Template Preview" class="w-full object-cover rounded">
              </div>
          </div>

      </div><!-- /#template-list -->

        <!-- 🔍 simple modal -->
        <div id="tplModal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center">
            <div class="bg-white rounded-lg p-4 w-[90%] max-w-3xl">
                <div class="flex justify-between items-center mb-2">
                    <h2 id="tplModalTitle" class="text-lg font-semibold"></h2>
                    <button id="tplModalClose" class="text-red-600 text-xl">&times;</button>
                </div>
                <img id="tplModalImg" src="" class="w-full rounded border">
                <div class="text-right mt-4">
                    <button id="tplModalEdit"
                            class="px-4 py-1 bg-yellow text-white rounded">Edit in Builder</button>
                </div>
        </div>
</div>


        
    <script>
        document.addEventListener('DOMContentLoaded', async () => {

            /* 1. Build the default‑card thumbnail (unchanged) */
            const layoutEl  = document.getElementById('default-layout');
            const previewEl = document.getElementById('default-preview');
            if (layoutEl && previewEl) {
                const canvas = await html2canvas(layoutEl, {
                    backgroundColor: '#ffffff', scale: 1
                });
                previewEl.className = 'w-full object-cover rounded';
                previewEl.src       = canvas.toDataURL('image/png');
            }

            // Active template state (persisted in localStorage)
            let activeTemplateIdx = parseInt(localStorage.getItem('activeTemplateIdx') || '0', 10);

            /* 2. Render saved templates ------------------------------------------------ */
            const list = document.querySelector('#template-list');

            function loadSaved() {
                list.querySelectorAll('[data-tpl]').forEach(el => el.remove());
                const saved = JSON.parse(localStorage.getItem('templates') || '[]');

                saved.forEach((tpl, i) => {
                    const card = document.createElement('div');
                    card.dataset.tpl = i;
                    card.className = "bg-white rounded-lg shadow-md p-4 relative max-w-xl mx-auto mt-6";
                    // Radio value is 'template' + (i+1) for consistency
                    card.innerHTML = `
                    <div class="flex items-center mb-2 card-header" style="min-height:64px;">
                        <label class="inline-flex items-center mr-2">
                            <input type="radio" name="template" value="template${i+1}"
                                    class="form-radio text-green">
                        </label>
                        <p class="flex-1 text-center text-blue-600 text-lg font-semibold">
                            ${tpl.name}
                        </p>
                        <div class="flex space-x-2">
                            <button class="btn-del text-red-600 rounded px-2" title="Delete">
                                <img src="{{ asset('assets/delete.svg') }}" class="w-5 h-5">
                            </button>
                            <button class="btn-view text-yellow-500 rounded px-2" title="View">
                                <img src="{{ asset('assets/view.svg') }}" class="w-5 h-5">
                            </button>
                            <button class="btn-edit text-blue-500 rounded px-2" title="Edit">
                                <img src="{{ asset('assets/edit.svg') }}" class="w-5 h-5">
                            </button>
                        </div>
                    </div>
                    <div class="relative">
                        <img src="${tpl.img}" alt="Template Preview"
                            class="w-full object-cover rounded">
                    </div>`;
                    list.appendChild(card);
                });

                // Set active radio and highlight
                setActiveTemplateUI();
            }
            loadSaved();

            // Set active template UI
            function setActiveTemplateUI() {
                // Default card
                const defaultRadio = list.querySelector('input[name="template"][value="template0"]');
                const defaultCard = list.querySelector('input[name="template"][value="template0"]')?.closest('.bg-white');
                if (defaultRadio) {
                    defaultRadio.checked = activeTemplateIdx === 0;
                    if (defaultCard) {
                        if (activeTemplateIdx === 0) {
                            defaultCard.classList.add('ring-2', 'ring-blue-500');
                        } else {
                            defaultCard.classList.remove('ring-2', 'ring-blue-500');
                        }
                    }
                }
                // Saved cards
                list.querySelectorAll('[data-tpl]').forEach(card => {
                    const idx = +card.dataset.tpl;
                    const radio = card.querySelector('input[name="template"]');
                    // activeTemplateIdx === idx+1 means radio value is 'template'+(idx+1)
                    radio.checked = activeTemplateIdx === idx + 1;
                    if (activeTemplateIdx === idx + 1) {
                        card.classList.add('ring-2', 'ring-blue-500');
                    } else {
                        card.classList.remove('ring-2', 'ring-blue-500');
                    }
                });
            }

            // Listen for radio changes
            list.addEventListener('change', e => {
                if (e.target.name === 'template') {
                    if (e.target.value === 'template0') {
                        activeTemplateIdx = 0;
                        localStorage.setItem('activeTemplateIdx', activeTemplateIdx);
                        localStorage.setItem('activeTemplateData', JSON.stringify({type: 'default'}));
                    } else {
                        // Saved templates: value is 'template'+(idx+1)
                        const idx = parseInt(e.target.value.replace('template', ''), 10) - 1;
                        activeTemplateIdx = idx + 1;
                        localStorage.setItem('activeTemplateIdx', activeTemplateIdx);
                        const saved = JSON.parse(localStorage.getItem('templates') || '[]');
                        if (saved[idx]) {
                            localStorage.setItem('activeTemplateData', JSON.stringify(saved[idx]));
                        }
                    }
                    setActiveTemplateUI();
                }
                if (!localStorage.getItem('activeTemplateData')) {
                    localStorage.setItem('activeTemplateData', JSON.stringify({type: 'default'}));
                }
            });

            /* 3. Build / reuse the View modal ----------------------------------------- */
            let modalWrap = null;
            function ensureModal() {
                if (modalWrap) return;
                modalWrap = document.createElement('div');
                modalWrap.id = 'tplModal';
                modalWrap.className =
                'fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50';

                modalWrap.innerHTML = `
                <div class="bg-white rounded-lg p-4 w-[90%] max-w-3xl">
                    <div class="flex justify-between items-center mb-2">
                        <h2 id="tplModalTitle" class="text-lg font-semibold"></h2>
                        <button id="tplModalClose" class="text-red-600 text-xl">&times;</button>
                    </div>
                    <img id="tplModalImg"
                        class="w-full max-h-[80vh] object-contain rounded border">
                    <div class="text-right mt-4">
                        <button id="tplModalEdit"
                                class="px-4 py-1 bg-yellow text-white rounded">
                            Edit in Builder
                        </button>
                    </div>
                </div>`;
                document.body.appendChild(modalWrap);

                /* close modal on ✕ or backdrop */
                modalWrap.addEventListener('click', e => {
                    if (e.target.id === 'tplModalClose' || e.target === modalWrap)
                        modalWrap.classList.add('hidden');
                });
            }

            /* 4. Delegated card‑button handlers --------------------------------------- */
            list.addEventListener('click', e => {
                const card = e.target.closest('[data-tpl]');
                if (!card) return;                     // ignore clicks on default card
                const idx   = +card.dataset.tpl;
                const saved = JSON.parse(localStorage.getItem('templates') || '[]');

                /* ─ Delete ─ */
                if (e.target.closest('.btn-del')) {
                    if (!confirm('Delete this template?')) return;
                    saved.splice(idx, 1);
                    localStorage.setItem('templates', JSON.stringify(saved));
                    loadSaved();
                    return;
                }

                /* ─ View ─ */
                if (e.target.closest('.btn-view')) {
                    ensureModal();
                    const tpl = saved[idx];
                    modalWrap.querySelector('#tplModalTitle').textContent = tpl.name;
                    modalWrap.querySelector('#tplModalImg').src           = tpl.img;
                    modalWrap.querySelector('#tplModalEdit').dataset.idx  = idx;
                    modalWrap.classList.remove('hidden');
                    return;
                }

                /* ─ Edit (card button) ─ */
                if (e.target.closest('.btn-edit')) {
                    localStorage.setItem('editingTemplate', JSON.stringify(saved[idx]));
                    localStorage.setItem('editingIndex', idx);        // ← store index
                    window.location.href = "{{ route('syllabus.template') }}";
                }
            });

            /* 5. “Edit in Builder” inside the modal ----------------------------------- */
            document.addEventListener('click', e => {
                if (e.target.id === 'tplModalEdit') {
                    const idx = +e.target.dataset.idx;
                    const saved = JSON.parse(localStorage.getItem('templates') || '[]');
                    localStorage.setItem('editingTemplate', JSON.stringify(saved[idx]));
                    localStorage.setItem('editingIndex', idx);        // ← store index
                    window.location.href = "{{ route('syllabus.template') }}";
                }
            });

            /* 6. Countdown timer (left unchanged) ------------------------------------- */
            const syll    = <?php echo json_encode($syll ?? null); ?>;
            const dueDate = syll && syll.dl_syll ? new Date(syll.dl_syll) : null;
            if (dueDate) {
                const remain = document.getElementById('remaining-time');
                const tick   = () => {
                    const now  = new Date();
                    const diff = dueDate - now;
                    const d = Math.floor(diff / 86400000);
                    const h = Math.floor((diff % 86400000) / 3600000);
                    const m = Math.floor((diff % 3600000) / 60000);
                    const s = Math.floor((diff % 60000) / 1000);
                    if (remain) remain.textContent =
                        `Remaining: ${d}d ${h}h ${m}m ${s}s`;
                };
                tick(); setInterval(tick, 1000);
            }
        });
    </script>


    </body>

</html>
@endsection
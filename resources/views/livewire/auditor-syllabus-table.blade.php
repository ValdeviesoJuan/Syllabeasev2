<div class="text-left">
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <!--Search Input  -->
        <div class="relative w-[19%]">
            <input type="text" wire:model.live="search" id="table-search"
                class="border focus:outline-none focus:border-blue border-black w-full rounded p-1 pr-10"
                placeholder="Search...">
            <button type="button" wire:click="applyFilters"
                class="absolute inset-y-0 right-0 flex items-center px-2" tabindex="-1">
                <svg width="24px" class="rounded-lg p-[2px]" height="24px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z"
                        stroke="#2468d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <!-- Year Level -->
        <select wire:model="filters.course_year_level"
            class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[15%]"
            placeholder="Year level">
            <option value="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>

        <!-- Semester -->
        <select wire:model="filters.course_semester"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[15%]"
            placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>

        <!-- School Year -->
        <select wire:model="filters.bg_school_year"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[17%]"
            placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2023-2024">2023-2024</option>
            <option value="2024-2025">2024-2025</option>
            <option value="2025-2026">2025-2026</option>
            <option value="2026-2027">2026-2027</option>
            <option value="2027-2028">2027-2028</option>
            <option value="2028-2029">2028-2029</option>
            <option value="2029-2030">2029-2030</option>
        </select>

        <!-- Department -->
        <select wire:model="filters.department_id"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[16%]"
            placeholder="Department">
            <option value="">Department (All)</option>
            @foreach ($departments as $department)
                <option value="{{ $department->department_id }}">{{ $department->department_code }}</option>
            @endforeach
        </select>

        <!-- Apply Button -->
        <button wire:click="applyFilters"
            class="bg-blue5 hover:bg-blue focus:outline-none focus:border-blue cursor-pointer rounded text-white p-[4px] px-4">
            Apply Filters
        </button>
    </div>

    <!-- Table content -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="bg-blue5 rounded-tl-lg px-6 py-3">Course Code</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Course Title</th>
                <th scope="col" class="bg-blue5 px-6 py-3">School Year</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Semester</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Date Submitted At</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Date Approved At</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Version</th>
                <th scope="col" class="bg-blue5 px-6 py-3">Status</th>
                <th scope="col" class="bg-blue5 rounded-tr-lg px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($syllabi as $syllabus)
            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $syllabus->course_code }}
                </td>
                <td class="px-6 py-4">{{ $syllabus->course_title }}</td>
                <td class="px-6 py-4">{{ $syllabus->bg_school_year }}</td>
                <td class="px-6 py-4">{{ $syllabus->course_semester }}</td>
                <td class="px-6 py-4">{{ $syllabus->chair_submitted_at }}</td>
                <td class="px-6 py-4">{{ $syllabus->dean_approved_at }}</td>
                <td class="px-6 py-4">Version {{ $syllabus->version }}</td>
                <td class="px-6 py-4">
                    @php
                        $status = $syllabus->status;
                        $statusStyles = [
                            'Draft' => 'background-color: #D1D5DB; color: #4B5563; border-color: #9CA3AF;', // gray
                            'Pending Chair Review' => 'background-color: #FEF3C7; color: #D97706; border-color: #FCD34D;', // amber
                            'Returned by Chair' => 'background-color: #FECACA; color: #E11D48; border-color: #F87171;', // rose
                            'Requires Revision (Chair)' => 'background-color: #FEE2E2; color: #EF4444; border-color: #FCA5A5;', // red
                            'Revised for Chair' => 'background-color: #DBEAFE; color: #3B82F6; border-color: #93C5FD;', // blue
                            'Approved by Chair' => 'background-color: #D1FAE5; color: #059669; border-color: #6EE7B7;', // green
                            'Returned by Dean' => 'background-color: #FDA4AF; color: #BE123C; border-color: #FB7185;', // darker rose
                            'Requires Revision (Dean)' => 'background-color: #FCE7F3; color: #EC4899; border-color: #F9A8D4;', // pink
                            'Revised for Dean' => 'background-color: #BFDBFE; color: #2563EB; border-color: #93C5FD;', // blue
                            'Approved by Dean' => 'background-color: #A7F3D0; color: #047857; border-color: #6EE7B7;', // emerald
                        ];
                        $style = $statusStyles[$status] ?? 'background-color: #F3F4F6; color: #6B7280; border-color: #D1D5DB;';
                    @endphp

                    <div class="w-full text-center px-1 py-1 border-2 rounded-lg" style="{{ $style }}">
                        {{ $syllabus->status }}
                    </div>
                </td>
                <td class="px-6 py-4 flex">
                    <form action="{{ route('auditor.viewSyllabus', $syllabus->syll_id) }}" method="GET">
                        @csrf
                        <div class="p-4">
                            <button class="hover:text-yellow hover:underline" type="submit">View</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $syllabi->links() }}
</div>

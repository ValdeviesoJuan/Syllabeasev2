<div class="text-left">
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <!-- Search Input with icon inside -->
        <div class="relative w-[12%]">
            <input
                wire:model.live="search"
                wire:keydown.enter="applyFilters"
                type="text"
                class="border focus:outline-none focus:border-blue border-black w-full rounded p-1 pr-10"
                placeholder="Search..."
            >
            <button
                type="button"
                wire:click="applyFilters"
                class="absolute inset-y-0 right-0 flex items-center px-2"
                tabindex="-1"
            >
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
            class="border cursor-pointer focus:outline-none focus:border-blue rounded p-1 w-[14%]">
            <option value="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>

        <!-- Semester -->
        <select wire:model="filters.course_semester"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[14%]">
            <option value="">Semester(All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>

        <!-- School Year -->
        <select wire:model="filters.bg_school_year"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[15%]">
            <option value="">School Year(All)</option>
            <option value="2019-2020">2019-2020</option>
            <option value="2020-2021">2020-2021</option>
            <option value="2021-2022">2021-2022</option>
            <option value="2023-2024">2023-2024</option>
        </select>

        <!-- Department -->
        <select wire:model="filters.department_code"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[16%]">
            <option value="">Departments(All)</option>
            @foreach($departments as $dep)
                <option value="{{ $dep->department_code }}">{{ $dep->department_code }}</option>
            @endforeach
        </select>

        <!-- Status -->
        <select wire:model="filters.status"
            class="border focus:outline-none focus:border-blue cursor-pointer rounded p-1 w-[9%]">
            <option value="">Status</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
            <option value="Approved by Dean">Approved by Dean</option>
            <option value="Returned by Dean">Returned by Dean</option>
        </select>

        <!-- Apply Filters Button -->
        <button wire:click="applyFilters"
            class="bg-blue5 hover:bg-blue focus:outline-none focus:border-blue cursor-pointer rounded text-white p-[4px] px-4">
            Apply Filters
        </button>
    </div>

    
<!-- Table -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-lg mb-8">
        <thead class="rounded text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-blue5 text-white text-sm pb-2">
                <th class="pl-2 mb-4 rounded-tl-lg">Course Title</th>
                <th class="">Course Code</th>
                <th class="">School Year</th>
                <th class="">Semester</th>
                <th class="">Submitted At</th>
                <th class="">Approved At</th>
                <th class="">Version</th>
                <th class="">Status</th>
                <th class="px-6 py-3 rounded-tr-lg">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#e5e7eb]">
            @foreach ($syllabi as $syllabus)
            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-[#e9edf7]' }} bg-white border- dark:bg-gray-800 dark:border-gray-700 hover:bg-gray4 dark:hover:bg-gray-600">
                <td class="font-semibold pl-2">{{ $syllabus->course_title }}</td>
                <td>{{ $syllabus->course_code }}</td>
                <td>{{ $syllabus->bg_school_year }}</td>
                <td>{{ $syllabus->course_semester }}</td>
                <td>{{$syllabus->chair_submitted_at}}</td>
                <td>{{$syllabus->dean_approved_at}}</td>
                <td>Version {{$syllabus->version}}</td>
                <td class="mr-[200px]">
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
                <td>
                    <div>
                        <form class="" action="{{ route('dean.viewSyllabus', $syllabus->syll_id) }}" method="GET">
                            @csrf
                            <div class="p-4">
                                <button class="bg-blue5 w-[80%] hover:bg-blue3 py-1 rounded-lg text-lg text-white cursor-pointer font-semibold shadow-lg" type="submit">View</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $syllabi->links() }}
</div>
<div class=" text-left">
    <div class="">
        <input wire:model.live="search" type="text" class="border focus:outline-none focus:border-blue mb-6 border-black w-[17%] rounded-lg p-1" placeholder="Search...">
        <button wire:click="applyFilters"><svg width="34px" class="bg-blue5 rounded-lg p-[3px] -mb-3" height="34px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <select wire:model="filters.course_year_level" class="border cursor-pointer focus:outline-none focus:border-blue rounded-lg p-1 w-[10%] ml-6" placeholder="Year level">
            <option value="" class="">Year level (All)</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
            <option value="5th Year">5th Year</option>
        </select>

        <select wire:model="filters.course_semester" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="Semester">
            <option value="">Semester (All)</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="Mid Year">Mid Year</option>
        </select>

        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="School Year">
            <option value="">School Year (All)</option>
            <option value="2019-2020">2019-2020</option>
            <option value="2020-2021">2020-2021</option>
            <option value="2021-2022">2021-2022</option>
            <option value="2023-2024">2023-2024</option>
        </select>

        <select wire:model="filters.department_id" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="Department">
            <option value="">Departments (All)</option>
            @foreach($departments as $department)
            <option value="{{$department->department_id}}">{{$department->department_code}}</option>
            @endforeach
        </select>
        
        <select wire:model="filters.college_id" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="College">
            <option value="">Colleges (All)</option>
            @foreach($colleges as $college)
            <option value="{{$college->college_id}}">{{$college->college_code}}</option>
            @endforeach
        </select>

        <select wire:model="filters.status" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="Status">
            <option value="">Status(All)</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
            <option value="Approved by Dean">Approved by Dean</option>
            <option value="Returned by Dean">Returned by Dean</option>
        </select>

        <button wire:click="applyFilters" class="bg-blue5 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[4px] ml-2 -mb-3">Apply Filters</button>
    </div>
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
                    <button class="
                        {{ $syllabus->status === 'Pending' ? 'w-[80%] bg-amber-100 text-amber-500 border-2 border-amber-300 rounded-lg' : '' }}
                        {{ $syllabus->status === 'Approved by Chair' ? 'w-[80%]  bg-emerald-300 text-emerald-600 border-2 border-emerald-500  rounded-lg' : '' }}
                        {{ $syllabus->status === 'Returned by Chair' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}
                        {{ $syllabus->status === 'Approved by Dean' ? 'w-[80%]  bg-emerald-200 text-emerald-600 border-2 border-emerald-400 rounded-lg' : '' }}
                        {{ $syllabus->status === 'Returned by Dean' ? 'w-[80%] bg-rose-300 text-rose-600 border-2 border-rose-500 rounded-lg' : ' ' }}">
                        {{$syllabus->status}}
                    </button>
                </td>
                <td>
                    <div>
                        <form class="" action="{{ route('admin.viewSyllabus', $syllabus->syll_id) }}" method="GET">
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
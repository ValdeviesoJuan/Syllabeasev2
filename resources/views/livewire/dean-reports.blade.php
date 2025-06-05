<style>
    table,
    tr,
    th,
    td{
        border: 1px solid black;
    }
</style>

<div>
    <div class="flex justify-center">
        <div id="icon" class="w-[280px] m-5 flex items-center bg-white h-fit rounded-lg justify-center p-1 shadow-2xl hover:scale-110 transition ease-in-out">
            <div class="m-5 bg-blue2 w-fit h-content rounded-full">
                <div class="p-4">
                    <svg fill="#2262c6" width="40px" height="40px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                        <g id="Memo_Pad" data-name="Memo Pad">
                            <g>
                                <path d="M17.44,2.065H6.56a2.507,2.507,0,0,0-2.5,2.5v14.87a2.507,2.507,0,0,0,2.5,2.5H17.44a2.5,2.5,0,0,0,2.5-2.5V4.565A2.5,2.5,0,0,0,17.44,2.065Zm1.5,17.37a1.5,1.5,0,0,1-1.5,1.5H6.56a1.5,1.5,0,0,1-1.5-1.5V6.505H18.94Z" />
                                <g>
                                    <path d="M7.549,9.506h0a.5.5,0,0,1,0-1h8.909a.5.5,0,0,1,0,1Z" />
                                    <path d="M7.549,12.506h0a.5.5,0,0,1,0-1h6.5a.5.5,0,0,1,0,1Z" />
                                    <path d="M7.566,18.374h0a.5.5,0,1,1,0-1h3.251a.5.5,0,0,1,0,1Z" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col mr-6 pt-5">
                <div class="text-3xl font-semibold text-blue">
                    {{$syllabiCount}}/{{$distinctBayanihanTeams}}
                </div>
                <div class=" ml-0 text-blue3">
                    Submitted Syllabus
                </div>
            </div>
        </div>
    </div>

    <div class="ml-[5%]">
        <h1 class="text-2xl font-semibold py-4">Syllabus</h1>
        <input wire:model.live="search" type="text" class="border focus:outline-none focus:border-blue mb-6 border-black w-[17%] rounded-lg p-1" placeholder="Search...">
        <button wire:click="applyFilters"><svg width="34px" class="bg-blue5 rounded-lg p-[3px] -mb-3" height="34px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg></button>
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

        <select wire:model="filters.bg_school_year" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="School Year">
            <option value="">Departments (All)</option>
            @foreach($departments as $dep)
            <option value="{{$dep->department_code}}">{{$dep->department_code}}</option>
            @endforeach
        </select>

        <select wire:model="filters.status" class="border focus:outline-none focus:border-blue cursor-pointer rounded-lg p-1 w-[10%] ml-6" placeholder="Semester">
            <option value="">Status(All)</option>
            <option value="Pending">Pending</option>
            <option value="Approved by Chair">Approved by Chair</option>
            <option value="Returned by Chair">Returned by Chair</option>
            <option value="Approved by Dean">Approved by Dean</option>
            <option value="Returned by Dean">Returned by Dean</option>
        </select>
        <button wire:click="applyFilters" class="bg-blue5 focus:outline-none focus:border-blue cursor-pointer rounded-lg text-white p-[4px] ml-2 px-3 -mb-3">Apply Filters</button>
    </div>
    <table class="border-collapse m-auto w-[90%] border mb-4">
        <thead>
            <tr class="bg-blue5 text-white text-left text-lg pb-2 border border-black">
                <th class="pl-2 mb-4">Bayanihan Team</th>
                <th class="pl-2">School Year</th>
                <th class="pl-2">Semester</th>
                <th class="pl-2">Draft</th>
                <th class="pl-2">Chair</th>
                <th class="pl-2">Dean</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#e5e7eb]">
            @foreach ($syllabi as $syllabus)
            <tr class="p-[100px] bg-white">
                <td class="font-semibold pl-2">{{ $syllabus->course_title }}-{{ $syllabus->course_code }}</td>
                <td class="pl-2">{{ $syllabus->bg_school_year }}</td>
                <td class="pl-2">{{$syllabus->course_semester}}</td>
                <td class="pl-2">Version {{ $syllabus->version }}</td>
                <td class="pl-2">@if($syllabus->chair_submitted_at != null)
                    Approved
                    @endif
                </td>
                <td class="pl-2">@if($syllabus->dean_approved_at != null)
                    Approved
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
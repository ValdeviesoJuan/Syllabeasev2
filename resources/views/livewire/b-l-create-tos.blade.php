<div class="ml-[4%]">
    <div class="w-max px-8 mb-5 mt-2 pt-2 hover:scale-105 transition ease-in-out bg-blue py-2 text-white rounded hover:bg-blue">
        <button wire:click="openComments" class="flex m-auto text-ml">
            <svg class="" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
            </svg>
            <div class="flex m-auto ml-2">
                Create TOS
            </div>
        </button>
    </div>
    @if($isOpen)
    <div class=" flex flex-col w-full h-auto">
        <div class="z-10 absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center">
            <div class="shadow-lg bg-white fixed bg-opacity-90 w-[415px] min-h-[400px] rounded shadow-lg font-sans bg-gradient-to-r from-[#FFF] to-[#dbeafe]">
                <h1 class="flex w-10/12 h-auto py-3 ml-6 justify-center text-center items-center text-2xl font-bold">Choose Syllabus</h1>

                <div class="absolute ml-[90%] -mt-[9%]">
                    <button wire:click="closeComments">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#454545" />
                        </svg>
                    </button>
                </div>
                <div>
                    <div class="grid grid-cols-1 gap-y-3 mt-2">
                        @foreach($syllabi as $syllabus)
                        <a href="{{ route('bayanihanleader.createTos', $syllabus->syll_id) }}" class="p-3 flex w-[390px] ml-3 h-auto py-4 px-2 shadow-lg justify-center items-center bg-[#f9fafb] hover:bg-blue2 rounded text-center text-gray-500 hover:bg-[#f3f4f6]">{{$syllabus->course_code . ' ' . $syllabus->bg_school_year . ' ' . $syllabus->course_semester}}</a>
                        @endforeach
                        <div>
                        </div>
                    </div>

                </div>
            </div>

            @endif

        </div>
<div class="">
    <button wire:click="openComments" class="relative m-2">
        <div class="tooltip {{ $unresolvedComments == 0 ? 'opacity-50' : '' }} hover:opacity-100">
            <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#2468d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span class="tooltiptext font-sans text-xs">View Comments</span>
        </div>
        @if($unresolvedComments > 0)
        <div class="absolute bottom-3 left-3 flex items-center bg-red justify-center w-4 h-4 rounded-full bg-blue-500 text-white pb-1">
            {{ $unresolvedComments }}
        </div>
        @endif
    </button>
    @if($isOpen)
    <div class="z-50 absolute right-0 top-0 bg-white bg-opacity-90 w-[320px] min-h-[250px]  rounded shadow-lg font-sans">
        <div class="bg-white py-2 flex justify-between shadow">
            <div class="px-2 text-base text-gray2">
                Comments
            </div>
            <div class="px-2">
                <button wire:click="closeComments">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#454545" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="h-96 overflow-y-auto mb-[55px]">
            @foreach($co_comments as $co_comment)
            @php
            $bgColor = ($co_comment->user_id == Auth::user()->id) ? 'bg-yellow' : 'bg-blue2';
            @endphp
            <div class="bg-white m-2 rounded py-2 shadow border border-gray3">
                <div class=" rounded flex justify-between">
                    <div class="flex justify-row">
                        <div class="w-10 h-10 p-1 border border-gray3 {{$bgColor}} flex justify-center items-center m-1">
                            <div class="">{{ strtoupper(substr($co_comment->firstname, 0, 1)) . strtoupper(substr($co_comment->lastname, 0, 1)) }}</div>
                        </div>
                        <div class="ml-2">
                            <div>
                                {{$co_comment->firstname . ' ' . $co_comment->lastname}}
                            </div>
                            <div class="text-gray3">
                                <p class="text-xs">{{ $co_comment->co_comment_created_at}}</p>
                            </div>
                            <div>
                                {{$co_comment->co_comment_text}}
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <form wire:submit.prevent="resolveComment('{{ $co_comment->co_comment_id }}')" method="POST">
                            <input type="hidden" name="co_comment_id" value="">
                            <div class="tooltip hover:bg-green2 h-7 w-7 rounded-full flex justify-center items-center {{ $co_comment->co_comment_resolved_at ? 'bg-green2' : 'bg-white' }}">
                                <button class="pt-0.5" type="submit">
                                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#454545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <span class="tooltiptext">
                                    @if($co_comment->co_comment_resolved_at)
                                    Mark as unresolved
                                    @else
                                    Mark as resolved
                                    @endif
                                </span>
                            </div>
                        </form>
                        <div class="">
                            <button>
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="6" r="2" transform="rotate(90 12 6)" fill="#454545" />
                                    <circle cx="12" cy="12" r="2" transform="rotate(90 12 12)" fill="#454545" />
                                    <path d="M12 20C10.8954 20 10 19.1046 10 18C10 16.8954 10.8954 16 12 16C13.1046 16 14 16.8954 14 18C14 19.1046 13.1046 20 12 20Z" fill="#454545" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="absolute border border-gray3 bottom-0 w-full rounded">
            <form wire:submit.prevent="addComment">
                <div class="rounded flex justify-between bg-white">
                    <input type="hidden" wire:model="syll_co_id">
                    <input required wire:model="co_comment_text" placeholder="Type your comment..." class="m-2 w-10/12 rounded h-[40px] p-2 placeholder:text-gray-400 focus:ring focus:outline-none">
                    <button type="submit">
                        <div class="mr-3 bg-white flex items-center justify-center">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z" stroke="#2468d2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
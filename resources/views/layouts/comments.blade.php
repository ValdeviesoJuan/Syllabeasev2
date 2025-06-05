<div id="commentDiv" class=" right-0 top-[50px]">
    <div id="dropdownComment" class="h-screen  flex flex-col border-l border-gray3 px-2 transition duration-300 absolute top-full right-0 w-[350px] bg-white bg-opacity-90 shadow-lg rounded">
        <div class="bg-white w-[340px] font-semibold text-lg pb-3 pt-2 pl-2 shadow-md">
            <div class="flex justify-between">
                <div>Comments</div>
                <div class="flex space-x-2 mr-1">
                    <button class="hover:bg-blue2 rounded-full p-1" onclick="refreshPage()">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7" stroke="#8a8a8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button id="closeComment" class="hover:bg-blue2 rounded-full p-1">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#8a8a8a" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="commentContainer" class="overflow-y-scroll flex flex-col items-center mb-[100px] mt-[5px]">
            @foreach($syllabusComments as $syllabusComment)
            <div class="bg-white w-11/12 h-screen">
                <div class="flex flex-row rounded p-1 border border-gray3 mb-2">
                    <div class="border-2 border-gray bg-green rounded-full w-[30px] h-[30px] flex items-center justify-center mr-3 mt-2">
                        <div class="text-white p-10 text-widest tracking-widest">
                            {{ Str::upper(substr($syllabusComment->firstname, 0, 1)) . Str::upper(substr($syllabusComment->lastname, 0, 1)) }}
                        </div>
                    </div>
                    <div class="">
                        <div class="font-semibold">
                            {{ $syllabusComment->firstname . ' ' . $syllabusComment->lastname }}
                        </div>
                        <div class="text-xs text-gray">
                            @if(\Carbon\Carbon::parse($syllabusComment->syll_created_at)->isToday())
                            {{ \Carbon\Carbon::parse($syllabusComment->syll_created_at)->format('g:i A') }} Today
                            @else
                            {{ \Carbon\Carbon::parse($syllabusComment->syll_created_at)->format('g:i A') }} {{ \Carbon\Carbon::parse($syllabusComment->syll_created_at)->toDateString() }}
                            @endif
                        </div>
                        <div class="pb-2">
                            {{ $syllabusComment->syll_comment_text }}
                        </div>
                    </div>
                    <div class="text-gray pt-2 ml-auto">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5 4C14.5 5.38071 13.3807 6.5 12 6.5C10.6193 6.5 9.5 5.38071 9.5 4C9.5 2.61929 10.6193 1.5 12 1.5C13.3807 1.5 14.5 2.61929 14.5 4Z" fill="#616161" />
                            <path d="M14.5 12C14.5 13.3807 13.3807 14.5 12 14.5C10.6193 14.5 9.5 13.3807 9.5 12C9.5 10.6193 10.6193 9.5 12 9.5C13.3807 9.5 14.5 10.6193 14.5 12Z" fill="#616161" />
                            <path d="M12 22.5C13.3807 22.5 14.5 21.3807 14.5 20C14.5 18.6193 13.3807 17.5 12 17.5C10.6193 17.5 9.5 18.6193 9.5 20C9.5 21.3807 10.6193 22.5 12 22.5Z" fill="#616161" />
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
            <form id="commentForm" class="bg-blue fixed bottom-0 bg-white mt-auto py-2 w-[320px]">
                @csrf
                <div id="commentTextArea" class="">
                    <div class="flex items-center bg-white">
                        <textarea rows="1" id="syll_comment_text" class="bg-white flex resize-none rounded-3xl w-[300px] h-max border border-gray3 w-full  mr-3 focus:outline-none focus:border-blue p-2" name="syll_comment_text" type="text" placeholder="Write a comment"></textarea>
                        <button class="ml-22" type="submit">
                            <svg width="25px" height="25x" viewBox="0 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="ic_fluent_send_28_filled" fill="#2468d2" fill-rule="nonzero">
                                        <path d="M3.78963301,2.77233335 L24.8609339,12.8499121 C25.4837277,13.1477699 25.7471402,13.8941055 25.4492823,14.5168992 C25.326107,14.7744476 25.1184823,14.9820723 24.8609339,15.1052476 L3.78963301,25.1828263 C3.16683929,25.4806842 2.42050372,25.2172716 2.12264586,24.5944779 C1.99321184,24.3238431 1.96542524,24.015685 2.04435886,23.7262618 L4.15190935,15.9983421 C4.204709,15.8047375 4.36814355,15.6614577 4.56699265,15.634447 L14.7775879,14.2474874 C14.8655834,14.2349166 14.938494,14.177091 14.9721837,14.0981464 L14.9897199,14.0353553 C15.0064567,13.9181981 14.9390703,13.8084248 14.8334007,13.7671556 L14.7775879,13.7525126 L4.57894108,12.3655968 C4.38011873,12.3385589 4.21671819,12.1952832 4.16392965,12.0016992 L2.04435886,4.22889788 C1.8627142,3.56286745 2.25538645,2.87569101 2.92141688,2.69404635 C3.21084015,2.61511273 3.51899823,2.64289932 3.78963301,2.77233335 Z" id="🎨-Color">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#commentForm').submit(function(e) {
            e.preventDefault();
            var syll_comment_text = $('#syll_comment_text').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("comment.storeComment", $syll_id) }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'syll_comment_text': syll_comment_text
                },
                success: function(data) {
                    console.log(data);
                    $('#syll_comment_text').val('');
                    // $('#nav').load(location.href + ' #nav', function() {});
                    $('#commentContainer').animate({
                        scrollTop: $('#commentContainer')[0].scrollHeight
                    }, "slow");

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
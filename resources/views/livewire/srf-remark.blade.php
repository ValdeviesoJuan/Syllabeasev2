<div class="absolute -top-2 -right-2 z-100">
    @if($this->shouldShowIcon)
        <div class="relative group">
            {{-- Font Awesome Icon Button --}}
            <button wire:click="$toggle('showRemark')" 
                    class="text-[#d3494e] hover:text-[#b91c1c] rounded-full"
                    title="View remark">
                <i class="fa-solid fa-message text-xl"></i>
            </button>

            {{-- Feedback tooltip bubble --}}
            @if($showRemark)
                <div class="absolute top-full right-0 mt-2 w-72 max-w-xs bg-white font-[Verdana] text-gray-800 p-4 rounded-lg shadow-xl z-50">
                    
                    {{-- Arrow --}}
                    <div class="absolute -top-2 right-4 w-0 h-0 border-l-[8px] border-r-[8px] border-b-[8px] 
                                border-l-transparent border-r-transparent border-b-white"></div>

                    {{-- Feedback label --}}
                    <p class="text-left font-semibold text-red-600 mb-3 text-[18px]">Remarks:</p>

                    {{-- Feedback content --}}
                    <p class="text-center text-gray leading-snug text-[14px] mb-4">
                        {{ $remark ?? 'No remarks provided.' }}
                    </p>

                    {{-- Button container --}}
                    <div class="flex justify-end">
                        <button wire:click="$toggle('showRemark')"  
                                class="rounded-md bg-black text-white hover:bg-gray px-4 py-1 text-[14px] transition"
                        >
                            OKAY
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
<div class="absolute -top-2 -right-2 z-20">
    @if($this->shouldShowIcon)
        <div class="relative group">
            {{-- Font Awesome Icon Button --}}
            <button wire:click="$toggle('showRemark')" 
                    class="text-[#ef4444] hover:text-[#b91c1c] rounded-full"
                    title="View remark">
                <i class="fa-solid fa-comment-dots text-xl"></i>
            </button>

            {{-- Tooltip bubble --}}
            @if($showRemark)
                <div class="absolute top-full right-0 mt-1 w-64 bg-[#1f2937] text-[#ffffff] text-sm p-3 rounded shadow-lg z-50">
                    {{ $remark ?? 'No remarks provided.' }}
                </div>
            @endif
        </div>
    @endif
</div>
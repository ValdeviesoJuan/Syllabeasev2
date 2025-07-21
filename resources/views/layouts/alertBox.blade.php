<div id="{{ $id }}" class="fixed {{ $top }} right-6 z-50 bg-white border-t-4 border-{{ $color }} rounded-b {{ $textColor }} px-8 py-8 shadow-md min-w-[320px] flex items-start" role="alert">
    <div class="py-1">
        <svg class="h-6 w-6 {{ $iconColor }} mr-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="font-bold text-lg">{{ $title }}</p>
        <p class="text-base">{{ $message }}</p>
    </div>
    <button onclick="document.getElementById('{{ $id }}').style.display='none'" class="ml-4 text-black hover:{{ $iconColor }} font-bold text-lg">&times;</button>
</div>
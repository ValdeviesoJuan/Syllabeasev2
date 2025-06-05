@section('popup')
<div id="popup" class="fixed left-[324px] top-6 opacity-90" style="display: none;">
    <div class="fixed w-4 h-4 transform -translate-x-1/2 bg-white rotate-45 top-8"></div>
    <div class="absolute bg-white rounded-lg shadow-lg p-4 h-36 w-48 shadow-xl">
        <p class="font-semibold text-yellow">Important Note:</p>
        <p class="mt-2">Click here to switch role.</p>
        <button id="popup-button" class="absolute bottom-0 right-0 mb-3 mr-3 text-blue">Got it.</button>
    </div>
</div>
@endsection



<!-- <div class="fixed bottom-0 left-0 w-2/6 shadow-2xl pop-up bg-opacity-50 m-3">
    @if (session('success'))
    <div class="bg-green2 border border-green text-green px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}.</span>
    </div>
    @elseif (session('error'))
    <div role="alert">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Error
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <p>{{ session('error') }}.</p>
        </div>
    </div>
    @endif
</div>
</div> -->
<div class="pop-up" style="z-index: 9999; position: fixed; bottom: 0; left: 0; width: 40%; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); background-color: rgba(0, 0, 0, 0.5); margin: 1.125rem;">
    @if (session('success'))
        <div style="background-color: rgba(180, 233, 197, 0.90); border: 1px solid #31a858; color: #00C853; padding: 1rem; border-radius: 0.375rem; position: relative;" role="alert">
            <strong style="font-weight: bold;">Success!</strong>
            <span style="display: inline-block;">{{ session('success') }}.</span>
        </div>
    @elseif (session('error'))
        <div role="alert">
            <div style="background-color: #FF1744; color: #fff; font-weight: bold; border-radius: 0.375rem 0.375rem 0 0; padding: 0.5rem 1rem;">
                Error
            </div>
            <div style="border: 1px solid #FF1744; border-top: 0; border-radius: 0 0 0.375rem 0.375rem; background-color: #FF8A80; padding: 1rem; color: #FF1744;">
                <p>{{ session('error') }}.</p>
            </div>
        </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.pop-up').fadeIn(400); 
        setTimeout(function() {
            $('.pop-up').fadeOut(400); 
        }, 2000);
    });
</script>

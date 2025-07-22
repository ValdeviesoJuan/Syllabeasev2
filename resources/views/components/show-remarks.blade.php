@php
    $hasRemarks = isset($srf) && $srf['srf_yes_no'] === 'no';
    $prevRemarks = isset($previous) && $previous->srf_yes_no === 'no';
@endphp

@if($hasRemarks && isset($srf['remarks']))
    <div x-data="{ showRemarks: false }" class="mt-2">
        <button 
            @click="showRemarks = !showRemarks"
            class="text-sm text-red-600 underline focus:outline-none"
        >
            Show Remarks
        </button>
        <div 
            class="mt-2 text-sm text-red-700 bg-red-50 p-2 rounded"
            x-show="showRemarks"
            x-transition
        >
            <strong>Remarks:</strong> {{ $srf['remarks'] }}
        </div>
    </div>
@endif
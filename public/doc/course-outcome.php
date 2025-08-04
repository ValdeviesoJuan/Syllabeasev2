<table class="m-10 mx-auto border-2 border-solid w-11/12">
    <tr class="border-2 border-solid ">
        <th>
            Course Outcomes (CO)
        </th>
        @foreach($programOutcomes as $po)
        <th class="border-2 border-solid">
            {{$loop->iteration}}
        </th>
        @endforeach
    </tr>

    @foreach($courseOutcomes as $co)
    <tr id="co_row" class="border-2 border-solid hover:bg-blue2">
        <td class="w-64 text-left font-medium px-2"><span class="font-bold">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
        @foreach($programOutcomes as $po)
        <td class="border-2 border-solid font-medium text-center py-1 ">
            @foreach ($copos as $copo)
            @if($copo->syll_po_id == $po->po_id)
            @if($copo->syll_co_id == $co->syll_co_id)
            {{$copo->syll_co_po_code}}
            @endif
            @endif
            @endforeach
        </td>
        @endforeach
        <td class="relative w-4">
            @livewire('bl-comment-modal', ['syll_co_id' => $co->syll_co_id])
        </td>
    </tr>
    @endforeach
</table>
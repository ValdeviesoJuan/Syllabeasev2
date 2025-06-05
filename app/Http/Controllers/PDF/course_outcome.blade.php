<table class="">
    <tr class="">
        <th>
            Course Outcomes (CO)
        </th>
        @foreach($programOutcomes as $po)
        <th class="">
            {{$loop->iteration}}
        </th>
        @endforeach
    </tr>

    @foreach($courseOutcomes as $co)
    <tr class="">
        <td class=""><span class="">{{$co->syll_co_code}} : </span>{{$co->syll_co_description}}</td>
        @foreach($programOutcomes as $po)
        <td class="">
            @foreach ($copos as $copo)
            @if($copo->syll_po_id == $po->po_id)
            @if($copo->syll_co_id == $co->syll_co_id)
            {{$copo->syll_co_po_code}}
            @endif
            @endif
            @endforeach
        </td>
        @endforeach
    </tr>
    @endforeach
</table>
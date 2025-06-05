<div>
    <button class="bg-blue text-white px-4 py-2 rounded-lg shadow-lg hover:scale-105 w-max transition ease-in-out" id="roundButton">Round Values</button>

    <table id="tosTable" class="mt-4 border-2 border-solid w-full font-serif text-sm bg-white">
        <tr>
            <th rowspan="3">
                Topics
            </th>
            <th rowspan="3">
                No. of <br> Hours <br> Taught
            </th>
            <th class="px-2" rowspan="3">
                %
            </th>
            <th rowspan="3">
                No. of <br>Test <br>Items
            </th>
            <th colspan="5" class="py-2">
                Cognitive Level
            </th>
        </tr>
        <tr>
            <th>
                Knowledge
            </th>
            <th>
                Comprehension
            </th>
            <th>
                Application/ <br>Analysis
            </th>
            <th>
                Synthesis/ <br> Evaluation
            </th>
        </tr>
        <tr>
            <th class="py-2 px-1">{{$tos->col_1_per}}%</th>
            <th>{{$tos->col_2_per}}%</th>
            <th>{{$tos->col_3_per}}%</th>
            <th>{{$tos->col_4_per}}%</th>
        </tr>

        {{-- tangtanga lang ni if dili mo work sa inyo kay dili ga work ang taas :)) --}}
        @if(count($tos_rows) > 0)

        <form method="post" action="{{ route('bayanihanleader.updateTosRow', $tos_id)}}">
            @csrf
            @foreach($tos_rows as $index => $tos_row)
            <tr>
                <td class="p-2">
                    {{ $tos_row->tos_r_topic }}
                </td>
                <td class="text-center">
                    {{ $tos_row->tos_r_no_hours }}
                </td>
                <td class="text-center w-[50px]">
                    {{ $tos_row->tos_r_percent }}
                </td>
                <td id="tos_r_no_items" class="text-center">
                    {{ $tos_row->tos_r_no_items }}
                </td>
                <input type="hidden" name="tos_r_id[]" value="{{ $tos_row->tos_r_id }}">
                <td class="cell text-center">
                    <input class="text-center" step="any"  type="number" id="col1"  name="tos_r_col_1[]" value="{{ $tos_row->tos_r_col_1 }}" />
                </td>
                <td class="cell text-center">
                    <input class="text-center" step="any" type="number" id="col2" name="tos_r_col_2[]" value="{{ $tos_row->tos_r_col_2 }}" />
                </td>
                <td class="cell text-center">
                    <input class="text-center" step="any" type="number" id="col3" name="tos_r_col_3[]" value="{{ $tos_row->tos_r_col_3 }}" />
                </td>
                <td class="cell text-center">
                    <input class="text-center" step="any" type="number" id="col4" name="tos_r_col_4[]" value="{{ $tos_row->tos_r_col_4 }}" />
                </td>
                <td id="TotalRow" class="text-center font-bold p-2"></td>
            </tr>
            @endforeach
            <button class="bg-blue text-white px-4 py-2 rounded-lg shadow-lg hover:scale-105 w-[12%] transition ease-in-out" type="submit">Update</button>
        </form>
        @else
        <tr>
            <td colspan="8">No data available</td>
        </tr>
        @endif
        <tr>
            <td class="text-right font-bold p-2">Actual: </td>
            <td class="text-center font-bold p-2"></td>
            <td class="text-center font-bold p-2"></td>
            <td class="text-center font-bold p-2"></td>
            <td id="totalCol1" class="text-center font-bold p-2"></td>
            <td id="totalCol2" class="text-center font-bold p-2"></td>
            <td id="totalCol3" class="text-center font-bold p-2"></td>
            <td id="totalCol4" class="text-center font-bold p-2"></td>
        </tr>
        <tr>
            <td class="text-right font-bold p-2">Expected: </td>
            <td class="text-center font-bold p-2"></td>
            <td class="text-center font-bold p-2"></td>
            <td class="text-center font-bold p-2"></td>
            <td id="expCol1" class="text-center font-bold p-2">{{$tos->col_1_exp}}</td>
            <td id="expCol2" class="text-center font-bold p-2">{{$tos->col_2_exp}}</td>
            <td id="expCol3" class="text-center font-bold p-2">{{$tos->col_3_exp}}</td>
            <td id="expCol4" class="text-center font-bold p-2">{{$tos->col_4_exp}}</td>
        </tr>
    </table>

</div>
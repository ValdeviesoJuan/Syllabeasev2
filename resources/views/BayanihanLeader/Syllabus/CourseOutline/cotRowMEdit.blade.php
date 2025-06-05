@extends('layouts.blNav')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>Create Drag and Droppable Datatables Using jQuery UI Sortable in Laravel 10 - itcodestuff.com</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
  <style>
    body {
    background-image: url("{{ asset('assets/Wave.png') }}");
    background-repeat: no-repeat;
    background-position: top;
    background-attachment: fixed;
    background-size: contain;
    }
  </style>
<body>
  <div class="m-auto p-8 bg-slate-100 mt-[150px] p-2 shadow-lg bg-gradient-to-r from-[#FFF] to-[#dbeafe] rounded-lg w-11/12">
    {{-- <div class="max-w-md  w-[560px] p-6 px-8 rounded-lg shadow-lg"> --}}
        <img class="edit_user_img text-center w-[500px] m-auto mb-12" src="/assets/Re-Order Midterm Course Outline.png" alt="SyllabEase Logo">
      <table id="table" class="table w-full p-4 table-bordered">
        <thead>
          <tr>
            <th width="30px">#</th>
            <th>Alloted Time</th>
            <th>Intended Learning Outcome</th>
            <th>Topics</th>
            <th>Suggested Readings</th>
            <th>Teaching Learning Activities</th>
            <th>Assesment Task/Tools</th>
            <th>Grading Criteria</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody id="tablecontents">
          @foreach($courseOutlinesM as $cot)
          <tr class="row1" data-id="{{ $cot->syll_co_out_id }}">
            <td class="pl-3"><i class="fa fa-sort"></i></td>
            <td>{!! nl2br(e($cot->syll_allotted_hour)) !!} hours
              <div>
                {!! nl2br(e($cot->syll_allotted_time)) !!} 
              </div>
            </td>
            <td>{!! nl2br(e($cot->syll_intended_learning)) !!}</td> 
            <td>{!! nl2br(e($cot->syll_topics)) !!}</td>
            <td>{!! nl2br(e($cot->syll_suggested_readings)) !!}</td>
            <td>{!! nl2br(e($cot->syll_learning_act)) !!}</td>
            <td>{!! nl2br(e($cot->syll_asses_tools)) !!}</td>
            <td>{!! nl2br(e($cot->syll_grading_criteria)) !!}</td>
            <td>{!! nl2br(e($cot->syll_remarks)) !!}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <hr>
      <h5>Drag and Drop the table rows and <button class="text-blue" onclick="window.location.reload()">REFRESH</button> the page to check the updated order.</h5>
    </div>
  </div>
  <div class="mr-3 justify-end flex ">
    <form action="{{ route('bayanihanleader.viewSyllabus', $syll_id) }}" method="GET">
      @csrf
      <button type="submit" onclick="window.location.reload()" class="shadow-lg rounded-lg bg-blue text-white py-1 font-semibold px-6 mr-[60px] my-6">Done</button>
    </form>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#table").DataTable();

      $("#tablecontents").sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
          sendOrderToServer();
        }
      });

      function sendOrderToServer() {
        var order = [];
        var token = $('meta[name="csrf-token"]').attr('content');
        $('tr.row1').each(function(index, element) {
          order.push({
            id: $(this).attr('data-id'),
            position: index + 1
          });
        });

        $.ajax({
          type: "POST",
          dataType: "json",
          url: "{{ route('bayanihanleader.updateCotRowM', ['syll_id' => $syll_id]) }}",
          data: {
            order: order,
            _token: token
          },
          success: function(response) {
            if (response.status == "success") {
              console.log(response);
            } else {
              console.log(response);
            }
          }
        });
      }
    });
  </script>
</body>

</html>
@endsection
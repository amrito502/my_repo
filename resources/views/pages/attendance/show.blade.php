@extends('layouts.app')
@section('title', 'Attendance List')
@section('description', 'Attendance List')
@section('breadcrumb01', 'Attendance')
@section('breadcrumb02', 'Attendance List')
@section('app-content')

<meta name="csrf-token" content="{{ csrf_token() }}">


@php
    $current_date=\Carbon\Carbon::now()->format('d-m-Y');
    $class_id = request()->get('class_id') ?: 1;
    $section_id = request()->get('section_id') ?: 1;
    $get_date = request()->get('date');
    $get_shift = request()->get('shift') ?: 'Day';
    $gender = request()->get('gender') ?: 'Boy';
    $filterDate = \Carbon\Carbon::parse($get_date)->format('d-m-Y');
@endphp

    <style>
        .header-flex {
            /* display: flex;
            justify-content: space-between;
            align-items: center; */
            float: right;
        }

        body #SearchForm{
            display: flex;
            flex-direction: row;
            align-items: end;
        }

        body input#search.form-control {
            margin: 0px;
            width: 50%;
        }

        body input#dateInput{
            border: 1px solid #ccc;
            padding: 4px 10px;
        }
    </style>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <div class="mb-1" style="width: 100%">
                        <div class="d-flex" style="align-items: center; justify-content: space-between;">
                            <h2 style="width: 50%;">Attendance List</h2>

                            <input type="text" id="search" style="width: 285px;" class="form-control" placeholder="Search Student">

                            @if ($attendences->count() >0 && $attendences[0]->date == $current_date)

                                <a href="{{ route('attendance.edit',$attendences[0]->uuid) }}" class="btn btn-yellow btn-sm mx-3"><i
                                            class="zmdi zmdi-edit"></i>
                                        Edit Attendance </a>

                                {{-- Send SMS Button on Ajax --}}
                                {{-- <button id="myButton" class="btn btn-yellow btn-sm send-sms">
                                    <i class="zmdi zmdi-sms"></i> Send sms for all Absent Students
                                </button> --}}

                                <form id="myForm" action="{{ route('SendAttendaceSms') }}" method="POST" class="m-0">
                                    @csrf <!-- Laravel CSRF protection -->
                                    <input type="hidden" name="classId" value="<?php echo $class_id; ?>">
                                    <input type="hidden" name="SectionId" value="<?php echo $section_id; ?>">
                                    <input type="hidden" name="shift" value="<?php echo $get_shift; ?>">
                                    <input type="hidden" name="gender" value="<?php echo $gender; ?>">
                                    <button type="submit" class="btn btn-yellow btn-sm send-sms">
                                        <i class="zmdi zmdi-sms"></i> Send sms for all Absent Students
                                    </button>
                                </form>


                                {{-- <a href="{{ route('attendance.all_sms',$attendences[0]->class_id) }}" class="btn btn-yellow btn-sm send-sms"><i
                                    class="zmdi zmdi-sms"></i>
                                Send sms for all student </a> --}}

                            @endif
                        </div>
                    </div>
                    <div class="mb-1 header-flex" style="width: 100%">
                        <form id="SearchForm" method="get" action="{{ route('attendance.show') }}">
                            @csrf

                            <input type="date" id="dateInput"  style="width: 300px; border-radius: 5px; border: 1px solid #ccc;" class="mr-3" name="dateInput" value="{{ old('dateInput') }}">

                                <select required name="class_id" id="class_id" class="form-control show-tick">
                                    <option value=""> -- Select Class -- </option>
                                    @foreach($classes as $data)
                                        <option value="{{$data->id}}" {{ $class_id == $data->id ? 'selected' : '' }}>{{$data->name}}</option>
                                    @endforeach
                                </select>

                                <select required name="section_id" id="section_id" class="form-control show-tick">

                                </select>

                                <select name="shift" id="shift" class="form-control show-tick mr-3">
                                    <option value="Day" {{ $get_shift == 'Day' ? 'selected' : '' }}>Day</option>
                                    <option value="Morning" {{ $get_shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                                </select>

                                <select name="gender" id="gender" class="form-control show-tick mr-3">
                                    <option value="Boy" {{ $gender == 'Boy' ? 'selected' : '' }}>Boy</option>
                                    <option value="Girl" {{ $gender == 'Girl' ? 'selected' : '' }}>Girl</option>
                                </select>

                            <button type="button" class="btn btn-info btn-sm ml-auto" onclick="submitForm()"> <i class="zmdi zmdi-filter-list"></i> FILTER</button>
                        </form>
                    </div>
                </div>
                <div class="body table-responsive">
                    @if ($attendences->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Class</th>
                                <th>Branch</th>
                                <th>Shift</th>
                                <th>Gender</th>
                                <th>Attent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendences as $key=>$data)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$data->date}}</td>
                                @if ($data->students !=null)
                                    <td>{{$data->students->first_name}} {{$data->students->last_name}}</td>
                                @else
                                    <td>N/L</td>
                                @endif
                                <td>{{$data->students->student_number}}</td>
                                <td>{{$data->studentClass->name}}</td>
                                <td>{{$data->studentClass->sections->name}}</td>
                                <td>{{$data->shift}}</td>
                                <td>{{$data->students->gender}}</td>

                                <td>
                                    @if($data->attent =='1')
                                        <button type="button" class="btn btn-success">Present</button>
                                    @endif
                                    @if($data->attent =='0')
                                        <button type="button" class="btn btn-danger">Absent</button>

                                        @if ($current_date ==$data->date)
                                            @php
                                            $currentDate = date('Y-m-d');

                                        $smsHistories = DB::select('SELECT * FROM sms_histories WHERE student_id = ? AND DATE(created_at) = ?', [$data->students->id , $currentDate]);

                                       // print_r($smsHistories);

                                        $sendstatus = count($smsHistories) > 0 ? 1 : 0;

                                        @endphp

                                        @if ( $sendstatus == 0)
                                        {{-- <a class="btn btn-yellow send-sms" href="{{ route('attendance.sms', [$data->uuid]) }}" class="btn-action">
                                            Send SMS
                                         </a> --}}
                                         <form id="myForm" action="{{ route('SendSingleAttendaceSms') }}" method="POST" class="m-0 d-inline-block">
                                            @csrf <!-- Laravel CSRF protection -->
                                            <input type="hidden" name="classId" value="<?php echo $data->studentClass->name; ?>">
                                            <input type="hidden" name="student_id" value="{{$data->students->id}}">
                                            <input type="hidden" name="date" value="{{$data->date}}">
                                            <input type="hidden" name="student_name" value="{{$data->students->first_name}} {{$data->students->last_name}}">
                                            <input type="hidden" name="phone_number" value="{{$data->students->phone_number}}">

                                            <button type="submit" class="btn btn-yellow btn-sm send-sms">
                                                <i class="zmdi zmdi-sms"></i> Send sms</button>
                                        </form>
                                        @else
                                        <span class="btn btn-success"><i class="fa fa-check"></i> SMS sent</span>
                                        @endif
                                        @endif
                                    @endif
                                    @if($data->attent =='2')
                                        <button type="button" class="btn btn-warning">Delay</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-info">
                        <p class="text-center mb-0"><i class=" zmdi zmdi-info"></i> Attendance for this day has not been taken.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('.table tbody tr');

            searchInput.addEventListener('input', function () {
                const searchQuery = this.value.trim().toLowerCase();

                tableRows.forEach(function (row) {
                    let isMatch = false;

                    row.querySelectorAll('td').forEach(function (cell) {
                        const cellData = cell.textContent.trim().toLowerCase();
                        if (cellData.includes(searchQuery)) {
                            isMatch = true;
                        }
                    });

                    if (isMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var sendSMSButtons = document.querySelectorAll('.send-sms');
            sendSMSButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    var confirmSMS = confirm('Are you sure you want to send SMS?');
                    if (!confirmSMS) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>

    <script>
        function formatDate(dateString) {
            var parts = dateString.split("-");
            return parts[2] + "-" + parts[1] + "-" + parts[0];
        }

        function submitForm() {
            var dateInput = document.getElementById("dateInput").value;
            var class_id = document.getElementById("class_id").value;
            var section_id = document.getElementById("section_id").value;
            var shift = document.getElementById("shift").value;
            var gender = document.getElementById("gender").value;
            var formattedDate = formatDate(dateInput);
            var url = "/attendance/show?date=" + formattedDate + "&class_id=" + class_id + "&section_id=" + section_id + "&shift=" + shift + "&gender=" + gender;
            window.location.href = url;
        }

        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            var dateParam = urlParams.get('date');
            if (dateParam) {
                document.getElementById("dateInput").value = formatDate(dateParam);
            }else{
                var currentDate = new Date();
                var year = currentDate.getFullYear();
                var month = String(currentDate.getMonth() + 1).padStart(2, '0');
                var day = String(currentDate.getDate()).padStart(2, '0');
                var formattedCurrentDate = year + "-" + month + "-" + day;
                document.getElementById("dateInput").value = formattedCurrentDate;
            }
        };
    </script>

@endsection


<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap and Bootstrap-select if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

{{-- <script type="text/javascript">

    $(document).ready(function() {

        var selectedClassID = <?php echo $class_id; ?>;

        if(selectedClassID) {
            $('#class_id').val(selectedClassID);

            // Trigger change event to load sections for the default class ID
            //$('#class_id').change();

            $.ajax({
                url: '{{ url("/get-sections-by-class") }}/' + selectedClassID,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#section_id').empty();

                    $.each(data, function(key, value) {
                        $('#section_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });

                    $('#section_id').selectpicker('refresh');

                }
            });

        }else{
            $('#section_id').empty();
            $('#section_id').selectpicker('refresh');
        }

        $('#class_id').change(function() {

            // Get from url the class id
            //console.log(selectedClassID);

            var classId = $(this).val();

            if(classId) {
                $.ajax({
                    url: '{{ url("/get-sections-by-class") }}/' + classId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#section_id').empty();

                        $.each(data, function(key, value) {
                            $('#section_id').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                        $('#section_id').selectpicker('refresh');

                    }
                });
            } else {
                $('#section_id').empty();
                $('#section_id').selectpicker('refresh');
            }
        });
    });
</script> --}}

<script type="text/javascript">
    $(document).ready(function() {

        var selectedClassID = <?php echo $class_id; ?>;

        // Function to fetch sections based on class ID
        function fetchSections(classId) {
            $.ajax({
                url: '{{ url("/get-sections-by-class") }}/' + classId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    updateSectionOptions(data);
                },
                error: function() {
                    console.error('Failed to fetch sections.');
                }
            });
        }

        // Function to update section options
        function updateSectionOptions(data) {
            $('#section_id').empty();

            $.each(data, function(key, value) {
                $('#section_id').append('<option value="' + key + '">' + value + '</option>');
            });

            $('#section_id').selectpicker('refresh');
        }

        // Initial fetch if a class ID is selected
        if (selectedClassID) {
            $('#class_id').val(selectedClassID);
            fetchSections(selectedClassID);
        } else {
            updateSectionOptions([]);
        }

        // Event listener for class ID change
        $('#class_id').change(function() {
            var classId = $(this).val();

            if (classId) {
                fetchSections(classId);
            } else {
                updateSectionOptions([]);
            }
        });
    });
</script>

    <script>
        $(document).ready(function(){
            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#myButton').click(function(){
                $.ajax({
                    url: "{{ route('SendAttendaceSms') }}",
                    type: 'POST',
                    data: {
                        classId:  <?php echo $class_id; ?>,
                        SectionId: <?php echo $section_id; ?>,
                        shift: `<?php echo $get_shift; ?>`,
                    },
                    success: function(response) {

                        alert(response.message);
                        //console.log('Class: ' + response.class_id + ' Section: ' + response.section_id + ' Shift: ' + response.shift);

                        console.log('Students: ' + JSON.stringify(response.allAbsentstudents));

                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.status + ' ' + xhr.statusText);
                    }
                });
            });

        });
    </script>



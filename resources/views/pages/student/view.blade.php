@extends('layouts.app')
@section('title', 'Student Detail')
@section('description', 'Student Detail')
@section('breadcrumb01', 'Student')
@section('breadcrumb02', 'Student Detail')
@section('app-content')
@php

$statusMap = array(
    1 => 'present',
    0 => 'absent',
    2 => 'delay'
);

// Extracting attendances by date (Day)
$attendanceData = array();
foreach ($studentAttendance as $attendance) {
    $attendanceDate = date('j', strtotime($attendance['date']));
    $attendanceStatus = $statusMap[$attendance['attent']];
    // If the date already has attendance recorded, update the status
    if (isset($attendanceData[$attendanceDate])) {
        $attendanceData[$attendanceDate] = $attendanceStatus;
    }else{
        $attendanceData[$attendanceDate] = $attendanceStatus;
    }
}
// Get UUID from URL
$getUUID = request()->segment(3);

$getYear = request()->get('year') ?: date('Y');
$getMonth = request()->get('month') ?: date('m');

// echo $getYear;
// echo $getMonth;

@endphp

    <!-- Page content area start -->
    <style>
        table.table{
            margin: 0px;
        }
        table.table tr, table.table th, table.table td{
            vertical-align: middle;
            text-align: center;
            border-radius: 20px;
        }
        table.table th, table.table td{
            padding: 7px 0px;
            width: 100px;
            border: 4px solid #16143e;
        }
        .weekend {
            background-color: #61B2EB;
        }
        .present{
            background-color: #85e283;
            color: #000;
        }

        .absent{
            background-color: #fd9191;
            color: #000;
        }
        .delay{
            background-color: #a37700;
            color: #fff;
        }

        body .bootstrap-select.btn-group.show-tick>.btn{
            padding-left: 20px;
        }

        body .bootstrap-select.btn-group:not(.input-group-btn), body .bootstrap-select.btn-group[class*="col-"]{
            margin: 0px;
        }

        .customCalender{
            background: #16143e;
            color: #fff;
            padding: 10px 0;
            border-radius: 13px;
        }

    </style>
    <div class="row clearfix">

        <div class="col-md-6">
            <div class="card p-4">
                <div class="card-body">
                    <h3 class="card-title mb-4 mt-0">Student Info</h3>
                    <h6 class="card-subtitle text-muted mb-3"> <b>Name:</b> {{ $student->first_name }} {{ $student->last_name }}</h6>
                    <p><b>Class:</b> {{ $student->assign->studentClass->name }}</p>
                    <p><b>Section:</b> {{ $student->assign->section->name }}</p>
                    <p><b>Address:</b> {{ $student->address }}</p>
                    <p><b>phone:</b> {{ $student->phone_number }}</p>
                    <p><b>Gender:</b> {{ $student->gender }}</p>

                    {{-- @php
                        $teacher_data = \App\Models\StudentAssgin::where([['section_id', $student_assign->section_id], ['student_class_id', $student_assign->student_class_id], ['user_id', '!=', $student->user_id]])
                            ->orderBy('id', 'DESC')
                            ->with('teachers')
                            ->first();
                    @endphp
                    @if (!empty($teacher_data))
                        <p><b>Class Teacher:</b> {{ $teacher_data->teachers->first_name }}
                            {{ $teacher_data->teachers->last_name }}</p>
                    @else
                        <p><b>Class Teacher:</b>N/L</p>
                    @endif --}}
                    {{-- <a href="{{ route('admin.student.mark', $student->uuid) }}" class="btn btn-success card-link">Result Sheet</a> --}}
                    {{-- <a href="#" class="card-link">Edit</a> --}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('student.view', [$getUUID]) }}" method="post">
                @csrf
                <input type="hidden" name="uuid" value="{{ $student->uuid }}">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <select id="month" name="month" class="form-control show-tick">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == $getMonth ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select id="year" name="year" class="form-control show-tick">
                            @php
                                $currentYear = date('Y');
                                $range = 2;
                            @endphp
                            @for ($i = $currentYear - $range; $i <= $currentYear + $range; $i++)
                                <option value="{{ $i }}" {{ $i == $getYear ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-info w-100" style="height: 39px; "><i class="zmdi zmdi-filter-list"></i> Filter</button>
                    </div>
                </div>
            </form>
            <div class="customCalender">
            <?php
                // Get the current month and year
                // $month = date('n');
                // $year = date('Y');
                $month = isset($_POST['month']) ? $_POST['month'] : date('n');
                $year = isset($_POST['year']) ? $_POST['year'] : date('Y');

                $today = date('j');

                // Get the number of days in the current month
                $numDays = date('t', mktime(0, 0, 0, $month, 1, $year));

                // Get the day of the week the first day of the month falls on
                $firstDayOfWeek = date('N', mktime(0, 0, 0, $month, 1, $year));

                //echo '<h4>' . date('F Y', mktime(0, 0, 0, $month, 1, $year)) . '</h4>';

                // Output HTML for the calendar
                echo '<table class="calendar calendar table table-striped">';

                echo '<tr>';
                $dayNames = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                foreach ($dayNames as $dayName) {
                    echo '<th>' . substr($dayName, 0, 3) . '</th>';
                }
                echo '</tr>';
                echo '<tr>';

                // Output blank cells for days before the first day of the month
                for ($i = 1; $i < $firstDayOfWeek; $i++) {
                    echo '<td></td>';
                }

                $TotalPresent = 0;
                $TotalAbsent = 0;
                $TotalDelay = 0;
                $TotalWeekend = 0;
                // Output cells for each day of the month
                for ($day = 1; $day <= $numDays; $day++) {

                    $dateString = sprintf('%02d-%02d', $month, $day);

                    $class = isset($highlightDates[$dateString]) ? 'highlight' : '';

                    // Highlight today
                    if ($day == $today) {
                        $class .= ' current-date';
                    }
                    // Highlight weekends (Friday and Saturday)
                    if (($firstDayOfWeek + $day - 1) % 7 == 5) {
                        $class .= ' weekend';
                        $TotalWeekend++;
                    }
                    // Add the class to the cell
                    if (isset($attendanceData[$day])) {
                        $class .= ' ' . $attendanceData[$day];

                        if ($attendanceData[$day] == 'present') {
                            $TotalPresent++;
                        } elseif ($attendanceData[$day] == 'absent') {
                            $TotalAbsent++;
                        } elseif ($attendanceData[$day] == 'delay') {
                            $TotalDelay++;
                        }
                    }
                    echo '<td class="' . $class . '">' . $day . '</td>';
                    // Start a new row every 7 days (end of the week)
                    if (($day + $firstDayOfWeek - 1) % 7 == 0) {
                        echo '</tr><tr>';
                    }
                }
                // Output blank cells for any remaining days in the last week
                $lastDayOfWeek = ($firstDayOfWeek + $numDays - 1) % 7;
                if ($lastDayOfWeek != 0) {
                    for ($i = 0; $i < 7 - $lastDayOfWeek; $i++) {
                        echo '<td></td>';
                    }
                }
                echo '</tr>';
                echo '</table>';
                ?>
            </div>
            <div class="d-flex justify-content-between">
                <h4>Present : <span class="badge badge-success">{{ $TotalPresent }}</span></h4>
                <h4>Absent : <span class="badge badge-danger">{{ $TotalAbsent }}</span></h4>
                <h4>Delay : <span class="badge badge-warning">{{ $TotalDelay }}</span></h4>
                <h4>Weekend : <span class="badge badge-info">{{ $TotalWeekend }}</span></h4>
            </div>
        </div>

        <div class="col-md-12">
            <a href="{{ route('student.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

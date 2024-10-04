@extends('layouts.app')
@section('title', 'Exam Mark')
@section('description', 'Exam Mark .')
@section('breadcrumb01', 'Exam')
@section('breadcrumb02', 'Exam Mark')
@section('app-content')

@php
    $userRole = Auth::user()->role;
@endphp

    <style>
        .section-card {
            background: #fff;
            min-height: 50px;
            position: relative;
            transition: .5s;
            border-radius: 8px;
            border: none;
            display: flex;
            flex-direction: column;
        }
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .popup-content {
            position: relative;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .close-popup {
            position: absolute;
            top: -10px;
            right: -10px;
            cursor: pointer;
            background: #da3c2f;
            color: #fff;
            padding: 0px;
            height: 30px;
            width: 30px;
            border-radius: 100px;
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            line-height: normal;
        }
        .close-popup:hover{
            opacity: 0.6;
        }
        .student_mark{
            min-width: 420px;
            padding: 15px 20px 20px;
            box-shadow: 0 0px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            position: relative;
            background: #fff;
        }
        .student_mark h5{
            color: #5f5e5e;
            text-transform: uppercase;
        }
        .student_mark ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .student_mark ul li {
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            padding: 5px 15px;
        }
        .student_mark ul li span {
            width: 33.3333333333%;
            text-align: center;
        }
        .student_mark ul li span:nth-child(1){
            text-align: left
        }

        .student_mark ul li span:nth-child(3){
            text-align: right;
        }

        .student_mark ul li:last-child, .student_mark ul li:first-child {
            background: #dedede;
            font-weight: bold;
            font-size: 16px;
        }
        .SearchForm{
            width: 320px;
        }
        button.send-sms{
            border: none;
        }
    </style>

    @php
        $uuid = request()->segment(3);

        // echo "<pre>";
        // echo($marks);
        // echo "</pre>";
    @endphp

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header header-flex">
                    <h2>Exam Name: <span style="font-weight: bold; font-size: 20px">{{ $exams->name }}</span>
                    </h2>
                    <span class="ml-3"><a href="{{ route('exam.mark', [$uuid]) }}" class="badge badge-success mr-2" title="Mark" style="padding: 8px 12px; border-radius: 5px;">
                        <i class="fa fa-check"></i> Give The Mark
                    </a></span>

                    @if($userRole == '1')
                        <a href="{{ route('exam.index') }}" class="btn btn-success btn-sm ml-auto"><i class="fa fa-file-text mr-2" style="font-size: 14px; top: 0px;"></i>
                            Exam List</a>
                    @endif
                </div>

                <div class="body">
                    <div class="d-flex justify-content-between mb-3">
                        <p><i class="fa fa-calendar"></i> Exam Date: <br> <strong>
                            @php
                                $dateFormate = Carbon\Carbon::parse($exams->start_date_time);
                                echo $dateFormate->format('jS F Y');
                            @endphp
                        </strong></p>
                        <p><i class="fa fa-user"></i> Teacher Name: <br> <strong>{{ $exams->teacher->first_name }} {{ $exams->teacher->last_name }}</strong>
                        </p>
                        <p>
                            <i class="fa fa-building"></i> Class: <br>
                            <strong>
                                @php
                                    $class = App\Models\StudentClass::where('id', $exams->class_id)->first();
                                    echo $class->name;
                                @endphp
                            </strong>
                        </p>
                        <p>
                            <i class="fa fa-book"></i> Subjects: <br>
                            @php
                                if ($exams->subjects == null) {
                                    $getsubjects = [];
                                }else{
                                    $getsubjects = json_decode($exams->subjects);
                                }
                            @endphp

                            @foreach ($getsubjects as $subject)
                                @if ($subject != null)
                                    @php
                                        $subject = App\Models\Subject::where('id', $subject)->first();
                                    @endphp

                                    <span class="badge badge-primary">{{ $subject->name }}</span>
                                @endif
                            @endforeach
                        </p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <h3 class="mt-0">Exam Marks</h3>

                        <div class="SearchForm">
                            <input type="text" class="form-control" id="search" placeholder="Search Student by Name Roll Shift">
                        </div>

                    </div>

                    @if ($error)
                        <span class="text-warning"><i class="fa fa-exclamation-triangle"></i>
                            {{ $error }}</span>
                    @else

                    <div class="d-flex">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th class="text-center">Roll No.</th>
                                    <th>Branch</th>
                                    <th>Shift</th>
                                    <th>Gender</th>
                                    <th>Marks</th>
                                    @if($userRole == '1')
                                    <th>SMS</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td class="text-center">{{ $student->id }}</td>
                                        <td>
                                        {{$sectionName}}
                                        </td>
                                        <td>{{ $student->shift }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>
                                            <a href="#" class="badge badge-primary view-marks"
                                            student-id="{{ $student->id }}" student-name="{{ $student->first_name }} {{ $student->last_name }}" ><i class="zmdi zmdi-eye"></i> View Marks</a>

                                            <!-- Example of HTML buttons -->
                                            {{-- <a href="{{ route('exam.marksend', [$uuid]) }}" class="btn btn-yellow send-sms" data-student-id="123" data-exam-results='["A", "B", "C"]'>
                                                Send SMS
                                            </a> --}}

                                            @php
                                                // echo $marks;

                                            @endphp


                                        </td>
                                        @if($userRole == '1')
                                        <td>
                                            @php

                                                $smsHistories = DB::select('SELECT * FROM sms_histories WHERE student_id = ? AND exam_id = ?', [$student->id, $exams->id]);

                                                $sendstatus = count($smsHistories) > 0 ? 1 : 0;

                                            @endphp
                                            @if($sendstatus == 0)
                                                <form id="sendSMSForm_{{ $student->id }}" method="POST" action="{{ route('sendExamSms') }}">
                                                    <!-- Add any form fields you need -->
                                                    <input type="hidden" name="studentId" value={{ $student->id }}>
                                                    <input type="hidden" name="exam_id" value={{ $exams->id }}>
                                                    <input type="hidden" name="class_name" value="{{ $class->name }}">
                                                    @csrf <!-- CSRF Token for security -->
                                                    <button class="badge badge-info send-sms" type="submit"><i class="fa fa-commenting-o"></i> Send SMS</button>
                                                </form>
                                            @else
                                                <span class="badge badge-success"><i class="fa fa-check"></i> SMS Sent</span>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

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
</script>

<script>
    var marksData = <?php echo json_encode($marks); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const viewMarksButtons = document.querySelectorAll('.view-marks');

        viewMarksButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                //get from a attribute
                const studentName = this.getAttribute('student-name');
                const studentId = this.getAttribute('student-id');

                let studentMarks = findEntry(marksData, studentId);

                // Create the popup content
                /*const popupContent = `
                    <div class="popup">
                        <div class="student_mark">
                            <span class="close-popup">&times;</span>
                            <h5><i class="fa fa-user"></i> `+ studentName +` - `+ studentId +`</h5>
                            <ul>
                                <li>
                                    <span>Subject</span>
                                    <span>Max Marks</span>
                                    <span>Mark</span>
                                </li>
                                <li>
                                    <span>Bangla</span>
                                    <span>100</span>
                                    <span>70</span>
                                </li>
                                <li>
                                    <span>English</span>
                                    <span>100</span>
                                    <span>80</span>
                                </li>
                                <li>
                                    <span>Total</span>
                                    <span>200</span>
                                    <span>150</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                `;*/

                let totalMaxMark = 0;
                let totalMark = 0;

                let popupContent = `
                    <div class="popup">
                        <div class="student_mark">
                            <span class="close-popup">&times;</span>
                            <h5><i class="fa fa-user"></i> ${studentName}</h5>
                            <ul>
                                <li>
                                    <span>Subject</span>
                                    <span>Max Marks</span>
                                    <span>Mark</span>
                                </li>
                `;

                // Check if marks data is available
                if (studentMarks) {
                    // Generate list items dynamically based on marks data
                    studentMarks.forEach(subject => {
                        totalMaxMark += parseInt(subject.max_mark);
                        totalMark += parseInt(subject.mark);

                        popupContent += `
                            <li>
                                <span>${subject.subject_name}</span>
                                <span>${subject.max_mark}</span>
                                <span>${subject.mark}</span>
                            </li>
                        `;
                    });
                } else {
                    // Show message if marks data is empty
                    popupContent += `<p class="badge badge-warning"> <i class="fa fa-exclamation-triangle"></i> No marks available for this student.</p>`;
                }
                popupContent += `
                                <li>
                                    <span>Total</span>
                                    <span>${totalMaxMark}</span>
                                    <span>${totalMark}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                `;

                // Append the popup content to the body
                document.body.insertAdjacentHTML('beforeend', popupContent);

                // Close the popup when the close button is clicked
                const closeButton = document.querySelector('.close-popup');
                closeButton.addEventListener('click', function () {
                    const popup = document.querySelector('.popup');
                    popup.parentNode.removeChild(popup);
                });
            });
        });
    });

    function findEntry(data, studentId) {
        return data.filter(entry => {
            const entryStudentId = typeof entry.student_id === 'number' ? entry.student_id.toString() : entry.student_id;

            return entryStudentId === studentId.toString();
        });
    }


    // Define a function to send the AJAX request
    /*function sendSMS(url) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('GET', url, true);

        // Define the function to handle the response
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Request was successful
                console.log('SMS sent successfully!');

                console.log(xhr.responseText);
            } else {
                // Request failed
                console.error('Failed to send SMS. Error: ' + xhr.statusText);
            }
        };

        // Define the function to handle errors
        xhr.onerror = function () {
            console.error('Failed to send SMS. Network error.');
        };

        // Send the request
        xhr.send();
    }

    // Add an event listener to the "Send SMS" link
    document.addEventListener('DOMContentLoaded', function () {
        var sendSMSButton = document.querySelector('.send-sms');
        if (sendSMSButton) {
            sendSMSButton.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default action of the link
                var url = sendSMSButton.href; // Get the URL from the href attribute
                sendSMS(url); // Call the sendSMS function with the URL
            });
        }
    }); */
</script>


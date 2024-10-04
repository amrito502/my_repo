@extends('layouts.app')
@section('title', 'Exam Mark')
@section('description', 'Exam Mark .')
@section('breadcrumb01', 'Exam')
@section('breadcrumb02', 'Exam Mark')
@section('app-content')

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
        .selected-color {
            background-color: green;
            color: #ffffff;
        }
        .customInput input{
            border: 1px solid #ced4da;
            border-radius: 10px;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: rgb(230 238 255);
            background-clip: padding-box;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            width: 130px;
        }
        .customInput input[name="mark"]{
            background: rgb(213, 255, 213);
        }

        input.subjectInput{
            text-align: center;
        }
        .table td, .table th{
            vertical-align: middle;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .toast.success {
            background-color: #28a745;
            color: #fff;
        }

        .toast.info {
            background-color: #17a2b8;
            color: #fff;
        }

        .toast.warning {
            background-color: #ffc107;
            color: #212529;
        }

        .toast.error {
            background-color: #dc3545;
            color: #fff;
        }
        .toast.show {
            opacity: 1;
        }

        .Searchform{
            width: 320px;
            margin-left: 20px;
        }
    </style>

    @php
        $uuid = request()->segment(3);
    @endphp

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header header-flex justify-content-between">
                    <h2>Exam Name: <span class="btn btn-primary btn-sm ml-2">{{ $exams->name }}</span>
                    </h2>

                    <div class="Searchform">
                        <input type="text" class="form-control" id="search" placeholder="Search Student by Name, Roll, Shift, Gender">
                    </div>

                    <a href="{{ route('exam.index') }}" class="btn btn-success btn-sm ml-auto"><i class="fa fa-file-text mr-2" style="font-size: 14px; top: 0px;"></i>
                            Exam List</a>

                </div>

                <div class="body">
                    <div class="d-flex justify-content-between mb-3">
                        <p><i class="fa fa-calendar"></i> Exam Date:  <strong>
                            @php
                                $dateFormate = Carbon\Carbon::parse($exams->start_date_time);
                                echo $dateFormate->format('jS F Y');
                            @endphp
                        </strong></p>
                        <p><i class="fa fa-user"></i> Teacher Name: <strong>{{ $exams->teacher->first_name }} {{ $exams->teacher->last_name }}</strong>
                        </p>
                        <p>
                            <i class="fa fa-building"></i> Class:
                            <strong>
                                @php
                                    $class = App\Models\StudentClass::where('id', $exams->class_id)->first();

                                    echo $class->name;

                                @endphp
                            </strong>
                        </p>
                    </div>

                    <div>
                        <i class="fa fa-book"></i> Subjects:

                        @php
                            if ($exams->subjects == null) {
                                $getsubjects = [];
                            }else{
                                $getsubjects = json_decode($exams->subjects);
                            }
                        @endphp

                        @foreach ($getsubjects as $subjectId)
                            @if ($subjectId != null)
                                @php
                                    $subject = App\Models\Subject::find($subjectId);
                                @endphp

                                <label class="badge badge-primary">
                                    <input type="radio" name="subject" value="{{ $subject->id }}" subject="{{ $subject->name }}" onchange="updateSubjects()">
                                    {{ $subject->name }}
                                </label>
                            @endif
                        @endforeach

                        @if ($errors->has('subject_name'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                {{ $errors->first('subject_name') }}</span>
                        @endif
                        <br>
                        <span id="InfoMsg" class="text-info"> <i class="fa fa-exclamation-triangle"></i> Select a subject to given the mark</span>
                    </div>

                    <hr>

                    @if ($error)
                        <span class="text-warning"><i class="fa fa-exclamation-triangle"></i>
                            {{ $error }}</span>
                    @else

                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Student Name</th>
                                {{-- <th>Roll No.</th> --}}
                                <th>Section</th>
                                <th>Shift</th>
                                <th>Gender</th>
                                <th class="text-center">Subject</th>
                                <th>Full Marks</th>
                                <th>Student's Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    {{-- <td>{{ $student->id }}</td> --}}
                                    <td>
                                       {{$sectionName}}
                                    </td>
                                    <td>{{ $student->shift }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td class="text-center">
                                        <input style="border: none; background: transparent;" type="text" class="subject_name subjectInput text-info" name="subject_name">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center customInput">
                                            <input type="number" readonly name="max_mark" id="max_mark_{{ $student->id }}" value="{{$exams->max_marks}}" required placeholder="Enter Full Marks">
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('exam.givenMark') }}" method="post" id="markForm_{{ $student->id }}" style="margin-bottom: 0px;">
                                            @csrf

                                            <input type="hidden" name="exam_id" value="{{ $exams->id }}">
                                            <input type="hidden" name="olduuid" value="{{ $uuid }}">
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <input type="hidden" name="class_id" value="{{ $exams->class_id }}">
                                            <input type="hidden" name="subject_id" class="subject_id" value="{{ old('subject')}}">
                                            <input type="hidden" name="subject_name" class="subject_name" value="{{ old('subject_name')}}">

                                            <div class="d-flex justify-content-between align-items-center customInput">
                                                <input type="hidden" name="max_mark" id="max_mark_{{ $student->id }}" value="{{$exams->max_marks}}" required placeholder="Enter Full Marks">

                                                {{-- <input class="student_mark" type="number" name="mark" onchange="updateMarks({{ $student->id }})" id="mark_{{ $student->id }}" value="{{ old('mark') }}" required placeholder="Enter Marks"> --}}
                                                <input class="student_mark" type="number" name="mark" onchange="updateMarks({{ $student->id }})" id="mark_{{ $student->id }}" studentid="{{ $student->id }}"  value="" required placeholder="Enter Mark">

                                                {{-- <button type="submit" class="badge badge-primary" style="border: none;"><i class="fa fa-save"></i></button> --}}

                                                {{-- <input class="student_mark" type="number" name="mark" id="mark_{{ $student->id }}" value="{{ old('mark') }}" required placeholder="Enter Mark">

                                                <button type="submit" class="btn btn-primary btn-sm">Add</button> --}}
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

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

    function updateSubjects() {

        var selectedRadio = document.querySelector('input[name="subject"]:checked');

        var radioButtons = document.getElementsByName('subject');

        radioButtons.forEach(function(radioButton) {
            var label = radioButton.closest('label');
            if (radioButton.checked) {
                label.classList.add('selected-color');
            } else {
                label.classList.remove('selected-color');
            }
        });

        if (selectedRadio) {

            var selectedValue = selectedRadio.value;
            var subjectName = selectedRadio.getAttribute('subject');

            var exam_id = document.querySelector('input[name="exam_id"]').value;

            var subjectIdInputs = document.getElementsByClassName("subject_id");

            const elements = document.querySelectorAll('.student_mark');

            Array.from(elements).forEach((element, index) => {
                var desiredStudentID = element.getAttribute('studentid');
                var desiredSubjectID = selectedValue;

                const result = findEntry(marksData, desiredStudentID, desiredSubjectID);

                if (result) {
                    var mark = result.mark;
                    var max_mark = result.max_mark;
                    var student_id = result.student_id;

                    document.getElementById("mark_"+student_id).value = mark;

                    //document.getElementById("max_mark_"+student_id).value = max_mark;

                }else{
                    document.getElementById("mark_"+desiredStudentID).value = '';
                    //document.getElementById("max_mark_"+desiredStudentID).value = '';
                }
            });

            for (var i = 0; i < subjectIdInputs.length; i++) {
                subjectIdInputs[i].value = selectedValue;
            }

            var subjectNameInputs = document.getElementsByClassName("subject_name");

            for (var i = 0; i < subjectNameInputs.length; i++) {
                subjectNameInputs[i].value = subjectName;
            }

            document.getElementById("InfoMsg").style.display = 'none';

        }
    }

    function findEntry(data, studentId, subjectId) {
        return data.find(entry => {
            const entryStudentId = typeof entry.student_id === 'number' ? entry.student_id.toString() : entry.student_id;
            const entrySubjectId = typeof entry.subject_id === 'number' ? entry.subject_id.toString() : entry.subject_id;

            return entryStudentId === studentId.toString() && entrySubjectId === subjectId.toString();
        });
    }

    function updateMarks(studentId) {
        saveMark(studentId);
    }

    function saveMark(studentId) {
        // Get the mark and max_mark values
        var markInput = document.getElementById('mark_' + studentId);
        var maxMarkInput = markInput.parentNode.querySelector('input[name="max_mark"]');

        var mark = parseFloat(markInput.value);

        var maxMark = parseFloat(maxMarkInput.value);

        // Check if mark is smaller than max_mark
        if (mark > maxMark) {
            //alert('Mark cannot be greater than Max Mark');

            showToast('Mark cannot be greater than Max Mark', 'error');

            document.getElementById("max_mark_"+studentId).style.background = '#ffd8d8';

            markInput.focus();

            return;

        }else{

            document.getElementById("max_mark_"+studentId).style.background = 'rgb(230 238 255)';
        }

        // Perform AJAX request to save mark
        var form = document.getElementById('markForm_' + studentId);
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {

            //console.log(data);

            if (data) {

                console.log('Success:', data.data);

                //alert(data.message);
                showToast(data.message, 'success');


                // showToastrMessage

            } else {
                //alert('Fill the all required fields #');

                showToast(data.message, 'error');



            }
        })
        .catch(error => {
            console.error('Error:', error);
            //alert('Fill the all required fields @');
            showToast('Fill the all required fields', 'error');

        });
    }

    function showToast(message, type) {
        const toastContainer = document.getElementById('toast-container');

        // Create toast element
        const toast = document.createElement('div');
        toast.classList.add('toast');
        toast.classList.add(type);
        toast.innerText = message;

        // Append toast to container
        toastContainer.appendChild(toast);

        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            // Remove toast from container after animation ends
            toast.addEventListener('transitionend', () => {
            toast.remove();
            });
        }, 3000);
        }
</script>




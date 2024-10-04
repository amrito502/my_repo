@extends('layouts.app')
@section('title', 'Edit Exam')
@section('description', 'Edit Exam')
@section('breadcrumb01', 'Exam')
@section('breadcrumb02', 'Edit Exam')
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
    </style>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header header-flex">
                    <h2>Edit Exam</h2>
                    <a href="{{ route('exam.index') }}" class="btn btn-success btn-sm ml-auto"><i
                            class="zmdi zmdi-plus"></i>Exam List</a>
                </div>
                <div class="body">
                    {{-- <form id="form_validation" action="{{ route('exam.update', [$exams->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <h2 class="card-inside-title">Exam Name</h2>
                                <input type="text" name="name" id="name" value="{{ @$exams->name }}"
                                    class="form-control" required placeholder="Exam Name">
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <h2 class="card-inside-title">Select Class</h2>
                                <select name="subject_id" id="subject_id" class="form-control show-tick">
                                    <option value="{{ @$exams->subjects->id }}">{{ @$exams->subjects->name }}</option>
                                    @foreach ($subjects as $data)
                                        <option value="{{ $data->id }}" {{ @$exams->subjects->id == $data->id ? 'selected' : '' }}> {{ $data->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <br>


                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <h2 class="card-inside-title">Select Subject</h2>
                                <div class="demo-checkbox">
                                    @foreach ($subjects as $subject)
                                        <input type="checkbox" id="md_checkbox_{{ $subject->id }}" class="chk-col-red"
                                            checked />
                                        <label for="md_checkbox_{{ $subject->id }}">{{ $subject->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="form-group form-float">
                            <div class="form-line">
                                <h2 class="card-inside-title">Exam Date</h2>
                                <input type="text" class="form-control date" name="start_date_time" id="start_date_time"
                                    value="{{ @$exams->start_date_time }}" placeholder="End Date: DD/MM/YYYY" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('start_date_time') }}</span>
                                @endif

                            </div>
                        </div>
                        </br>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form> --}}

                    <form id="form_validation" action="{{ route('exam.update', [$exams->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <h2 class="card-inside-title">Exam Name</h2>
                                        <input type="text" name="name" id="name" value="{{ @$exams->name }}"
                                            class="form-control" required placeholder="Exam Name">
                                        @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <h2 class="card-inside-title">Exam Date</h2>
                                        <input type="date" class="form-control date" name="start_date_time" id="start_date_time"
                                            value="{{ $exams->start_date_time }}" placeholder="Exam Date: DD/MM/YYYY" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('start_date_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                @if (Auth::user()->instructor == null && Auth::user()->student == null)
                                    <div class="form-group form-float">
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <h2 class="card-inside-title">Select Teacher</h2>
                                                <select name="teacher_id" id="teacher_id" class="form-control show-tick">
                                                    <option value="">Select Teacher</option>
                                                    @foreach ($teachers as $data)
                                                        <option value="{{ $data->user_id }}" {{ $data->user_id == $exams->teacher_id ? 'selected' : '' }}> {{ $data->first_name }}
                                                            {{ $data->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <h2 class="card-inside-title">Max Marks</h2>
                                        <input type="number" name="max_marks" id="max_marks" value="{{ @$exams->max_marks }}"
                                            class="form-control" required placeholder="Max Marks">
                                        @if ($errors->has('max_marks'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('max_marks') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <h2 class="card-inside-title">Select Class</h2>
                                    <select name="class_id" id="class_id" class="form-control show-tick">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $exams->class_id ? 'selected' : '' }}> {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('name'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Select Subject</h2>
                                    <div class="demo-checkbox" id="subjectList">
                                        <p class="text-info">Please select class first to add subject</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </br>

                        <button class="btn btn-raised btn-primary waves-effect" type="submit">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var classSelect = document.getElementById('class_id');
        var subjectList = document.getElementById('subjectList');

        classSelect.addEventListener('change', function () {
            var classId = this.value;
            // Fetch subjects based on selected class using AJAX
            fetch( '{{ route("get-subjects") }}?class_id=' + classId)
                .then(response => response.json())
                .then(data => {

                    console.log(data);

                    // Clear existing subjects
                    subjectList.innerHTML = '';

                    data['subjects'].forEach(subject => {
                        var checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'subjects[]'; // Set the name attribute for submission
                        checkbox.value = subject.id; // Set the value attribute for submission
                        checkbox.id = 'md_checkbox_' + subject.id;
                        checkbox.className = 'chk-col-red';
                        checkbox.checked = true;

                        var label = document.createElement('label');
                        label.htmlFor = 'md_checkbox_' + subject.id;
                        label.textContent = subject.name;

                        subjectList.appendChild(checkbox);
                        subjectList.appendChild(label);
                    });
                })
                .catch(error => console.error('Error fetching subjects:', error));
        });

        // Set default value and trigger change event
        classSelect.value = '{{ $exams->class_id }}'; // Change 'default_value' to your desired default value
        classSelect.dispatchEvent(new Event('change'));
    });
</script>

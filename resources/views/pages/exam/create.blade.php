@extends('layouts.app')
@section('title', 'Add Exam')
@section('description', 'Add your Exam.')
@section('breadcrumb01', 'Exam')
@section('breadcrumb02', 'Add Exam')
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
                    <h2>Create New Exam</h2>
                    <a href="{{ route('exam.index') }}" class="btn btn-success btn-sm ml-auto"><i class="fa fa-file-text mr-2" style="font-size: 14px; top: 0px;"></i> Exam List</a>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{ route('exam.store') }}" method="post" enctype="multipart/form-data">
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
                                            value="{{ old('start_date_time') }}" placeholder="Exam Date: DD/MM/YYYY" required>
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
                                                        <option value="{{ $data->user_id }}"> {{ $data->first_name }}
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
                                        <input type="number" name="max_marks" id="max_marks" value="{{ @$exams->name }}"
                                            class="form-control" required placeholder="Enter Max Marks">
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
                                            <option value="{{ $data->id }}"
                                                {{ old('name') == $data->name ? 'selected' : '' }}> {{ $data->name }}</option>
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

                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
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

                    // console.log(data);

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
    });
</script>

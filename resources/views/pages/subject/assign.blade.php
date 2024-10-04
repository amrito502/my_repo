@extends('layouts.app')
@section('title', 'Subject Assign')
@section('description', 'Subject add in class')
@section('breadcrumb01', 'Subject')
@section('breadcrumb02', 'Add Subject')
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
    </style>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Subject Assign</h2>
                </div>

                <div class="body">
                    <form id="form_validation" action="{{ route('section.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <h2 class="card-inside-title">Select Class</h2>
                                <select name="student_classe_id" id="student_classe_id" class="form-control show-tick"
                                    required>
                                    @foreach ($classes as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('name') == $data->name ? 'selected' : '' }}> {{ $data->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('student_classe_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('student_classe_id') }}</span>
                                @endif

                                {{-- <input type="hidden" name="class_id" value="{{ $class_id }}">

                                <input type="hidden" name="section_id" value="{{ $section_id }}"> --}}


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

                        </br>

                        <a href="{{ route('dashboard') }}" class="btn btn-raised btn-default waves-effect">Back</a>

                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Class')
@section('description', 'Edit class access the application.')
@section('breadcrumb01', 'Class')
@section('breadcrumb02', 'Edit Class')
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
                    <h2>Edit Class</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('class.update', [$class->id])}}" method="post" enctype="multipart/form-data">
                            @csrf

                            @php
                                if ($class->subjects == null) {
                                    $saved_subjects = [];
                                }else{
                                    $saved_subjects = json_decode($class->subjects);
                                }
                            @endphp
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="name" id="name" value="{{ $class->name }}"
                                        class="form-control" required placeholder="Class Name">

                                        @if ($errors->has('name'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('name') }}</span>
                                    @endif

                                </div>

                                <br> <br>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <h2 class="card-inside-title">Select Subject</h2>
                                        <div class="demo-checkbox">

                                            @foreach ($subjects as $subject)
                                                <input type="checkbox" name="subjects[]" id="md_checkbox_{{ $subject->id }}" class="chk-col-red" value="{{ $subject->id }}" {{ in_array($subject->id, $saved_subjects) ? 'checked' : '' }}/>
                                                <label for="md_checkbox_{{ $subject->id }}">{{ $subject->name }}</label>
                                            @endforeach

                                            @if ($errors->has('subjects'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('subjects') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <a href="{{ route('dashboard') }}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

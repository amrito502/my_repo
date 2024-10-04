@extends('layouts.app')
@section('title', 'Assgin')
@section('description', 'Assgin.')
@section('breadcrumb01', 'Assgin')
@section('breadcrumb02', 'Assgin')
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
                    <h2>Create new Exam</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('assgin.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Class</label>
                                <select  name="class_id" id="class_id" class="form-control show-tick">
                                 @foreach($classes as $data)
                                  <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        </br>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Section</label>
                                <select  name="section_id" id="section_id" class="form-control show-tick">
                                 @foreach($sections as $data)
                                  <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                       </br>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Subject</label>
                                <select  name="subject_id" id="subject_id" class="form-control show-tick">
                                 @foreach($subjects as $data)
                                  <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                       </br>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Student</label>
                                <select  name="student_id" id="student_id" class="form-control show-tick">
                                 @foreach($students as $data)
                                  <option value="{{$data->user_id}}"> {{$data->first_name}}  {{$data->last_name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        </br>
                        <a href="{{ route('assgin.index') }}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

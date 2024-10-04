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
    </style>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Create new Exam</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('exam.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                                <label class="form-label">Exam Name</label>
                            </div>
                        </div>




                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Class</label>
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

                        <div class="form-group form-float">
                            <div class="form-line">

                                <input type="text" class="form-control date" name="start_date_time" id="start_date_time" value="{{ old('start_date_time') }}" placeholder="End Date: DD-MM-YYYY" required>

                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('start_date_time') }}</span>
                                @endif

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

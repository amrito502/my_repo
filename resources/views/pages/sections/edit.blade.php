@extends('layouts.app')
@section('title', 'Edit Branch')
@section('description', 'Edit Branch .')
@section('breadcrumb01', 'Branch')
@section('breadcrumb02', 'Edit Branch')
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
                    <h2>Edit Branch</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{ route('section.update', [$section->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{ @$section->name }}"
                                    class="form-control" required placeholder="Branch Name">
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Class</label>
                                <select name="student_classe_id" id="student_classe_id" class="form-control show-tick"
                                    required>
                                    <option value="{{ @$section->studentClassData->id }}">
                                        {{ @$section->studentClassData->name }}</option>
                                    @foreach ($class as $data)
                                        <option value="{{ $data->id }}"> {{ $data->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('student_classe_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('student_classe_id') }}</span>
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

@extends('layouts.app')
@section('title', 'Add Subject')
@section('description', 'Add Subject.')
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
                    <h2>Create Subject</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{ route('exam.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="subject_name" id="subject_name"
                                    value="{{ old('subject_name') }}" class="form-control" required>
                                @if ($errors->has('subject_name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('subject_name') }}</span>
                                @endif
                                <label class="form-label">Subject name</label>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Class</label>
                                <select name="subject_id" id="subject_id" class="form-control show-tick">
                                    <option value=""> dasda</option>
                                </select>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <br>

                        <a href="{{ route('dashboard') }}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

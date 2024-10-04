@extends('layouts.app')
@section('title', 'Add Class')
@section('description', 'Add your Class.')
@section('breadcrumb01', 'Class')
@section('breadcrumb02', 'Add Class')
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
                    <h2>Create New Class</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('class.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                                <label class="form-label">Class Name</label>
                            </div>
                        </div>

                        <br>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <h2 class="card-inside-title">Select Subject</h2>
                                <div class="demo-checkbox">
                                    {{-- @foreach ($subjects as $subject)
                                        <input type="checkbox" id="md_checkbox_{{ $subject->id }}" class="chk-col-red"/>
                                        <label for="md_checkbox_{{ $subject->id }}">{{ $subject->name }}</label>
                                    @endforeach --}}

                                    @foreach ($subjects as $subject)
                                        <input type="checkbox" name="subjects[]" id="md_checkbox_{{ $subject->id }}" class="chk-col-red" value="{{ $subject->id }}"/>
                                        <label for="md_checkbox_{{ $subject->id }}">{{ $subject->name }}</label>
                                    @endforeach
                                </div>

                                @if ($errors->has('subjects'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('subjects') }}</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <a href="{{ route('dashboard') }}" class="btn btn-raised btn-default waves-effect mr-2">Back</a>

                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

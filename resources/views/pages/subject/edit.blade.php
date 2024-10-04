@extends('layouts.app')
@section('title', 'Edit Subject')
@section('description', 'Edit Subject .')
@section('breadcrumb01', 'Subject')
@section('breadcrumb02', 'Edit Subject')
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
                    <h2>Edit Subject</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('subject.update', [$subject->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{@$subject->name}}"
                                    class="form-control" required placeholder="Section Name">
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
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

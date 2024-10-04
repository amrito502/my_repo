@extends('layouts.app')
@section('title', 'Student Edit')
@section('description', 'Student Edit')
@section('breadcrumb01', 'Student')
@section('breadcrumb02', 'Student Edit')
@section('app-content')

    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <!-- Input Group -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2> Student Edit </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false"> <i
                                    class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <form id="form_validation" action="{{route('student.update', $student->uuid)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="student_number" value="{{ $student->student_number }}" placeholder="Student ID" class="form-control" required>
                                        @if ($errors->has('student_number'))
                                          <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('student_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="first_name" value="{{ $student->first_name }}" placeholder="First name" class="form-control" required>
                                        @if ($errors->has('first_name'))
                                          <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="last_name" value="{{ $student->last_name }}" placeholder="Last name" class="form-control" required>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  name="gender" id="gender" class="form-control show-tick" required>
                                            <option value="">Select option</option>
                                            <option value="Boy" {{ $student->gender == 'Boy' ? 'selected' : '' }} >Boy</option>
                                            <option value="Girl" {{ $student->gender == 'Girl' ? 'selected' : '' }} >Girl</option>

                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" name="email" value="{{ $user->email }}" placeholder="Email" class="form-control" required>
                                        @if ($errors->has('email'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" name="password" value="{{old('password')}}" placeholder="Password" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="phone_number" value="{{ $user->phone_number }}" placeholder="SMS Phone number" class="form-control">
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('phone_number') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="gurdian_phone_number" value="{{ $student->gurdian_phone_number }}"
                                            placeholder="Gurdian Phone number" class="form-control" required>
                                        @if ($errors->has('gurdian_phone_number'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('gurdian_phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="address" value="{{ $user->address }}" placeholder="Address" class="form-control"
                                           required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('address') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->

                                        <select  name="class_id" id="class_id" class="form-control show-tick" required>
                                            <option value="{{$student->assign->studentClass->id}}">{{$student->assign->studentClass->name}}</option>
                                         @foreach($classes as $data)
                                          <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                         @endforeach
                                        </select>
                                         @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->
                                        <select  name="section_id" id="section_id" class="form-control show-tick" required>
                                            <option value="{{$student->assign->section->id}}">{{$student->assign->section->name}}</option>
                                            @foreach($sections as $data)
                                             <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                            @endforeach
                                           </select>
                                            @if ($errors->has('name'))
                                               <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                           @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->
                                        <select name="shift" id="shift" class="form-control show-tick" required>
                                            <option value="">Select Shift</option>
                                            <option value="Morning" {{ $student->assign->shift == 'Morning' ? 'selected' : '' }}>Morning
                                            </option>
                                            <option value="Day" {{ $student->assign->shift == 'Day' ? 'selected' : '' }}>Day
                                            </option>
                                        </select>
                                        @if ($errors->has('shift'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('shift') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <a href="{{route('student.index')}}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">Summit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input Group -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/custom/image-preview.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
    <script src="{{ asset('admin/js/custom/admin-profile.js') }}"></script>
@endpush

@extends('layouts.app')
@section('title', 'Teacher Edit')
@section('description', 'Teacher Edit')
@section('breadcrumb01', 'Teacher')
@section('breadcrumb02', 'Teacher Edit')
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
                    <h2> Teacher Edit </h2>
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
                    <form id="form_validation" action="{{route('instructor.update', $instructor->uuid)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="first_name" value="{{ $instructor->first_name }}" placeholder="First name" class="form-control" required>
                                        @if ($errors->has('first_name'))
                                          <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="last_name" value="{{ $instructor->last_name }}" placeholder="Last name" class="form-control" required>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->
                                            <select  name="gender" id="gender" class="form-control show-tick" required>
                                            <option value="">Select option</option>
                                            <option value="Male" {{ $instructor->gender == 'Male' ? 'selected' : '' }} >Male</option>
                                            <option value="Female" {{ $instructor->gender == 'Female' ? 'selected' : '' }} >Female</option>
                                            <option value="Others" {{ $instructor->gender == 'Others' ? 'selected' : '' }} >Others</option>
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
                                    <input type="text" name="professional_title" value="{{ $instructor->professional_title }}" placeholder="Designation" class="form-control"
                                           required>
                                    @if ($errors->has('professional_title'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('professional_title') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="phone_number" value="{{ $user->phone_number }}" placeholder="Phone number" class="form-control">
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('phone_number') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="address" value="{{ $instructor->address }}" placeholder="Address" class="form-control"
                                           required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('address') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                    <input type="text" name="postal_code" value="{{ $instructor->postal_code }}"  placeholder="Postal Code" class="form-control"
                                           required>
                                    @if ($errors->has('postal_code'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('postal_code') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  name="class_id" id="class_id" class="form-control show-tick" required>
                                            <option value="{{$user->assign->studentClass->id}}">{{$user->assign->studentClass->name}}</option>
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

                                        <select  name="section_id" id="section_id" class="form-control show-tick" required>
                                            <option value="{{$user->assign->section->id}}">{{$user->assign->section->name}}</option>
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

                        </div>
                        <br/>
                        <a href="{{route('dashboard')}}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit</button>
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

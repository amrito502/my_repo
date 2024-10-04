@extends('layouts.app')
@section('title', 'Add User')
@section('description', 'Add your own User to access the application.')
@section('breadcrumb01', 'User')
@section('breadcrumb02', 'Add User')
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
                    <h2>Create new user</h2>
                    {{-- <ul class="header-dropdown m-r--5">
                        <button class="btn btn-raised btn-success waves-effect" type="submit"></button>
                    </ul> --}}
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                                <label class="form-label">Name</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('email') }}</span>
                                @endif
                                <label class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                    class="form-control" required>
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('phone_number') }}</span>
                                @endif
                                <label class="form-label">Phone</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="address" id="address" value="{{ old('address') }}"
                                    class="form-control" required>
                                @if ($errors->has('address'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('address') }}</span>
                                @endif
                                <label class="form-label">Address</label>
                            </div>
                        </div>
               
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Role</label>
                                <select  name="role_name" id="role_name" class="form-control show-tick">
                                 @foreach($roles as $role)
                                  <option value="{{$role->name}}" {{old('role_name') == $role->name ? 'selected' : '' }}> {{$role->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('role_name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('role_name') }}</span>
                                @endif
                            </div>
                            
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" name="password" id="name" value="{{ old('password') }}"
                                    class="form-control" required>
                                @if ($errors->has('password'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('password') }}</span>
                                @endif
                                <label class="form-label">Password</label>
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

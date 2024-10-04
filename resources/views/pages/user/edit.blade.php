@extends('layouts.app')
@section('title', 'Edit User')
@section('description', 'Edit your own User to access the application.')
@section('breadcrumb01', 'User')
@section('breadcrumb02', 'Edit User')
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
                    <h2>Edit user</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{route('user.update', [$user->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{$user->name}}"
                                    class="form-control" placeholder="Name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                               
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="email" id="email" value="{{$user->email}}"
                                    class="form-control"  placeholder="Email" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="phone_number" id="phone_number" value="{{$user->phone_number}}"
                                    class="form-control"   placeholder="Phone" required>
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="address" id="address" value="{{$user->address}}"
                                    class="form-control"  placeholder="Address" required>
                                @if ($errors->has('address'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
               
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <label class="form-label">Select Role</label>
                                <select  name="role_name" id="role_name" class="form-control show-tick">
                                 @foreach($roles as $role)
                                    <option value="{{$role->name}}"  @if(count($user->getRoleNames()) > 0) {{$user->getRoleNames()[0] == $role->name ? 'selected' : '' }}@endif >{{$role->name}}</option>
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
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

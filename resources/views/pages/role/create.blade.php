@extends('layouts.app')
@section('title', 'Add Role')
@section('description', 'Add your own role to access the application.')
@section('breadcrumb01', 'Role')
@section('breadcrumb02', 'Add Role')
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
                    <h2>Role</h2>
                </div>
                <div class="body">
                    <form id="form_validation" action="{{ route('role.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('name') }}</span>
                                @endif
                                <label class="form-label">Role</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Select Permission</h5>
                        </div>
                        <div class="row text-black">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check mb-0 d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            id="permission{{ $permission->id }}" value="{{ $permission->id }}">
                                        <label class="form-check-label m-lg-1 mb-0 color-heading"
                                            for="permission{{ $permission->id }}">{{ ucwords(str_ireplace('_', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->has('permissions'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                {{ $errors->first('permissions') }}</span>
                        @endif
                        <a href="{{ route('role.index') }}" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@extends('layouts.app')
@section('title', 'Manage Role')
@section('description', 'Manage your role')
@section('breadcrumb01', 'Role')
@section('breadcrumb02', 'Manage role')

@section('app-content')

    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header header-flex">
                    <h2>Role List</h2>
                    @can('add_role')
                    <a href="{{ route('role.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                        Add Role</a>
                    @endcan
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Action</th </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $role->name }}</td>
                                    <td>
                                        <div class="action__buttons">
                                           @can('edit_role')
                                            <a href="{{ route('role.edit', [$role->id]) }}" class="btn-action">
                                                <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                            </a>
                                            @endcan
                                            @can('delete_role')
                                            <a class="btn-action delete" onclick="return confirm('Are you sure?')"
                                                href="{{ route('role.delete', $role->id) }}"> <img
                                                    src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash"></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
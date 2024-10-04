@extends('layouts.app')
@section('title', 'User List')
@section('description', 'User list')
@section('breadcrumb01', 'User')
@section('breadcrumb02', 'User list')
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
                    <h2>User List</h2>

                    @can('add_user')
                    <a href="{{ route('user.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                        Add User</a>
                    @endcan
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $user->name }}</td>
                                    <td> {{ $user->email }}</td>
                                    <td> {{ $user->address }}</td>
                                    <td> {{ $user->phone_number }}</td>
                                    <td>  @if(count($user->getRoleNames()) > 0) {{$user->getRoleNames()[0] }}@endif </td>
                                    <td>
                                        <div class="action__buttons">
                                        @can('edit_user')
                                            <a href="{{ route('user.edit', [$user->id]) }}" class="btn-action">
                                                <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                            </a>
                                        @endcan
                                        @can('delete_user')
                                            <a class="btn-action delete" onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('user.delete', $user->id) }}"> <img
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
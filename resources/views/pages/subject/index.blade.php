@extends('layouts.app')
@section('title', 'Subject List')
@section('description', 'Subject list')
@section('breadcrumb01', 'Subject')
@section('breadcrumb02', 'Subject list')
@section('app-content')

    @php
        $userRole = Auth::user()->role;
    @endphp
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
                    <h2>Subject List</h2>
                    @can('add_subject')
                    <a href="{{ route('subject.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                        Add Subject</a>
                    @endcan
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subject as $key => $data)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $data->name }}</td>
                                    <td>
                                        <div class="action__buttons">
                                            <a href="{{ route('subject.edit', [$data->id]) }}" class="badge badge-info mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @if( $userRole == '1')
                                                <a class="badge badge-danger delete" onclick="return confirm('Are you sure? You want to delete')"
                                                    href="{{ route('subject.delete', $data->id) }}"> <i class="fa fa-trash"></i> </a>
                                            @endif
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

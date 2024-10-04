@extends('layouts.app')
@section('title', 'Branch List')
@section('description', 'Branch list')
@section('breadcrumb01', 'Branch')
@section('breadcrumb02', 'Branch list')
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
                    <h2>Branch List</h2>
                    @if($userRole == '1')
                    <a href="{{ route('section.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                        Add Branch</a>
                    @endif
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch Name</th>
                                <th>Class Name</th>
                                @if($userRole == '1')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($section as $key => $data)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $data->name }}</td>
                                    <td> {{ $data->studentClassData->name }}</td>
                                    @if($userRole == '1')
                                    <td>
                                        <div class="action__buttons">

                                            <a href="{{ route('section.edit', [$data->id]) }}" class="badge badge-info mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>


                                            <a class="badge badge-danger delete" onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('section.delete', $data->id) }}"><i class="fa fa-trash"></i></a>

                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Assgin List')
@section('description', 'Assgin list')
@section('breadcrumb01', 'Assgin')
@section('breadcrumb02', 'Assgin list')
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
                    <h2>Assgin List</h2>
                    @can('add_attendance')
                        <a href="{{ route('assgin.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                            Add Assgin</a>
                    @endcan
                </div>
               
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th>Student</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $key=>$data)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$data->studentClass->name}}</td>
                                <td>{{$data->section->name}}</td>
                                <td>{{$data->subject->name}}</td>
                                <td>{{$data->students->first_name}} {{$data->students->last_name}}</td>
                                <td>
                                       {{-- @can('edit_student_assgin')
                                            <a href="{{ route('assgin.edit', [$data->uuid]) }}" class="btn-action">
                                                <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                            </a>
                                        @endcan --}}
                                        @can('delete_student_assgin')
                                            <a class="btn-action delete"
                                                onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('assgin.delete', $data->uuid) }}"> <img
                                                    src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash"></a>
                                        @endcan
                                  
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

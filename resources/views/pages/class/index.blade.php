@extends('layouts.app')
@section('title', 'Class List')
@section('description', 'Class List')
@section('breadcrumb01', 'Class')
@section('breadcrumb02', 'Class List')
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
                    <h2>Class List</h2>

                    @if($userRole == '1')
                    <a href="{{ route('class.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                        Add Class</a>
                    @endif
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Subjects</th>
                                @if($userRole == '1')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $key => $data)
                            @php
                                // $subjects = App\Models\Subject::where('id', $data->id)->get();
                                if ($data->subjects == null) {
                                    $getsubjects = [];
                                }else{
                                    $getsubjects = json_decode($data->subjects);
                                }

                            @endphp
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $data->name }}</td>
                                    <td>
                                        @foreach ($getsubjects as $subject)
                                            @if ($subject != null)
                                                @php
                                                    $subject = App\Models\Subject::where('id', $subject)->first();
                                                @endphp

                                                <span class="badge badge-primary">{{ $subject->name }}</span>
                                           @endif

                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="action__buttons">
                                            @if($userRole == '1')

                                                <a href="{{ route('class.edit', [$data->id]) }}" class="badge badge-info mr-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>


                                                <a class="badge badge-danger delete" onclick="return confirm('Are you sure? You want to delete')"
                                                    href="{{ route('class.delete', $data->id) }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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

@extends('layouts.app')
@section('title', 'Exam List')
@section('description', 'Exam list')
@section('breadcrumb01', 'Exam')
@section('breadcrumb02', 'Exam list')
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
                    <h2>Exam List</h2>
                    @if($userRole == '1')
                        <a href="{{ route('exam.create') }}" class="btn btn-success btn-sm ml-auto"><i class="zmdi zmdi-plus"></i>
                            Add Exam</a>
                    @endif
                </div>
                <div class="body table-responsive">
                    @if ( $exams->count() > 0 )
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam Name</th>
                                <th>Exam Date</th>
                                <th>Exam Marks</th>
                                <th>Teacher Name</th>
                                <th>Class</th>
                                <th style="width: 380px;">Subject List</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $key => $data)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> {{ $data->name }}</td>
                                    <td>
                                        @php
                                            $dateFormate = Carbon\Carbon::parse($data->start_date_time);
                                            echo $dateFormate->format('jS F Y');
                                        @endphp
                                    </td>
                                    <td class="text-center"><span class="badge badge-success badge-pill">{{ $data->max_marks }}</span></td>
                                    <td> {{$data->teacher->first_name}} {{$data->teacher->last_name}}</td>
                                    <td>
                                        @php
                                        $getClassbyID = App\Models\StudentClass::find($data->class_id);
                                        @endphp
                                        {{ $getClassbyID->name }}
                                    </td>
                                    <td>
                                        @php
                                            if ($data->subjects == null) {
                                                $getsubjects = [];
                                            }else{
                                                $getsubjects = json_decode($data->subjects);
                                            }
                                        @endphp

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

                                            <a href="{{ route('exam.view', [$data->uuid]) }}" class="badge badge-primary mr-2" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            @if($userRole == '1')
                                            <a href="{{ route('exam.edit', [$data->uuid]) }}" class="badge badge-info mr-2" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endif

                                            <a href="{{ route('exam.mark', [$data->uuid]) }}" class="badge badge-success mr-2" title="Mark">
                                                <i class="fa fa-check"></i>
                                            </a>

                                            @if($userRole == '1')
                                            <a class="badge badge-danger delete" onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('exam.delete', $data->uuid) }}" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endif

                                        </div>

                                        {{-- <div class="action__buttons">
                                            @can('edit_exam')
                                                <a href="{{ route('exam.view', [$data->uuid]) }}" class="btn-action">
                                                    <img src="{{ asset('admin/images/icons/eye-2.svg') }}" alt="edit">
                                                </a>
                                            @endcan

                                            @can('edit_exam')
                                                <a href="{{ route('exam.edit', [$data->uuid]) }}" class="btn-action">
                                                    <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                                </a>
                                            @endcan

                                            @can('delete_exam')
                                                <a class="btn-action delete"
                                                    onclick="return confirm('Are you sure? You want to delete')"
                                                    href="{{ route('exam.delete', $data->uuid) }}"> <img
                                                        src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash"></a>
                                            @endcan

                                            <a href="{{ route('exam.mark', [$data->uuid]) }}" class="btn-action">
                                                <img src="{{ asset('admin/images/icons/mail-2.svg') }}" alt="edit">
                                            </a>


                                        </div> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-warning text-center"> <i class="zmdi zmdi-alert-triangle"></i> No Data Found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

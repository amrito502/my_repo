@extends('layouts.app')
@section('title', 'Attendance List')
@section('description', 'Attendance List')
@section('breadcrumb01', 'Attendance')
@section('breadcrumb02', 'Attendance List')
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
                    <h2>Attendance List</h2>
                    @if ($attendences->count() >0)
                        @can('edit_attendance')
                            <a href="{{ route('attendance.edit',$attendences[0]->uuid) }}" class="btn btn-yellow btn-sm ml-auto"><i
                                    class="zmdi zmdi-edit"></i>
                                Edit Attendance </a>
                        @endcan
                        <a href="{{ route('attendance.all_sms',$attendences[0]->class_id) }}" class="btn btn-yellow btn-sm"><i
                            class="zmdi zmdi-sms"></i>
                        Send sms for all student </a>
                    @endif
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>date</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Teacher</th>
                                <th>Student</th>
                                <th>Attent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendences as $key=>$data)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$data->date}}</td>
                                <td>{{$data->studentClass->sections->name}}</td>
                                <td>{{$data->studentClass->name}}</td>
                                @if ($data->teachers !=null)
                                <td>{{$data->teachers->first_name}} {{$data->teachers->last_name}}</td>
                                @else
                                <td>N/L</td>
                                @endif
                                @if ($data->students !=null)
                                <td>{{$data->students->first_name}} {{$data->students->last_name}}</td>
                                @else
                                <td>N/L</td>
                                @endif
                                <td>
                                    @if($data->attent =='1')
                                        <button type="button" class="btn btn-success">Present</button>
                                    @endif
                                    @if($data->attent =='0')
                                        <button type="button" class="btn btn-danger">Absent</button>
                                           @php
                                                $current_date=\Carbon\Carbon::now()->format('d-m-Y');
                                           @endphp
                                        @if ($current_date ==$data->date)
                                         <a class="btn btn-yellow" href="{{ route('attendance.sms', [$data->uuid]) }}" class="btn-action">
                                            Send SMS
                                         </a>
                                        @endif
                                    @endif
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

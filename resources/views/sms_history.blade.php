

@extends('layouts.app')
@section('title', 'Show SMS History')
@section('description', 'Show All SMS History.')
@section('breadcrumb01', 'Show SMS History')
@section('breadcrumb02', 'Show SMS History')
@section('app-content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Show All SMS History</h2>
            </div>
            <div class="body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th style="width: 300px;">SMS</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $get_page = request()->get('page') ?: 1;
                            $i = ($get_page - 1) * 15 + 1;

                        @endphp
                        @foreach ($sms_history as $value)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $value->student_name }}</td>
                                <td>{{ $value->class_name }}</td>
                                <td>{{ $value->to }}</td>
                                <td>{{ $value->message }}</td>
                                <td>{{ $value->status_code == 200 ? 'Success' : 'Failed' }}</td>
                                <td>{{ $value->created_at }}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation">
                    {{ $sms_history->links('pagination::bootstrap-4') }}
                </nav>


            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Attendance')
@section('description', 'Edit Attendance')
@section('breadcrumb01', 'Attendance')
@section('breadcrumb02', 'Edit Attendance')
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between align-items-center">
                    <h2>Edit Attendance</h2>

                    <input type="text" id="search" style="width: 285px;" class="form-control mb-0 mr-3" placeholder="Search Student" name="search" value="">
                </div>

                <form id="form_validation" action="{{ route('attendance.update', ['6019f554-3dcf-4180-950a-a68266d47d2a']) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Roll No</th>
                                    <th>Class</th>
                                    <th>Branch</th>
                                    <th>Shift</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $key=>$item)
                                @if ($item->students !=null)
                                    <tr>
                                        <th scope="row">{{$key+1}}</th>
                                        <td>{{$item->students->first_name}} {{$item->students->last_name}}</td>
                                        <td>{{$item->students->id}}</td>
                                        <td>{{$item->studentClass->name }}</td>
                                        <td>{{$item->studentClass->sections->name}}</td>
                                        <td>{{$item->shift}}</td>
                                        <td>{{$item->students->gender}}</td>
                                        <td>
                                            <input type="hidden" name="date" value="{{$item->date}}">

                                            <div class="d-flex">
                                                <div class="form-check mb-0 d-flex align-items-center mr-2">
                                                    <input class="form-check-input attendence-checkbox" type="checkbox" name="attendence[{{ $item->student_id }}]" id="attendence{{ $item->id }}" value="{{ $item->student_id }}" data-row-id="{{ $key }}" {{ $item->attent == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label m-lg-1 mb-0 color-heading" for="attendence{{ $item->id }}" style="color: green">
                                                        Present
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0 d-flex align-items-center mr-2">
                                                    <input class="form-check-input attendence-absent-checkbox" type="checkbox" name="attendence_absent[{{ $item->student_id }}]" id="attendence_absent{{ $item->id }}" value="{{ $item->student_id }}" data-row-id="{{ $key }}" {{ $item->attent == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label m-lg-1 mb-0 color-heading" for="attendence_absent{{ $item->id }}" style="color: red">
                                                        Absent
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0 d-flex align-items-center">
                                                    <input class="form-check-input attendence-absent-checkbox" type="checkbox" name="attendence_delay[{{ $item->student_id }}]" id="attendence_delay{{ $item->id }}" value="{{ $item->student_id }}" data-row-id="{{ $key }}" {{ $item->attent == 2 ? 'checked' : '' }} >
                                                    <label class="form-check-label m-lg-1 mb-0 color-heading" for="attendence_delay{{ $item->id }}" style="color: rgb(158, 108, 0)">
                                                        Delay
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('attendance.index') }}" class="btn btn-raised mr-2 btn-default waves-effect">Back</a>

                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('.table tbody tr');

            searchInput.addEventListener('input', function () {
                const searchQuery = this.value.trim().toLowerCase();

                tableRows.forEach(function (row) {
                    let isMatch = false;

                    row.querySelectorAll('td').forEach(function (cell) {
                        const cellData = cell.textContent.trim().toLowerCase();
                        if (cellData.includes(searchQuery)) {
                            isMatch = true;
                        }
                    });

                    if (isMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.attendence-checkbox, .attendence-absent-checkbox, .attendence-delay-checkbox').change(function () {
                var rowId = $(this).data('row-id');
                $('.attendence-checkbox[data-row-id="' + rowId + '"]').not(this).prop('checked', false);
                $('.attendence-absent-checkbox[data-row-id="' + rowId + '"]').not(this).prop('checked', false);
                $('.attendence-delay-checkbox[data-row-id="' + rowId + '"]').not(this).prop('checked', false);
            });
        });
    </script>
@endsection

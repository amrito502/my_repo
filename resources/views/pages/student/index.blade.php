@extends('layouts.app')
@section('title', 'Student List')
@section('description', 'Student list')
@section('breadcrumb01', 'Student')
@section('breadcrumb02', 'Student list')
@section('app-content')

@php
    $userRole = Auth::user()->role;
    $class_id = request()->get('class_id') ?: 1;
    $section_id = request()->get('section_id') ?: 1;
    $search = request()->get('search') ?: '';
    $get_shift = request()->get('shift') ?: 'Day';
    $gender = request()->get('gender') ?: 'Boy';
@endphp
<style>
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    body #SearchForm {
        display: flex;
        flex-direction: row;
        align-items: end;
    }
</style>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        {{-- @php
        echo '
        <pre>';
                print_r($classes);
                echo '</pre>';

        foreach ($classes as $key => $value) {
        echo $value->name . '<br>';
        echo $value->id . '<br>';
        }
        @endphp --}}
        <div class="card">
            <div class="header ">
                <div class="top d-flex justify-content-between align-items-center">
                    <h2>Student List</h2>


                    <div class="add_upload_student">
                        <a href="{{ route('student.csv.upload') }}" class="btn btn-primary btn-sm ml-auto">
                            <i class="zmdi zmdi-plus"></i> CSV File Upload
                        </a>
                        <a href="{{ route('student.create') }}" class="btn btn-success btn-sm ml-auto">
                            <i class="zmdi zmdi-plus"></i> Add Student
                        </a>
                    </div>



                </div>

                <form id="SearchForm" method="get" action="{{ route('student.index') }}">
                    @csrf

                    <input type="text" id="search" style="width: 285px;" class="form-control mb-0 mr-3"
                        placeholder="Search Student" name="search" value="{{ $search }}">

                    <select name="class_id" id="class_id" class="form-control show-tick mr-3">
                        @foreach ($classes as $class)
                            <option value="{{ $class->id}}" {{ $class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    <select id="section_id" name="section_id" class="form-control show-tick mr-3">
                        @foreach ($sections as $section)
                            <option value="{{ $section->id ? $section->id : 1 }}" {{ $section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    <select name="shift" id="shift" class="form-control show-tick mr-3">
                        <option value="Day" {{ $get_shift == 'Day' ? 'selected' : '' }}>Day</option>
                        <option value="Morning" {{ $get_shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                    </select>

                    <select name="gender" id="gender" class="form-control show-tick mr-3">
                        <option value="Boy" {{ $gender == 'Boy' ? 'selected' : '' }}>Boy</option>
                        <option value="Girl" {{ $gender == 'Girl' ? 'selected' : '' }}>Girl</option>
                    </select>

                    <button type="submit" class="btn btn-info btn-sm ml-auto"> <i class="zmdi zmdi-filter-list"></i>
                        FILTER</button>
                </form>

            </div>
            <div class="body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            {{-- <th width="120px">Address</th> --}}
                            <th>Phone</th>
                            <th>Class</th>
                            <th>Branch</th>
                            <th>Shift</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $key => $users)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $users->student_number }}</td>
                                <td> {{ $users->first_name }} {{ $users->last_name }}</td>
                                <td> {{ $users->user->email }}</td>
                                {{-- <td> {{ $users->address == null ? 'N/L' : $users->address }}</td> --}}
                                <td> {{ $users->phone_number }}</td>
                                <td> {{ $users->assign->studentClass->name }}</td>
                                <td> {{ $users->assign->section->name }}</td>
                                <td>{{ $users->assign->shift }}</td>
                                <td> {{ $users->gender }}</td>
                                <td>
                                    <div class="action__buttons">
                                        <a href="{{ route('student.edit', [$users->uuid]) }}" class="badge badge-info mr-2"
                                            title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        @if($userRole == '1')
                                            <a class="badge badge-danger delete mr-2"
                                                onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('student.delete', $users->uuid) }}" title="Delete">

                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('student.view', [$users->uuid]) }}" class="badge badge-success"
                                            title="View">
                                            <i class="zmdi zmdi-eye"></i>
                                        </a>
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

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap and Bootstrap-select if not already included -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        var selectedClassID = <?php echo $class_id; ?>;

        // Function to fetch sections based on class ID
        function fetchSections(classId) {
            $.ajax({
                url: '{{ url("/get-sections-by-class") }}/' + classId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    updateSectionOptions(data);
                },
                error: function () {
                    console.error('Failed to fetch sections.');
                }
            });
        }

        // Function to update section options
        function updateSectionOptions(data) {
            $('#section_id').empty();

            $.each(data, function (key, value) {
                $('#section_id').append('<option value="' + key + '">' + value + '</option>');
            });

            $('#section_id').selectpicker('refresh');
        }

        // Initial fetch if a class ID is selected
        if (selectedClassID) {
            $('#class_id').val(selectedClassID);
            fetchSections(selectedClassID);
        } else {
            updateSectionOptions([]);
        }

        // Event listener for class ID change
        $('#class_id').change(function () {
            var classId = $(this).val();

            if (classId) {
                fetchSections(classId);
            } else {
                updateSectionOptions([]);
            }
        });
    });
</script>
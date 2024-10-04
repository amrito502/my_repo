@extends('layouts.app')
@section('title', 'Teacher List')
@section('description', 'Teacher list')
@section('breadcrumb01', 'Teacher')
@section('breadcrumb02', 'Teacher list')
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
                    <h2>Teacher List</h2>
                    <a href="{{ route('instructor.create') }}" class="btn btn-success btn-sm ml-auto"><i
                            class="zmdi zmdi-plus"></i>
                        Teacher Add</a>
                </div>
                <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">asdas</th>
                                <td>dasdas</td>
                                <td>dsadas</td>
                                <td>dsad</td>
                                <td>dasdas</td>
                                <td>dasdas</td>
                                <td>dsadas</td>
                                <td>dasdas</td>
                                <td>
                                    <div class="action__buttons">
                                        <a href="#" class="btn-action">
                                            <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                        </a>
                                        <a class="btn-action delete"
                                            onclick="return confirm('Are you sure? You want to delete')" href="#">
                                            <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash"></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection











{{--  <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__('app.instructors')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('app.dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('app.all_instructors')}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between">
                            <h2>{{__('app.all_instructors')}}</h2>
                        </div>
                        <div class="customers__table">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{__('app.image')}}</th>
                                    <th>{{__('app.name')}}</th>
                                    <th>{{__('app.phone_number')}}</th>
                                    <th>{{__('app.country')}}</th>
                                    <th>{{__('app.state')}}</th>
                                    <th>{{__('app.status')}}</th>
                                    <th class="text-center">{{__('app.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($instructors as $instructor)
                                    <tr class="removable-item">
                                        <td>
                                            <a href="{{route('instructor.view', [$instructor->uuid])}}"> <img src="{{getImageFile($instructor->user ? $instructor->user->image_path : '')}}" width="80"> </a>
                                        </td>
                                        <td>
                                            {{$instructor->name}}
                                        </td>

                                        <td>
                                            {{$instructor->phone_number}}
                                        </td>
                                        <td>
                                            {{$instructor->country ? $instructor->country->country_name : '' }}
                                        </td>
                                        <td>
                                            {{$instructor->state ? $instructor->state->name : '' }}
                                        </td>
                                        <td>
                                            <span id="hidden_id" style="display: none">{{$instructor->id}}</span>
                                            <select name="status" class="status label-inline font-weight-bolder mb-1 badge badge-info">
                                                <option value="1" @if ($instructor->status == 1) selected @endif>Approved</option>
                                                <option value="2" @if ($instructor->status == 2) selected @endif>Blocked</option>
                                                <option value="0" @if ($instructor->status == 0) selected @endif>Pending</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="action__buttons">
                                                <a href="{{route('instructor.view', [$instructor->uuid])}}" class="btn-action mr-30" title="View Details">
                                                    <img src="{{asset('admin/images/icons/eye-2.svg')}}" alt="eye">
                                                </a>
                                                <a href="{{route('instructor.edit', [$instructor->uuid])}}" class="btn-action mr-30" title="Edit Details">
                                                    <img src="{{asset('admin/images/icons/edit-2.svg')}}" alt="edit">
                                                </a>
                                                <a href="javascript:void(0);" data-url="{{route('instructor.delete', [$instructor->uuid])}}" title="Delete" class="btn-action delete">
                                                    <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$instructors->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->
@endsection  --}}

{{--  @push('style')
    <link rel="stylesheet" href="{{asset('admin/css/jquery.dataTables.min.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/data-table-page.js')}}"></script>
    <script>
        'use strict'
        $(".status").change(function () {
            var id = $(this).closest('tr').find('#hidden_id').html();
            var status_value = $(this).closest('tr').find('.status option:selected').val();
            Swal.fire({
                title: "Are you sure to change status?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Change it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.instructor.changeInstructorStatus')}}",
                        data: {"status": status_value, "id": id, "_token": "{{ csrf_token() }}",},
                        datatype: "json",
                        success: function (data) {
                            toastr.options.positionClass = 'toast-bottom-right';
                            toastr.success('', 'Instructor status has been updated');
                        },
                        error: function () {
                            alert("Error!");
                        },
                    });
                } else if (result.dismiss === "cancel") {
                }
            });
        });
    </script>
@endpush  --}}

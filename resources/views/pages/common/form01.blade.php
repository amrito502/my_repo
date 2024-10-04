@extends('layouts.app')
@section('title', 'Teacher Add')
@section('description', 'Teacher Add')
@section('breadcrumb01', 'Teacher')
@section('breadcrumb02', 'Teacher Add')
@section('app-content')

    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <!-- Input Group -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2> Teacher Add </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false"> <i
                                    class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <form id="form_validation" method="POST" action="{{ route('instructor.store') }}">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="First name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Last name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Professional Title" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Address" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Phone number" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Postal code" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="http://127.0.0.1:8000/dashboard" class="btn btn-raised btn-default waves-effect">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input Group -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/custom/image-preview.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
    <script src="{{ asset('admin/js/custom/admin-profile.js') }}"></script>
@endpush

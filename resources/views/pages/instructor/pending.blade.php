@extends('layouts.admin')

@section('content')
    <!-- Page content area start -->
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
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('app.dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('app.pending_instructor')}}</li>
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
                            <h2>{{__('app.pending_instructor')}}</h2>
                        </div>
                        <div class="customers__table">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{__('app.image')}}</th>
                                    <th>{{__('app.name')}}</th>
                                    <th>{{__('app.professional_title')}}</th>
                                    <th>{{__('app.phone_number')}}</th>
                                    <th>{{__('app.address')}}</th>
                                    <th>CV</th>
                                    <th class="text-center">{{__('app.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($instructors as $instructor)
                                    <tr class="removable-item">
                                        <td>
                                            <a href="{{route('instructor.view', [$instructor->uuid])}}"> <img src="{{getImageFile($instructor->user ? $instructor->user->image_path : '')}}" width="80"> </a>
                                        </td>
                                        <td>
                                            {{$instructor->name}}
                                        </td>
                                        <td>
                                            {{$instructor->professional_title}}
                                        </td>

                                        <td>
                                           {{$instructor->phone_number}}
                                        </td>
                                        <td>
                                            {{$instructor->address }}
                                        </td>
                                        <td><span><a href="{{ getVideoFile($instructor->cv_file) }}" target="_blank">{{ $instructor->cv_filename }}</a></span></td>

                                        <td>
                                            <div class="action__buttons">
                                                <a href="{{route('instructor.status-change', [$instructor->uuid, 1])}}" class="btn-action approve-btn mr-30 p-1" title="Make as approve">
                                                    {{__('app.approve')}}
                                                </a>
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
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/jquery.dataTables.min.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/data-table-page.js')}}"></script>
@endpush

@extends('layouts.app')
@section('title', 'Student Mark')
@section('description', 'Student Mark')
@section('breadcrumb01', 'Student')
@section('breadcrumb02', 'Student Mark')
@section('app-content')
    <!-- Page content area start -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Student Mark</h2>
                    {{-- <ul class="header-dropdown m-r--5">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false"> <i
                                    class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Print Invoices</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="javascript:void(0);">Export to XLS</a></li>
                                <li><a href="javascript:void(0);">Export to CSV</a></li>
                                <li><a href="javascript:void(0);">Export to XML</a></li>
                            </ul>
                        </li>
                    </ul> --}}
                </div>
                <div class="body">
                    {{-- <div class="row clearfix">
                        <div class="col-md-12">
                            <img src="https://i.postimg.cc/fTHLwhR9/logo.jpg" width="70" alt="School Logo">
                            <h4 class="float-md-right">Exam Type# <strong>2024</strong></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <address>
                                <strong>Unmukto School</strong><br>
                                795 Folsom Ave, Suite 546<br>
                                San Francisco, CA 54656<br>
                                <abbr title="Phone">P:</abbr> (123) 456-34636
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-6 text-right">
                            <p><strong>Publish Date: </strong> Feb 15, 2018</p>
                            <p class="m-t-10"><strong>Result ID: </strong> #123456</p>
                        </div>
                    </div> --}}
                    <div class="mt-40"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                @if( $exam_marks->count() > 0 )
                                <table id="mainTable" class="table table-striped" style="cursor: pointer;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Exam Name</th>
                                            <th>Subject</th>
                                            <th>Fianl Mark</th>

                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($exam_marks as $key=>$item)

                                        @endforeach
                                        @if (!empty($item->exam))
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->exam->name}}</td>
                                            <td>{{$item->exam->subjects->name}}</td>
                                            <td>{{ doubleval($item->mark) }}</td>

                                        </tr>

                                        @endif


                                    </tbody>
                                </table>
                                @else
                                    <div class="alert alert-info text-center"> <i class="fa fa-info-circle"></i> No result published yet</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>

                    {{-- <div class="hidden-print col-md-12 text-right">
                        <a href="javascript:void(0);" class="btn btn-raised btn-success"><i class="zmdi zmdi-print"></i></a>
                        <a href="javascript:void(0);" class="btn btn-raised btn-default">Submit</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@extends('layouts.app')
@section('title', 'Dashboard')
@section('description', 'Dashboard')
@section('breadcrumb01', 'Dashboard')
@section('breadcrumb02', 'Dashboard')
@section('app-content')
    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>


        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card tasks_report">
                        <div class="body">
                            <input type="text" class="knob dial1" value="66" data-width="90" data-height="90" data-thickness="0.2" data-fgColor="#00ced1" readonly>
                            <h6 class="m-t-20">Satisfaction Rate</h6>
                            <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                            <div class="sparkline m-t-30" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#00ced1">5,8,3,4,8,9,7,2,9,5</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card tasks_report">
                        <div class="body">
                            <input type="text" class="knob dial2" value="26" data-width="90" data-height="90" data-thickness="0.2" data-fgColor="#ffa07a" readonly>
                            <h6 class="m-t-20">Orders Panding</h6>
                            <small class="displayblock">13% Average <i class="zmdi zmdi-trending-down"></i></small>
                            <div class="sparkline m-t-30" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#ffa07a">9,5,1,5,4,8,7,6,3,4</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card tasks_report">
                        <div class="body">
                            <input type="text" class="knob dial3" value="76" data-width="90" data-height="90" data-thickness="0.2" data-fgColor="#8fbc8f" readonly>
                            <h6 class="m-t-20">Productivity Goal</h6>
                            <small class="displayblock">75% Average <i class="zmdi zmdi-trending-up"></i></small>
                            <div class="sparkline m-t-30" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#8fbc8f">6,4,9,8,6,5,4,5,3,2</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card tasks_report">
                        <div class="body">
                            <input type="text" class="knob dial4" value="88" data-width="90" data-height="90" data-thickness="0.2" data-fgColor="#00adef" readonly>
                            <h6 class="m-t-20">Total Revenue</h6>
                            <small class="displayblock">54% Average <i class="zmdi zmdi-trending-up"></i></small>
                            <div class="sparkline m-t-30" data-type="bar" data-width="97%" data-height="30px" data-bar-Width="2" data-bar-Spacing="5" data-bar-Color="#00adef">3,5,7,9,5,1,4,5,6,8</div>
                        </div>
                    </div>
                </div>
        </div>

        {{-- <div class="row clearfix">
            <div class="col-lg-9 col-md-8">
                <div class="card product-report">
                    <div class="header">
                        <h2>Annual Report <small>Description text here...</small></h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix m-b-15">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="icon l-amber"><i class="zmdi zmdi-chart-donut"></i></div>
                                <div class="col-in">
                                    <h4 class="counter m-b-0">$4,516</h4>
                                    <small class="text-muted m-t-0">Sales Report</small>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="icon l-turquoise"><i class="zmdi zmdi-chart"></i></div>
                                <div class="col-in">
                                    <h4 class="counter m-b-0">$6,481</h4>
                                    <small class="text-muted m-t-0">Annual Revenue </small>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="icon l-parpl"><i class="zmdi zmdi-card"></i></div>
                                <div class="col-in">
                                    <h4 class="counter m-b-0">$3,915</h4>
                                    <small class="text-muted m-t-0">Total Profit</small>
                                </div>
                            </div>
                        </div>
                        <div id="area_chart" class="graph"></div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-4">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="card top-report">
                            <div class="body">
                                <h3 class="m-t-0">50.5 Gb <i class="zmdi zmdi-trending-up float-right"></i></h3>
                                <p class="text-muted">Traffic this month</p>
                                <div class="progress">
                                    <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                                </div>
                                <small>Change 5%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


@endsection

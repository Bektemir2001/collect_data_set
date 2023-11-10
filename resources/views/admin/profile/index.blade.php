@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Line Chart</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="apex-basic"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title"> Pie Charts</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div id="apex-pie-chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

{{--    contexts--}}

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">My contexts</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#datatable-1" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </i>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <div class="mb-4 mt-4">
                            <a href="{{route('context.create')}}" class="btn btn-success">add</a>
                        </div>
                        <table id="datatable-1" class="table data-table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>title</th>
                                <th>context</th>
                                <th>question count</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </thead>
                            <tbody id="tableId">
                            @foreach($contexts as $context)
                                <tr>
                                    <td>{{$context->id}}</td>
                                    <td>{{$context->title}}</td>
                                    <td>{{ strip_tags(Str::limit($context->context, 150))}}</td>
                                    <td>{{count($context->questions)}}</td>
                                    <td>
                                        <a href="{{route('context.show', $context->id)}}" class="btn btn-primary">show</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>title</th>
                                <th>context</th>
                                <th>question count</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </tfoot>
                        </table>
                        @include('includes.context_pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('charts')
    @include('includes.profile.line_chart')
    @include('includes.profile.pie_chart')
@endsection

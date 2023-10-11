@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Contexts</h4>
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
                        <form action="{{route('upload.csv')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="display: flex">
                                <input class="form-control" name="csv_file" type="file" style="width: 60%;" accept=".csv"/>
                                <button type="submit" class="btn btn-primary">upload csv</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Urls</h4>
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
                                <th>url count</th>
                                <th>host name</th>
                                <th>status list</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </thead>
                            <tbody id="tableId">
                            @foreach($urls as $url)
                                <tr>
                                    <td>{{$url->url_count}}</td>
                                    <td>{{$url->host_name}}</td>
                                    <td>
                                        @if($url->list_name == null)
                                            not checked
                                        @else
                                            {{$url->list_name}}
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('crawl.show')}}" method="POST">
                                            @csrf
                                            <input name="host_name" value="{{$url->host_name}}" style="display: none;">
                                            <button type="submit" class="btn btn-primary">show</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>url count</th>
                                <th>host name</th>
                                <th>status list</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Translated Contexts</h4>
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
                        @include('includes.question_csv_export')
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
                                    <td>{!! Str::limit($context->context, 150)!!}</td>
                                    <td>{{count($context->questions)}}</td>
                                    <td>
                                        <a href="{{route('context.translate.show', $context->id)}}" class="btn btn-primary">show</a>
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
                        <form action="{{route('context.translate.upload_csv')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="csv_file">CSV</label>
                                <input class="form-control" id="csv_file" name="csv_file" type="file" style="width: 60%;"/>
                            </div>
                            <div class="form-group">
                                <label for="source_lang">Source Language</label>
                                <select id="source_lang" name="source_lang" class="form-control">
                                    <option value="EN">EN</option>
                                    <option value="RU">RU</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">upload csv to translate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


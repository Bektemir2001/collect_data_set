@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                        <div class="header-title" style="display: flex">
                            <h4 class="card-title">Line Chart</h4>
                            <div>
                                <button onclick="previous_Day()" class="border-0 bg-transparent">
                                    <i class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" style="width: 35px; height: 30px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z" />
                                        </svg>
                                    </i>
                                </button>
                            </div>
                            <div>
                                <button onclick="next_Day()" class="border-0 bg-transparent">
                                    <i class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" style="width: 35px; height: 30px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z" />
                                        </svg>
                                    </i>
                                </button>
                            </div>
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
                    <div class="row">
                        <div class="header-title">
                            <h4 class="card-title"> Pie Charts</h4>
                        </div>
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">My questions</h4>
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
                        <table id="datatable-2" class="table data-table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>question</th>
                                <th>answer</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </thead>
                            <tbody id="tableId">
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{$question->id}}</td>
                                    <td>{{$question->question}}</td>
                                    <td>{{ $question->answer}}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary">show</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>question</th>
                                <th>answer</th>
                                <th class="text-right">actions</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Create Question</h4>
            </div>
            <div class="header-action">
                <i data-toggle="collapse" data-target="#form-element-6" aria-expanded="false" class="collapsed">
                    <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="card-body">
            <div class="collapse" id="form-element-6" style="">
            </div>
            <form action="{{route('question.manual.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" class="form-control" id="question" placeholder="Enter Question" name="question" required autofocus>
                    @error('question')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" class="form-control" id="answer" placeholder="Enter Answer" name="answer" required autofocus>
                    @error('answer')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
@endsection
@section('charts')
    @include('includes.profile.line_chart')
    @include('includes.profile.pie_chart')
@endsection

@extends('layout.admin')
@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Past generated questions</h4>
                </div>
                <div class="header-action">
                    <i data-toggle="collapse" data-target="#form-quill-1" aria-expanded="false">
                        <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </i>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <form action="{{route('failed.context.save.question')}}" method="POST">
                        @csrf
                        <textarea style="width: 100%; height: 300px;" class="form-control" name="text">{{$context->error}}</textarea>
                        <input class="form-control" value="{{$context->id}}" name="failed_context_id">
                        <input class="form-control" value="{{$context->context_id}}" name="context_id">
                        <button type="submit" class="btn btn-primary mb-4 mt-4">Submit</button>
                        <a href="{{route('failed.context.delete', $context->id)}}" class="btn btn-primary mb-4 mt-4">Delete</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

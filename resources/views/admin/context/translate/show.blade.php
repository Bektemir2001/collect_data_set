@extends('layout.admin')
@section('content')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#context',  // Задайте селектор для элемента, в котором вы хотите использовать редактор
            plugins: 'autolink lists link image charmap print preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
        tinymce.init({
            selector: '#original_context',  // Задайте селектор для элемента, в котором вы хотите использовать редактор
            plugins: 'autolink lists link image charmap print preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
    </script>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Translated Context</h4>
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
            <form action="{{route('context.update', $context->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="original_title">Original Title</label>
                    <input type="text" class="form-control" id="original_title" value="{{$context->original_title}}">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" value="{{$context->title}}" name="title" required autofocus>
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="original_context">Original Context</label>
                    <textarea id="original_context">{!! $context->original_context !!}</textarea>
                </div>
                <div class="form-group">
                    <label for="context">Context</label>
                    <textarea id="context" name="context">{!! $context->context !!}</textarea>
                    @error('context')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-4 mt-4" style="margin-left: 60%">
                    @if($previous_context)
                        <a type="submit" href="{{route('context.translate.index', $previous_context)}}" class="btn bg-danger">Previous</a>
                    @endif

                    <button type="submit" class="btn btn-primary mr-2">Save changes</button>

                    @if($next_context)
                        <a type="submit" href="{{route('context.translate.show', $next_context)}}" class="btn bg-success">Next</a>
                    @endif



                </div>

            </form>
            @include('includes.question_generate')
        </div>
    </div>
@endsection

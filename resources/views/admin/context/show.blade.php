@extends('layout.admin')
@section('content')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#context',  // Задайте селектор для элемента, в котором вы хотите использовать редактор
            plugins: 'autolink lists link image charmap print preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
    </script>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Context</h4>
            </div>
            <div class="header-action">
                <a class="btn btn-outline-success rounded-pill mt-2 btn-with-icon" href="{{route('context.create')}}">add new context</a>
            </div>
        </div>
        <div class="card-body">
            <div class="collapse" id="form-element-6" style="">
            </div>
            <form action="{{route('context.update', $context->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" value="{{$context->title}}" name="title" required autofocus>
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
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
                        <a type="submit" href="{{route('context.index', $previous_context)}}" class="btn bg-danger">Previous</a>
                    @endif

                        <button type="submit" class="btn btn-primary mr-2">Save changes</button>

                    @if($next_context)
                            <a type="submit" href="{{route('context.show', $next_context)}}" class="btn bg-success">Next</a>
                    @endif



                </div>

            </form>
            @include('includes.question_generate')
        </div>
    </div>
@endsection

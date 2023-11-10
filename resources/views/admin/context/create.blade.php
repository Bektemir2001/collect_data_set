@extends('layout.admin')
@section('content')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',  // Задайте селектор для элемента, в котором вы хотите использовать редактор
            plugins: 'autolink lists link image charmap print preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
    </script>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Create Context</h4>
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
            <form action="{{route('context.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required autofocus>
                    @error('title')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="context">Context</label>
                    <textarea id="context" name="context"></textarea>
                    @error('context')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="submit" class="btn bg-danger">Cancel</button>
            </form>
        </div>
    </div>
@endsection

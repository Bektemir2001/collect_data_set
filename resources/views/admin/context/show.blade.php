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
                        <a type="submit" href="{{route('context.show', $previous_context)}}" class="btn bg-danger">Previous</a>
                    @endif

                        <button type="submit" class="btn btn-primary mr-2">Save changes</button>

                    @if($next_context)
                            <a type="submit" href="{{route('context.show', $next_context)}}" class="btn bg-success">Next</a>
                    @endif
                        <button type="button" id="copyButton" data-clipboard-target="#textToCopy" class="btn btn-secondary">Copy Text</button>


                </div>
                <div id="textToCopy" style="display: none">{{"Generate questions as much as possible and detailed answers based on the following text in Kyrgyz language return 'Question:' 'Answer:'"}} <div>{{$context->title != null ? $context->title."." : ""}}</div> {!!$context->context !!}</div>

            </form>
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
                            <form action="{{route('question.save.generated', $context->id)}}" method="POST">
                                @csrf
                                <textarea style="width: 100%; height: 300px;" class="form-control" name="generated_questions"></textarea>
                                <button type="submit" class="btn btn-primary mb-4 mt-4">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('includes.question_generate')
        </div>
    </div>
    <script>
        document.getElementById('copyButton').addEventListener('click', function () {
            let textToCopy = document.getElementById('textToCopy');
            let inputElement = document.createElement('input');
            inputElement.value = textToCopy.textContent;
            document.body.appendChild(inputElement);
            inputElement.select();

            document.execCommand('copy');
            document.body.removeChild(inputElement);

            let className = document.getElementById('copyButton').className;
            if(className === 'btn btn-secondary')
            {
                document.getElementById('copyButton').className = 'btn btn-primary'
            }
            else{
                document.getElementById('copyButton').className = 'btn btn-secondary'
            }

        });
    </script>
@endsection

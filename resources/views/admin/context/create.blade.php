@extends('layout.admin')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Add Page</h4>
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
                    <textarea class="form-control" id="context" name="context" required autofocus></textarea>
                    @error('context')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="auto_generate_questions">Auto generate questions</label>
                    <select id="auto_generate_questions" name="auto_generate_questions" class="form-control">
                        <option value="0">NO</option>
                        <option value="1">YES</option>
                    </select>
                    @error('auto_generate_questions')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="submit" class="btn bg-danger">Cancel</button>
            </form>
        </div>
    </div>
@endsection

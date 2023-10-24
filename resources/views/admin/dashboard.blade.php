@extends('layout.admin')
@section('content')

    <form action="{{route('indexing')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">CSV</label>
            <input class="form-control" id="csv_file" name="csv_file" type="file" style="width: 60%;"/>
        </div>
        <button type="submit" class="btn btn-primary">upload csv to indexing</button>
    </form>

@endsection

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

    <div class="row md-4 mt-4">
        @foreach($questions as $question)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-2 text-secondary">{{$question->type}}</p>
                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                    <h5 class="mb-0 font-weight-bold">{{$question->question_count}}</h5>
                                    <p class="mb-0 ml-3 text-success font-weight-bold">{{round(($question->question_count / $total_count) * 100, 2)}}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

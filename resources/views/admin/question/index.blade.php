@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Csv Upload</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#form-validation-3" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </i>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.question.upload.csv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="source_lang">Language</label>
                                <select name="source_lang" id="source_lang" class="form-control">
                                    <option>KG</option>
                                    <option value="RU">RU</option>
                                    <option value="EN">EN</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="csv_file">Csv file</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" required="">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Csv Export</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#form-validation-3" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </i>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.question.export.csv')}}" method="POST">
                        @csrf
                        <div class="form-group col-6 mb-4 mt-4">
                            <label for="types">Types</label>
                            <select class="custom-select form-control col-12 choicesjs" id="types"
                                    name="types[]" multiple>
                                <option value="squad">squad</option>
                                <option value="translated_mistral">translated_mistral</option>
                                <option value="gpt-4">gpt-4</option>
                                <option value="gpt-4">gpt-3</option>
                                <option value="manual">manual</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Generate Question</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#form-validation-3" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </i>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('gpt4.question.default.generate')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="context_start">Context start id</label>
                                <input type="number" class="form-control" id="context_start" name="context_start" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="context_end">Context end id</label>
                                <input type="number" class="form-control" id="context_end" name="context_end" required="">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Start generating</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


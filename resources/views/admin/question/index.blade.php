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
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
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
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </i>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.question.export.csv')}}" method="POST">
                        @csrf
                        <div class="form-row mb-4 mt-4">
                            <div class="choices" data-type="select-multiple" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" dir="ltr">
                                <div class="choices__inner">
                                    <label for="types">Types</label>
                                    <select class="custom-select form-control choicesjs choices__input is-hidden" multiple="" tabindex="-1" aria-hidden="true" data-choice="active" id="types" name="types[]">
                                        <option value="squad">squad</option>
                                        <option value="translated_mistral">translated_mistral</option>
                                        <option value="gpt-4">gpt-4</option>
                                    </select>
                                    <div class="choices__list choices__list--multiple"></div>
                                    <input type="text" class="choices__input choices__input--cloned" autocomplete="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" aria-label="null" aria-activedescendant="choices--blp0-item-choice-1" style="width: 900px; height: 100px;">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


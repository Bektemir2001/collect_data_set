<div class="card">
    <form action="{{route('export.questions')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: flex">
            <select class="form-control" id="limit" name="limit" style="width: 30%">
                <option value="1000">1000 row</option>
                <option value="10000">10000 row</option>
                <option value="100000">100000 row</option>
                <option value="1000000">1000000 row</option>
            </select>
            <button type="submit" class="btn btn-primary">Export questions(csv)</button>
        </div>
    </form>
    <button></button>
    <div class="mb-4 mt-4"></div>

    <form action="{{route('export.questions.for.lama')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: flex">
            <select class="form-control" id="limit" name="limit" style="width: 30%">
                <option value="1000">1000 row</option>
                <option value="10000">10000 row</option>
                <option value="100000">100000 row</option>
                <option value="1000000">1000000 row</option>
            </select>
            <button type="submit" class="btn btn-primary">Export questions(csv) for Llama</button>
        </div>
    </form>
    <button></button>
</div>

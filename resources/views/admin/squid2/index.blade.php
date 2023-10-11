@extends('layout.admin')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Bootstrap Datatables</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#datatable-1" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-1" class="table data-table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>NUM</th>
                                <th>ORIGINAL</th>
                                <th class="text-right">Translate</th>
                            </tr>
                            </thead>
                            <tbody id="tableId">

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>NUM</th>
                                <th>ORIGINAL</th>
                                <th class="text-right">Translate</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function afterDelay() {
            console.log("Задержка завершена");
        }
        let data_csv;
        let url = "{{route('getdata')}}";
        fetch(url, {
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        })
            .then(response => response.json())
            .then(data => {
                data_csv = data['data'];
                getTranslate();
            });

        function getTranslate()
        {
            let table = document.getElementById('tableId');
            url = "{{route('translate')}}";
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            (async () => {
                // Начало цикла
                for (let i = 6995; i < data_csv.length; i++) {
                    console.log(`Итерация ${i}`);

                    let a = new FormData()
                    a.append('text', data_csv[i]);
                    fetch(url, {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        body: a
                    })
                        .then(response => response.json())
                        .then(data => {

                        });

                    await sleep(500);
                    if(i % 5 === 0){
                        await sleep(2000);
                    }

                }
            })();
        }

    </script>
@endsection


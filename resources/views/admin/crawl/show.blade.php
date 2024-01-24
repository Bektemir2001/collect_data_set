@extends('layout.admin')
@section('content')
    <style>
        #external-content-container {
            height: 600px; /* Установите желаемую фиксированную высоту */
            overflow-y: auto; /* Добавляет вертикальную прокрутку, если содержимое не помещается */
            border: 1px solid #ccc; /* Просто для визуализации контейнера */
        }

        #external-content-container iframe {
            width: 100%;
            height: 100%;
            border: none; /* Убираем границы iframe */
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{$host_name}}</h4>
                    </div>
                    <div class="header-action">
                        <i data-toggle="collapse" data-target="#datatable-1" aria-expanded="false">
                            <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h4 id="urlsCountId"></h4>
        <h4 id="currentUrlId"></h4>
        <h4 id="urlId"></h4>
{{--        <div id="external-content-container">--}}
{{--        </div>--}}
        <iframe id="external-iframe" frameborder="0" scrolling="auto" height="600px" width="100%"></iframe>
        <div>
            <button class="btn btn-secondary" onclick="previous()">previous url</button>
            <button class="btn btn-primary" onclick="next()">next url</button>
        </div>
        <div class="d-flex justify-content-around">
            <div class="d-flex mb-4 mt-4">
                <div>
                    <form action="{{route('crawl.show')}}" method="POST">
                        @csrf
                        <input name="host_name" value="{{$previousHostName->host_name}}" style="display: none;">
                        <button type="submit" class="btn btn-danger">previous host</button>
                    </form>
                </div>
                <div class="ml-2">
                    <form action="{{route('crawl.show')}}" method="POST">
                        @csrf
                        <input name="host_name" value="{{$nextHostName->host_name}}" style="display: none;">
                        <button type="submit" class="btn btn-success">next host</button>
                    </form>
                </div>
            </div>

            <div class="d-flex mb-4 mt-4">
                <div class="ml-2">
                    <form action="{{route('crawl.black.list')}}" method="POST">
                        @csrf
                        <input name="host_name" value="{{$host_name}}" style="display: none;">
                        <input name="next_host" value="{{$nextHostName->host_name}}" style="display: none;">
                        <button type="submit" class="btn btn-outline-dark mt-2">black list</button>
                    </form>
                </div>
                <div class="ml-2">
                    <form action="{{route('crawl.white.list')}}" method="POST">
                        @csrf
                        <input name="host_name" value="{{$host_name}}" style="display: none;">
                        <input name="next_host" value="{{$nextHostName->host_name}}" style="display: none;">
                        <button type="submit" class="btn btn-outline-info mt-2 btn-with-icon">white list</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div id="url_container" style="display: none;">
        @foreach($urls as $url)
            <div>{{$url}}</div>
        @endforeach
    </div>


    <script>
        let urls = [];
        let container = document.getElementById('url_container').children;
        let current_index = 0;
        for(let i = 0; i < container.length; i++)
        {
            urls.push(container[i].innerHTML);
        }
        console.log(urls)

        function next(){
            if(current_index < (urls.length - 1))
            {
                current_index += 1
                displaySite();
            }
        }
        function previous()
        {
            if(current_index > 0)
            {
                current_index -= 1
                displaySite();
            }
        }
        function displaySite()
        {
            let data = new FormData();
            data.append('url', urls[current_index]);
            data.append('host_name', "{{$host_name}}");
            document.getElementById('urlsCountId').innerHTML = 'urls count = ' + urls.length;
            document.getElementById('currentUrlId').innerHTML = 'current url index = ' + current_index;
            document.getElementById('urlId').innerHTML = urls[current_index]
            fetch("{{route('crawl.get.site.content')}}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: data
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка при загрузке контента. Статус запроса: ' + response.status);
                    }
                    return response.text();
                })
                .then(data => {
                    var iframe = document.getElementById('external-iframe');
                    iframe.contentDocument.body.innerHTML = '';
                    iframe.contentDocument.write(data);
                    // document.getElementById('external-content-container').innerHTML = data;
                })
                .catch(error => {
                    alert('Ошибка при загрузке контента:', error);
                });

        }

        displaySite();
    </script>
@endsection


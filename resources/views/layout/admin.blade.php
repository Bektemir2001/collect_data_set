
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dental Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../../public/assets/images/favicon.ico" />

    <link rel="stylesheet" href="{{asset('admin_files/assets/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_files/assets/css/backend.css?v=1.0.0')}}">
</head>
<body class="  ">
<style>
    .icon-container {
        white-space: nowrap; /* Запрещаем перенос элементов на новую строку */
    }

    .small-icon {
        width: 20px; /* Устанавливаем желаемую ширину для маленьких иконок */
        height: 20px; /* Устанавливаем желаемую высоту для маленьких иконок */
        margin-right: 10px; /* Добавляем небольшой отступ между иконками (по вашему усмотрению) */
        display: inline-block; /* Размещаем иконки в одном ряду */

    }

</style>
<div class="wrapper">
    @include('includes.admin_site_bar')
    @include('includes.admin_navbar')
    <div class="content-page">
        <div class="container-fluid">
            @yield('content')
            <!-- Page end  -->
        </div>
    </div>
</div>
<!-- Wrapper End-->
<footer class="iq-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="../backend/privacy-policy.html">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="../backend/terms-of-service.html">Terms of Use</a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                    <span class="mr-1">
                        Copyright
                        <script>document.write(new Date().getFullYear())</script>© <a href="#" class="">Datum</a>
                        All Rights Reserved.
                    </span>
            </div>
        </div>
    </div>
</footer>    <!-- Backend Bundle JavaScript -->
<script src="{{asset('admin_files/assets/js/backend-bundle.min.js')}}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{asset('admin_files/assets/js/customizer.js')}}"></script>

<script src="{{asset('admin_files/assets/js/sidebar.js')}}"></script>

<!-- Flextree Javascript-->
<script src="{{asset('admin_files/assets/js/flex-tree.min.js')}}"></script>
<script src="{{asset('admin_files/assets/js/tree.js')}}"></script>

<!-- Table Treeview JavaScript -->
<script src="{{asset('admin_files/assets/js/table-treeview.js')}}"></script>

<!-- SweetAlert JavaScript -->
<script src="{{asset('admin_files/assets/js/sweetalert.js')}}"></script>

<!-- Vectoe Map JavaScript -->
<script src="{{asset('admin_files/assets/js/vector-map-custom.js')}}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{asset('admin_files/assets/js/chart-custom.js')}}"></script>
<script src="{{asset('admin_files/assets/js/charts/01.js')}}"></script>
<script src="{{asset('admin_files/assets/js/charts/02.js')}}"></script>

<!-- slider JavaScript -->
<script src="{{asset('admin_files/assets/js/slider.js')}}"></script>

<!-- Emoji picker -->
<script src="{{asset('admin_files/assets/vendor/emoji-picker-element/index.js')}}" type="module"></script>


<!-- app JavaScript -->
<script src="{{asset('admin_files/assets/js/app.js')}}"></script>
</body>
</html>

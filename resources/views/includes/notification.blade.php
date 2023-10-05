@if(session('notification'))
<div class="snackbars active" id="form-output-global">
    <p>
        <span class="icon text-middle fa fa-circle-o-notch fa-spin icon-xxs">

        </span>
        <span>{{session('notification')}}</span>
    </p>
</div>
    <script>
        setTimeout(function() {
            document.getElementById('form-output-global').className = 'd-none';
        }, 5000);
    </script>
@endif

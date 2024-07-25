<!-- <script>
    $(document).ready(function () {
        setInterval(function () {
            $('#overviewWrapper').load(baseUrl+"/overview #overviewWrapper");
        }, 420000)
    });
</script> -->

@if(Session::has('toaster') && Session::get('toaster.1') == 'Credentials Not Found')
    <script>
        $('#qrcodeModal').modal();
    </script>
@endif
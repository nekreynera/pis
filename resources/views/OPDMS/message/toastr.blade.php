@if(Session::has('toastr'))
    <script>
        var msg = new SpeechSynthesisUtterance();
        msg.text = "{{ Session::get('toastr.1') }}";
        window.speechSynthesis.speak(msg);

        toastr.options = {
            "progressBar": true,
            "positionClass":"toast-top-right"
        };
        toastr.{{ Session::get('toastr.0') }}("{{ Session::get('toastr.1') }}");
    </script>
@endif

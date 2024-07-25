@if(Session::has('toaster'))
    <script>
        var msg = new SpeechSynthesisUtterance();
        msg.text = "{{ Session::get('toaster.1') }}";
        window.speechSynthesis.speak(msg);

        toastr.options = {
            "progressBar": true,
            "positionClass":"toast-bottom-right"
        };
        toastr.{{ Session::get('toaster.0') }}("{{ Session::get('toaster.1') }}");

    </script>
@endif

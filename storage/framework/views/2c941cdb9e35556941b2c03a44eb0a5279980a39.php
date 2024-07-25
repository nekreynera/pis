<?php if(Session::has('toastr')): ?>
    <script>
        var msg = new SpeechSynthesisUtterance();
        msg.text = "<?php echo e(Session::get('toastr.1')); ?>";
        window.speechSynthesis.speak(msg);

        toastr.options = {
            "progressBar": true,
            "positionClass":"toast-top-right"
        };
        toastr.<?php echo e(Session::get('toastr.0')); ?>("<?php echo e(Session::get('toastr.1')); ?>");
    </script>
<?php endif; ?>

<?php if(Session::has('toaster')): ?>
    <script>
        var msg = new SpeechSynthesisUtterance();
        msg.text = "<?php echo e(Session::get('toaster.1')); ?>";
        window.speechSynthesis.speak(msg);

        toastr.options = {
            "progressBar": true,
            "positionClass":"toast-bottom-right"
        };
        toastr.<?php echo e(Session::get('toaster.0')); ?>("<?php echo e(Session::get('toaster.1')); ?>");

    </script>
<?php endif; ?>

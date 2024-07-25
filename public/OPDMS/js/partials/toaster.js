/*-- Toastr Message --*/

function toast($color, $message)
{
    var msg = new SpeechSynthesisUtterance();
     msg.text = $message;
     window.speechSynthesis.speak(msg);

     toastr.options = {
     "progressBar": true,
     "positionClass":"toast-bottom-right"
     };
    if($color == 'info'){
        toastr.info($message);
     }else if($color == 'error'){
        toastr.error($message);
     }else if($color == 'warning'){
        toastr.warning($message);
     }else{
        toastr.success($message);
     }
}

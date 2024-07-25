<div id="alertModal" class="modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-cog fa-spin"></i> System Updated </h4>
            </div>
            <div class="modal-body bg-warning">
                <label>Hi doc, <span class="fa fa-file-text-o"></span> Laboratory result is now viewable through PIS </label>
                <br>
                <br> 
                You can view it by following this step.
                <div class="slideshow-container">
                    <div class="mySlides fades">
                        <div class="numbertext">1st step</div>
                        <img src="{{ url('public/laboratory/demo/1.png') }}" style="width:100%">
                        <div class="text">Click incircle button to view patient medical records</div>
                    </div>

                    <div class="mySlides fades">
                        <div class="numbertext">1st step</div>
                        <img src="{{ url('public/laboratory/demo/4.png') }}" style="width:100%">
                        <div class="text">Click incircle button to view patient medical records</div>
                    </div>

                    <div class="mySlides fades">
                        <div class="numbertext">2nd step</div>
                        <img src="{{ url('public/laboratory/demo/2.png') }}" style="width:100%">
                        <div class="text">Select/Click <b>laboratory</b> menu to view the patient list of laboratory request</div>
                    </div>


                    <div class="mySlides fades">
                        <div class="numbertext">3rd step</div>
                        <img src="{{ url('public/laboratory/demo/3.png') }}" style="width:100%">
                        <div class="text">Select a request that you want to view a laboratory result then click the result button if visible</div>
                    </div>

                     <div class="mySlides fades">
                        <div class="numbertext">End</div>
                        <img src="{{ url('public/laboratory/demo/5.png') }}" style="width:100%">
                        <div class="text">Laboratory result viewer</div>
                    </div>

                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                </div>
                <br>

                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span> 
                    <span class="dot" onclick="currentSlide(2)"></span> 
                    <span class="dot" onclick="currentSlide(3)"></span> 
                    <span class="dot" onclick="currentSlide(4)"></span> 
                    <span class="dot" onclick="currentSlide(5)"></span> 
                </div>




       <!--  <i class="fa fa-info-circle"></i> If the laboratory result did not display in 5 seconds or greater just close the laboratory result window then click again the result button
 -->
        <!-- <label>Darryl Joseph A. Bagares</label>
        <p>Computer Operator I/Programmer <br>
        bagares.darryljoseph@gmail.com <br>
        0965-3592999</p> -->
        <br><br><br><br>
        <label>INTEGRATED HOSPITAL OPERATIONS & MANAGEMENT PROGRAM</label><br>
        <p>Local Tel. No.: 1129</p>

      </div>
      <div class="modal-footer">
        <a href="{{ url('patientlist?alert=true') }}" class="btn btn-success btn-sm">Got it! <span class="fa fa-thumbs-up"></span></a>
      </div>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-3 departmentWrapper">
    <form onsubmit="return false" >
        <div class="input-group" style="margin-bottom: 3px;">
            <input type="text" name="" class="form-control requisition-departmanet" id="requisition-departmanet" placeholder="Search Department..." />
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
        </div>
    </form>
    <div class="list-group departmentsContainer" id="departmentsContainer">
        <h6 class="text-center">DEPARTMENTS</h6>
        <a href="#" clinic-code="10" class="list-group-item laboratory-list selected">LABORATORY</a>
        <a href="#" clinic-code="6" class="list-group-item laboratories" disabled="">ULTRASOUND</a>
        {{--<a href="#" clinic-code="11" class="list-group-item laboratories">X-RAY</a>--}}
        <a href="#" clinic-code="7" class="list-group-item laboratories">INJECTION ROOM/ABTC</a>
        <a href="#" clinic-code="12" class="list-group-item laboratories">ECG</a>

         @if(Auth::user()->clinic == 45)
        <a href="" clinic-code="21" class="list-group-item laboratories">DERMATOLOGY</a>
        @endif

        @if(Auth::user()->clinic == 34)
        <a href="" clinic-code="4" class="list-group-item laboratories">SURGERY</a>
        @endif
        @if(Auth::user()->clinic == 24)
            <a href="" clinic-code="3" class="list-group-item laboratories">OPTHALMOLOGY</a>
        @endif

        @if(Auth::user()->clinic == 26)
        <a href="" clinic-code="1" class="list-group-item laboratories">PEDIATRICS</a>
        @endif
        @if(Auth::user()->clinic == 5)
        <a href="" clinic-code="2" class="list-group-item laboratories">ENT</a>
        @endif
        @if(Auth::user()->clinic == 25)
        <a href="" clinic-code="8" class="list-group-item laboratories">ORTHOPEDIC</a>
        @endif
        @if(Auth::user()->clinic == 32)
        <a href="" clinic-code="9" class="list-group-item laboratories">REHABILITATION</a>
        @endif
        @if(Auth::user()->clinic == 29)
        <a href="" clinic-code="17" class="list-group-item laboratories">PSYCHIATRY</a>
        @endif
        @if(Auth::user()->clinic == 43)
        <a href="" clinic-code="15" class="list-group-item laboratories">INDUSTRIAL CLINIC</a>
        @endif
        @if(Auth::user()->clinic == 3)
        <a href="" clinic-code="5" class="list-group-item laboratories">DENTAL</a>
        @endif
        @if(Auth::user()->clinic == 8)
        <a href="" clinic-code="18" class="list-group-item laboratories">FAMILY MEDICINE</a>
        @endif
    </div>
</div>
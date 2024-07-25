@component('partials/header')

    @slot('title')
        PIS | Requisition
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/requisition.css?v2.0.1') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
        @section('main-content')






            <div class="content-wrapper" style="padding: 55px 10px 0px 10px;">

                <div class="container-fluid">

                    @include('doctors.requisition.patientName')

                        <div class="col-md-12 col-sm-12 requsitionWrapper">

                            <div class="row">

                                @include('doctors.requisition.departments')

                                @include('doctors.requisition.selection')

                            </div>

                        </div>


                        @include('doctors.requisition.selectedItems')
                    </div>

                </div>

            </div> <!-- .content-wrapper -->







        @endsection
    @endcomponent
@include('doctors.requisition.payment')

@endsection





@section('footer')
@stop






@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition/department.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition/selection.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition/selected.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition/table.js?v1.0.2') }}"></script>
    <script src="{{ asset('public/js/doctors/requisition/search.js?v1.0.2') }}"></script>

    <!-- <script src="{{ asset('public/js/doctors/main.js') }}"></script>
    <script src="{{ asset('public/js/requisition/master.js') }}"></script>
    <script src="{{ asset('public/js/requisition/meds.js') }}"></script>
    <script src="{{ asset('public/js/requisition/radiology.js') }}"></script>
    <script src="{{ asset('public/js/requisition/laboratory.js') }}"></script> -->
@endsection

@endcomponent

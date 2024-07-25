@component('partials/header')

    @slot('title')
        PIS | For Approvals
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/patientlist.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/requisition/medicines.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors.dashboard')
        @section('main-content')


        <div class="content-wrapper" style="padding: 50px 0px">
            <br/>
            <div class="container-fluid" id="patientListWrapper">

                @include('doctors.medicalRecords')
                @include('doctors.ajaxConsultationList')
                @include('doctors.ajaxRequisitionList')
                @include('doctors.ajaxRefferals')
                @include('doctors.ajaxFollowup')
                @include('doctors.records.consultation')
                @include('doctors.requisition.medsWatch')

                <div class="col-md-12">
                    <br>
                    <h3 class="text-center">Patients For Approval</h3>
                    <hr>
                    <div class="">
                        <table class="table" id="patientListTable">

                            @include('doctors.approvals.thead')

                            <tbody>
                            @if(count($approvals) > 0)
                                @foreach($approvals as $approval)
                                    <tr>

                                        @include('doctors.approvals.patientName')

                                        @include('doctors.approvals.records')

                                        @include('doctors.approvals.status')

                                    </tr>
                                @endforeach
                            @else

                                @include('doctors.approvals.notFound')

                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div> <!-- .content-wrapper -->




        @endsection
    @endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/form.js') }}"></script>
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>

    <script src="{{ asset('public/js/doctors/ajaxRecords.js') }}"></script>
    <script src="{{ asset('public/js/results/consultation.js') }}"></script>
    <script src="{{ asset('public/js/results/master.js') }}"></script>
    <script src="{{ asset('public/js/results/medsWatch.js') }}"></script>
    <script src="{{ asset('public/js/results/ultrasound.js') }}"></script>

@stop


@endcomponent

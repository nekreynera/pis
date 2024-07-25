@component('partials/header')

    @slot('title')
        PIS | Edit Consultation
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/diagnosis.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
        @section('main-content')


            <div class="content-wrapper" style="padding: 50px 20px">
                <div class="container-fluid">

                    @include('doctors.consultation_patientinfo', ['patient'=>$patient])

                    @include('doctors.consultation_notification', ['refferals'=>$refferals, 'followups'=>$followups])

                    <div class="row diagnosisWrapper">
                        <br>
                        
                        <div class="row">

                            <div class="col-md-8">
                                <h1 class="text-center" style="display: inline">
                                    <small class="text-danger">{{ $patient->last_name.', '.$patient->first_name.' '.($patient->middle_name ? $patient->middle_name[0].'.' : '') }}</small>
                                </h1>
                                <button class="btn btn-default menusConsultations" title="Click to view patient information" data-toggle="modal" data-target="#patientInfo">
                                    <i class="fa fa-user-o text-primary"></i>
                                </button>
                                <button class="btn btn-default menusConsultations" data-toggle="modal" data-target="#notification" title="Click to view patients notification">
                                    <i class="fa fa-bell-o text-primary"></i>
                                    {!! ((count($refferals) + count($followups)) > 0)? '<span class="badgeIcon">'.(count($refferals) + count($followups)).'</span>' : '' !!}
                                </button>
                            </div>

                            <div class="col-md-4 text-right icd10codes">
                                    <a href="#" class="btn btn-default saveButton menusConsultations"
                                       data-placement="top" data-toggle="tooltip" title="Click to Save this consultation"">
                                        <i class="fa fa-save text-danger"></i>
                                    </a>
                                    <a href="{{ url('print/'.$consultation->id) }}" class="btn btn-default menusConsultations"
                                    data-placement="top" data-toggle="tooltip" title="Print this consultation form"
                                    onclick="return confirm('Print this consultation?')" target="_blank">
                                        <i class="fa fa-print text-success"></i>
                                    </a>
                                    {{--<a href="" class="btn btn-default menusConsultations"
                                    data-placement="top" data-toggle="tooltip" title="Delete this consultation"
                                    onclick="return confirm('Do you really want to delete this consultation? Warning! Deleting this consultation will also delete all uploaded files and icd codes')" >
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>--}}
                                <a href="#" class="btn btn-success icdCodesBtn" data-toggle="modal" data-target="#icd10CodeModal">ICD 10 CODES</a>
                            </div>
                        </div>

                        <form action="{{ url('consultation/'.$consultation->id) }}" method="post" enctype="multipart/form-data" id="consultationForm">
                            {{ csrf_field()  }}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <textarea name="consultation" id="diagnosis" class="my-editor" rows="65">{!! $consultation->consultation !!}</textarea>
                            </div>

                            @include('doctors.filemanager')

                            @include('doctors.icdCodeAttachments', ['icds'=>$icdcodes]);

                        </form>
                    </div>

                    @include('doctors.icd10codes')

            </div>

        </div><!-- .content-wrapper -->


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
    <script src="{{ asset('public/js/doctors/filemanager.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/richtexteditorpreview.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
    <script src="{{ asset('public/js/doctors/consultation.js') }}"></script>
@stop


@endcomponent

@component('partials/header')

    @slot('title')
        PIS | Nurse Notes
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/receptions/nursenotes.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <h3>
                        <small>Patient Name:</small>
                        {{ $consultation->patient }}
                    </h3>
                </div>
                <div class="col-md-6">
                    <h3 class="text-right titleWrapper">
                        Write Nurse Notes
                        <button type="submit" form="consultationForm" onclick="return confirm('Save this nurse notes?')"
                                class="btn btn-default iconsNurse" data-placement="top" data-toggle="tooltip" title="Click to save nurse notes" >
                            <i class="fa fa-save text-danger"></i>
                        </button>
                        <a href="{{ url('printNurseNotes/'.$consultation->id) }}" target="_blank" class="btn btn-default iconsNurse"
                           data-placement="top" data-toggle="tooltip" title="Print this consultation" >
                            <i class="fa fa-print text-success"></i>
                        </a>
                    </h3>
                </div>
            </div>

            <form action="{{ url('nurseNotes') }}" method="post" enctype="multipart/form-data" id="consultationForm">
                {{ csrf_field()  }}
                <input type="hidden" name="cid" value="{{ $consultation->id }}">
                <div class="form-group">
                    <textarea name="consultation" id="diagnosis" class="my-editor" rows="40">{!! $doctorsConsultation or '' !!}</textarea>
                </div>
            </form>

        </div>
    </div>


@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/richtexteditorpreview.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
@stop


@endcomponent

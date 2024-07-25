@component('partials/header')

    @slot('title')
        PIS | Chief Complaint
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
                        {{ $patient->last_name.', '.$patient->first_name }}
                    </h3>
                </div>
            </div>

            <form action="{{ url('saveChiefComplaint') }}" method="post" enctype="multipart/form-data" id="consultationForm">
                {{ csrf_field()  }}
                <input type="hidden" name="pid" value="{{ $patient->id }}" />
                <div class="form-group">
                    <textarea name="consultation" id="diagnosis" class="my-editor" rows="65">{!! $consultation->consultation or '' !!}</textarea>
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
{{--    <script src="{{ asset('public/js/doctors/richtexteditorpreview.js') }}"></script>--}}
    <script src="{{ asset('public/js/doctors/richtexteditor.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
@stop


@endcomponent

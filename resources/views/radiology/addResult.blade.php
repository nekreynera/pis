@component('partials/header')

    @slot('title')
        PIS | Add Result
    @endslot

@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/css/radiology/master.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/radiology/addResult.css') }}">
@stop



@section('header')
    @include('radiology/navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">


            <div class="container">

                <h2 class="text-left">
                    {{ $radiology->category }} | <span class="text-danger">{{ $radiology->sub_category }}</span></h2>
                <hr>


                @include('radiology.store.tabs')


                <div class="tab-content">
                    <div id="addResultWrapper" class="tab-pane fade in active">

                        @include('message.loader')

                        <form action="{{ url('radiology') }}" method="post">

                            {{ csrf_field() }}


                                @include('radiology.header')


                            <textarea name="result" class="my-editor" id="" cols="30" rows="40">{{ $radiology->content }}</textarea>
                            <input type="hidden" name="patient_id" value="{{ $radiology->patients_id }}" />
                            <input type="hidden" name="user_id" value="{{ $radiology->users_id }}" />
                            <input type="hidden" name="ancillaryrequest_id" value="{{ $radiology->id }}" />
                        </form>

                    </div>
                </div>


            </div>


        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/radiology/richtexteditor.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
    <script src="{{ asset('public/js/radiology/template.js') }}"></script>

@stop


@endcomponent

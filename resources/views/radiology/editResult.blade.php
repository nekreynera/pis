@component('partials/header')

    @slot('title')
        PIS | Edit Result
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

                        <form action="{{ url('radiology/'.$radiology->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            @include('radiology.header')

                            <textarea name="result" class="my-editor" id="" cols="30" rows="40">{{ $radiology->result or '' }}</textarea>
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

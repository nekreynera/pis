@component('partials/header')

    @slot('title')
        PIS | Diagnosis Preview
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/css/doctors/preview.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <div class="container-fluid">
            <br>
            <div class="previewHeaderWrapper">
                <h2>DIAGNOSIS PREVIEW</h2>
                <div class="pull-right" style="display: inline">
                    @php
                        $action = ($diagnosis->users_id == Auth::user()->id)? '' : 'disabled onclick="event.preventDefault()"' ;
                        $activateEdit = ($diagnosis->users_id == Auth::user()->id)? 'onclick="return confirm('."'Edit this diagnosis'".')"' : '';
                        $activateDelete = ($diagnosis->users_id == Auth::user()->id)? 'onclick="return confirm('."'Delete this diagnosis'".')"' : '';
                    @endphp
                    <a href="{{ url('printdiagnosis/'.$diagnosis->id) }}" target="_blank" class="btn btn-default">
                        <span class="text-success">PRINT</span> <i class="fa fa-print text-success"></i>
                    </a>
                    <a href="{{ url('diagnosis/'.$diagnosis->id.'/edit') }}" class="btn btn-default" {!! $action !!} {!! $activateEdit !!}>
                        <span class="text-primary">EDIT</span> <i class="fa fa-pencil text-primary"></i>
                    </a>
                    <a href="{{ url('diagnosisdestroy/'.$diagnosis->id) }}" class="btn btn-default" {!! $action !!} {!! $activateDelete !!}>
                        <span class="text-danger">DELETE</span> <i class="fa fa-trash text-danger"></i>
                    </a>
                </div>
            </div>
            <br>


            <div class="diagnosisPreview">
                {!! $diagnosis->diagnosis !!}
            </div>


            @if(count($diagnosis_icds) > 0)
                <div class="diagnosisWrapper">
                    <br>
                    <br>
                    @foreach($diagnosis_icds as $diagnosis_icd)
                    <div class="form-group input-group">
                        <input type="text" class="form-control" value="{{ $diagnosis_icd->description }}" readonly="" />
                        <span class="input-group-addon">
                            <i class="fa fa-trash-o"></i>
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif





            <br>
            <br>
            <br>

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
    <script src="{{ asset('public/js/doctors/filemanager.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/richtexteditor.js') }}"></script>
    <script src="{{ asset('public/js/doctors/preview.js') }}"></script>
@stop


@endcomponent

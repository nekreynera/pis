@component('partials/header')

    @slot('title')
        PIS | Consultation
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
                    <h2>CONSULTATION PREVIEW</h2>
                    <div class="pull-right" style="display: inline">
                        @php
                            $action = ($consultation->users_id != Auth::user()->id)? 'disabled onclick="event.preventDefault()"' : '';
                            $activateEdit = ($consultation->users_id == Auth::user()->id)? 'editConsultation' : '';
                            $activateDelete = ($consultation->users_id == Auth::user()->id)? 'deleteConsultation' : '';
                        @endphp
                        <a href="{{ url('print/'.$consultation->id) }}" target="_blank" class="btn btn-default">
                            <span class="text-success">PRINT</span> <i class="fa fa-print text-success"></i>
                        </a>
                        <a href="{{ url('consultation/'.$consultation->id.'/edit') }}" {!! $action !!} class="btn btn-default {{ $activateEdit }}">
                            <span class="text-primary">EDIT</span> <i class="fa fa-pencil text-primary"></i>
                        </a>
                        <a href="{{ url('consultationdelete/'.$consultation->id) }}" {!! $action !!} class="btn btn-default {{ $activateDelete }}">
                            <span class="text-danger">DELETE</span> <i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                </div>
                <br>


            <div class="table-responsive">
                {!! $consultation->consultation !!}
            </div>


            @if(count($consultations_icds) > 0)
                <div class="diagnosisWrapper">
                    <br>
                    <h2 class="">International Classification of Diseases</h2>
                    <br>
                    @foreach($consultations_icds as $consultations_icd)
                        <div class="form-group input-group">
                            <input type="text" class="form-control" value="{{ $consultations_icd->description }}" readonly="" />
                            <span class="input-group-addon">
                            <i class="fa fa-trash-o"></i>
                        </span>
                        </div>
                    @endforeach
                </div>
            @endif




            @if(count($files) > 0)

          {{--  <hr class="horizontal-role">--}}

            <div class="">
                <br>
                <br>
                <h2 class="">Uploaded Files Preview</h2>
                <br>
                <div class="bg-danger filesWrapper" id="uploadedFilesAttchments">

                    @foreach($files as $file)

                        <div class="imgWrapperPreview">
                            @php
                                $filetype = array('doc','docx','txt','xlsx','xls','pdf','ppt','pptx');
                                $filename = explode('.',$file->filename);
                            @endphp
                            @if(!in_array($filename[1],$filetype))
                                <img src="{{ $directory.$file->filename }}" alt="" class="img-responsive" width="100%" />
                                <a href="" class="btn btn-primary btn-circle viewImage" data-placement="top" data-toggle="tooltip" title="View this file?">
                                    <i class="fa fa-image"></i>
                                </a>
                                <a href='{{ url("removefile/$file->id") }}' class="btn btn-danger btn-circle deleteFile" data-placement="top" data-toggle="tooltip" title="Delete this file?">
                                    <i class="fa fa-trash"></i>
                                </a>
                            @else
                                @if($filename[1] == 'doc' || $filename[1] == 'docx')
                                    <img src="{{ asset('public/images/mswordlogo.svg') }}" alt="" class="img-responsive" />
                                @elseif($filename[1] == 'xlsx' || $filename[1] == 'xls')
                                    <img src="{{ asset('public/images/excellogo.svg') }}" alt="" class="img-responsive" />
                                @elseif($filename[1] == 'ppt' || $filename[1] == 'pptx')
                                    <img src="{{ asset('public/images/powerpointlogo.svg') }}" alt="" class="img-responsive" />
                                @elseif($filename[1] == 'pdf')
                                    <img src="{{ asset('public/images/pdflogo.svg') }}" alt="" class="img-responsive" />
                                @else
                                    <img src="{{ asset('public/images/textlogo.svg') }}" alt="" class="img-responsive" />
                                @endif
                                <a href="{{ $directory.$file->filename }}" target="_blank" class="btn btn-info btn-circle" data-placement="top" data-toggle="tooltip" title="Open this file?">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                                <a href="{{ url("removefile/$file->id") }}" class="btn btn-danger btn-circle deleteFile" data-placement="top" data-toggle="tooltip" title="Delete this file?">
                                    <i class="fa fa-trash"></i>
                                </a>
                            @endif
                            <input type="hidden" value="{{ $file->title }}" class="title" />
                            <textarea hidden class="description">{{ $file->description }}</textarea>
                        </div>

                    @endforeach

                </div>


                <div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreview" aria-hidden="true">
                    <div class="modal-dialog modal-xxl colorless" role="document">
                        <div class="modal-content colorless">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1">
                                    <span class="text-danger">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body colorless">
                                <div class="row colorless">
                                    <div class="col-md-8">
                                        <img src="" id="showImage" alt="Failed to load image." class="img-responsive center-block" />
                                    </div>
                                    <div class="col-md-4 imageDescWrapper">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input type="text" class="form-control" readonly id="showTitle" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea id="showDescription" cols="30" rows="10" class="form-control" readonly style="background-color: transparent"></textarea>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


                <div class="fileIncludedWrapper">
                    <a href="#uploadedFilesAttchments" class="btn">
                        <i class="fa fa-arrow-down"></i> See File Attachments Below
                    </a>
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

@component('partials/header')

    @slot('title')
        PIS | Consultations Details
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/preview.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="text-left" style="margin: 0">Consultation Details</h2>
                    </div>
                    <div class="col-md-3 text-right">
                        <a href="{{ url('printNurseNotes/'.$consultation->id) }}" target="_blank" class="btn btn-default text-success">
                            <i class="fa fa-print text-success"></i> <span class="text-success">Print</span>
                        </a>
                        <a href="{{ url('nurseNotes/'.$consultation->id) }}" class="btn btn-default">
                            <i class="fa fa-pencil text-danger"></i> <span class="text-danger">Write Nurse Notes</span>
                        </a>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-md-4">Last Name:</th>
                                <td>{{ $patient->last_name }}</td
                            </tr>
                            <tr>
                                <th>Given Name:</th>
                                <td>{{ $patient->first_name }}</td>
                            </tr>
                            <tr>
                                <th>CIVIL STATUS:</th>
                                <td>{{ $patient->civil_status }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $patient->address }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-md-4">Middle Name:</th>
                                <td>{{ $patient->middle_name }}</td
                            </tr>
                            <tr>
                                <th>Birthday:</th>
                                <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td>{{ App\Patient::age($patient->birthday) }}</td>
                            </tr>
                            <tr>
                                <th>Contact No:</th>
                                <td>{{ $patient->contact_no }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                

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
                        <h2 class="">Uploaded Files for this Consultation</h2>
                        <br>
                        <div class="bg-danger filesWrapper">

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

                @endif

                <br>
                <br>
                <br>

            </div>
        </div>
    </div>


@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/js/doctors/filemanager.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/richtexteditor.js') }}"></script>
    <script src="{{ asset('public/js/doctors/preview.js') }}"></script>
@stop


@endcomponent

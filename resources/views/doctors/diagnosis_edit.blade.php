@component('partials/header')

    @slot('title')
        PIS | Diagnosis Edit
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/diagnosis.css') }}" rel="stylesheet" />
@endsection



@section('header')
    @include('doctors.navigation')
@stop
@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <br>
        <br>
        <div class="container-fluid">

            <div class="row diagnosisWrapper">

                <div class="row">
                    <div class="col-md-10">
                        <h2 class="text-center" style="display: inline">
                            DIAGNOSIS EDIT <small>Patient Name: {{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name[0].'.' }}</small>
                        </h2>
                    </div>
                    <div class="col-md-2 text-right icd10codes">
                        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#icd10CodeModal">ICD 10 CODES</a>
                    </div>
                </div>


                <form action="{{ url('diagnosis/'.$diagnosis->id) }}" method="post" id="diagnosisForm">
                    {{ csrf_field()  }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <textarea name="diagnosis" id="diagnosis" class="my-editor" rows="40">{{ $diagnosis->diagnosis }}</textarea>
                    </div>

                    <div class="icdsContainer">
                        @if(count($diagnosis_icds) > 0)
                                <br>
                                <br>
                                @foreach($diagnosis_icds as $diagnosis_icd)
                                    <div class="form-group input-group icd{{ $diagnosis_icd->icd_id }}">
                                        <input type="text" class="form-control" value="{{ $diagnosis_icd->description }}" readonly="" />
                                        <input type="hidden" name="icd[]" value="{{ $diagnosis_icd->icd_id }}" />
                                        <span class="input-group-addon" data-dicd="{{ $diagnosis_icd->dicd_id }}" data-desc="{{ $diagnosis_icd->description }}" data-id="{{ $diagnosis_icd->icd_id }}"
                                              onclick="removeICD($(this))" data-placement="top" data-toggle="tooltip" title="Click to delete ICD">
                                            <i class="fa fa-trash-o"></i>
                                        </span>
                                    </div>
                                @endforeach
                        @endif
                    </div>

                </form>
            </div>



            <div id="icd10CodeModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title text-center">International Classification of Diseases</h2>
                        </div>
                        <div class="modal-body">
                            <div class="row icdWrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ url('searchICD') }}" method="POST" id="icdSearchForm">
                                            {{ csrf_field() }}
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Description..." aria-describedby="basic-addon1">
                                                <span class="input-group-addon" id="basic-addon1">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{ url('searchICD') }}" method="post" id="icdSearchCodeForm">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Code..." aria-describedby="basic-addon1">
                                                <span class="input-group-addon" id="basic-addon1">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <div class="">
                                    <p class="text-right text-primary">Total of <span class="totalICDS"></span> Results Found...</p>
                                    <div class="loaderWrapper">
                                        <img src="{{ asset('public/images/loader.svg') }}" alt="Loader" class="img-responsive center-block" />
                                        <p>Loading...</p>
                                    </div>
                                    <table class="table table-striped" id="tableICD">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-question"></i></th>
                                            <th>CODE</th>
                                            <th>DESCRIPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody id="icdTbody">
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-center" id="paginator">
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" class="close" data-dismiss="modal">OK <i class="fa fa-check"></i></button>
                        </div>
                    </div>

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
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/doctors/diagnosiseditor.js') }}"></script>
    <script src="{{ asset('public/js/doctors/diagnosis.js') }}"></script>
@stop


@endcomponent

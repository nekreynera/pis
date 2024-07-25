@component('partials/header')

    @slot('title')
        PIS | Diseases
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
    <link href="{{ asset('public/css/doctors/diagnosis.css') }}" rel="stylesheet" />
    <style media="screen">
    @media only screen and (max-width: 500px) {
         .icdWrapper{
            padding: 5px 0 0px 0 !important;
        }
    }
    </style>
@endsection



@section('header')
    @include('doctors.navigation')
@stop
@section('content')
    @component('doctors/dashboard')
@section('main-content')


    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row icdWrapper">
                <br>
                <h3 class="text-center hidden-xs">International Classification of Diseases</h3>
                <h3 class="text-center visible-xs">ICD 10 Codes</h3>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ url('searchICD') }}" method="POST" id="icdSearchForm">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Description..." aria-describedby="basic-addon1">
                                <span class="input-group-addon" id="basic-addon1" onclick="icd('searchActivate')">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ url('searchICD') }}" method="post" id="icdSearchCodeForm">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search ICD By Code..." aria-describedby="basic-addon1">
                                <span class="input-group-addon" id="basic-addon1" onclick="icd('searcCodeActivate')">
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
                    <div class="table-responsive">

                    <table class="table table-striped" id="tableICD">
                        <thead>
                        <tr>
                            <th>#</th>
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
    <script src="{{ asset('public/js/doctors/icd_codes.js') }}"></script>
@stop


@endcomponent

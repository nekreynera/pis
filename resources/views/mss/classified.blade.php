@component('partials/header')

    @slot('title')
        PIS | Classified Patient
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/css/partials/navigation.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/mss/classified.css?v2.0.1') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/css/mss/charges.css?v2.0.1') }}" />
    @stop



    @section('header')
        @include('mss/navigation')
    @stop



    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12  pull-right">
                    <form class="text-center" method="GET" action="">
                        <div class="input-group">
                              <div class="input-group-btn">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-search"></i> Search By <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu search-menu">
                                      <li><a href="#" class="lname">Last Name</a></li>
                                      <li><a href="#" class="fname">First Name</a></li>
                                      <li><a href="#" class="hospital_no">Patient Hospital No.</a></li>
                                      <li><a href="#" class="datereg">Date Classified</a></li>
                                  </ul>
                              </div>
                              
                              <!-- /btn-group -->
                              <input type="text" name="patient" id="patient" onkeyup="searchclassifiedpatient($(this))" class="form-control patient input-sm" placeholder="hospital no last name first name middle name..." autofocus/>
                              <span class="input-group-btn">
                                  <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                      <i class="fa fa-search"></i> Search
                                  </button>
                              </span>
                        </div>
                        <span class="fa fa-info-circle"></span> <small class="search-guide"> hospital no last name first name middle name</small>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
            <div>
                <ul class="nav nav-tabs">
                    @php
                        $total = 0;
                    @endphp
                    @foreach($tab as $list)
                    <li
                        @if(count($request->post()) > 0) 
                            @if($request->id == $list->mss_id)
                                class="active" 
                            @endif
                        @endif
                    >
                        <a href="classified?id=@if($list->label){{$list->mss_id}}@else{{'UNCLASSIFIED'}}@endif&lname={{ $request->lname }}&fname={{ $request->fname }}&hospital_no={{ $request->hospital_no }}&datereg={{ $request->datereg }}&patient={{ $request->patient }}"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="VIEW ONLY {{ $list->label.' - '.$list->description }}">
                            @if($list->label)
                            {{ $list->label.' - '.$list->description }}
                            @else
                                NOT MSS CLASSIFIED
                            @endif
                            <span class="badge">{{ $list->counts }}</span>
                        </a>
                    </li>
                    @php
                        $total += $list->counts;
                    @endphp
                    @endforeach
                    <li @if(!$request->id) class="active" @endif>
                        <a href="classified?&lname={{ $request->lname }}&fname={{ $request->fname }}&hospital_no={{ $request->hospital_no }}&datereg={{ $request->datereg }}"
                           class="" 
                           data-toggle="tooltip" data-placement="top" title="TOTAL">
                            TOTAL
                            <span class="badge">{{ $total }}</span>
                        </a>
                    </li>
                </ul>
            </div>
                
            <div class="table-responsive ">
                <table class="table table-striped table-hover" id="classifiedTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 100px;">MSWD NO</th>
                            <th>HOSPITAL NO</th>
                            <th style="min-width: 150px;">DATE</th>
                            <th style="min-width: 200px;">NAME OF PATIENT</th>
                            <th>AGE</th>
                            <th>GENDER</th>
                            <th style="min-width: 300px;">ADDRESS</th>
                            <th>CATEGORY</th>
                            <th style="min-width: 150px;">CLASSIFICATION</th>
                            <th>SECTORIAL GROUPING</th>
                            <th>SOURCE OF REFERRAL</th>
                            <th>PHILHEALTH CATEGORY</th>
                            <th style="min-width: 200px;">USER</th>
                            <th>PRINT</th>
                            <th>EDIT</th>
                            <th>MALASAKIT</th>
                            <th>CHARGES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classified as $key => $var)
                            <tr>
                                <th  style="background-color: #ccc">{{ $key+1 }}</th>
                                <td class="text-center text-capitalize">
                                    {{ $var->mswd }}
                                </td>
                                <td class="text-center">{{ $var->hospital_no }}</td>
                                <td class="text-center">{{ Carbon::parse($var->created_at)->format('m/d/Y g:ia') }}</td>
                                <td class="text-capitalize">{{ strtolower($var->last_name).', '.strtolower($var->first_name).' '.substr(strtolower($var->middle_name), 0,1) }}.</td>
                                @if(Carbon::parse($var->birthday)->age >= 60)
                                <td class="text-center" style="font-weight: bold;color: red;">{{ Carbon::parse($var->birthday)->age }}</td>
                                @else
                                <td class="text-center">{{ Carbon::parse($var->birthday)->age }}</td>
                                @endif
                                <td class="text-center">{{ $var->gender }}</td>
                                <td>{{ $var->brgyDesc.', '.$var->citymunDesc }}</td>
                                @php
                                    if($var->category == 'O'):
                                        $category = 'Old';
                                    elseif($var->category == 'N'):
                                        $category = 'New';
                                    else:
                                        $category = 'Cases Forward';
                                    endif;
                                @endphp
                                <td class="text-center">{{ $category }}</td>
                                <td class="text-center">
                                    @if(Carbon::parse($var->validity)->format('Y-m-d') < Carbon::now()->format('Y-m-d'))
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger btn-sm" title="Expired ({{ Carbon::parse($var->validity)->format('m/d/Y') }})">EXPIRED</button>
                                        <a href="{{ url('mss/'.$var->id.'/edit') }}" class="btn btn-success btn-sm" title="click me to Update patient mss classification">Edit</a>
                                    </div> <br>
                                    @endif
                                    @if($var->mss)
                                    {{ $var->mss }}
                                    @else
                                    <form action="{{ url('classification') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="barcode" value="{{ $var->hospital_no }}" class="form-control inputbarcode">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger btn-sm">N / A</button>
                                            <button type="submit" class="btn btn-success btn-sm" title="click me to classify this patient">Classifiy</button>
                                        </div>
                                    </form>
                                    @endif
                                </td>
                                <td>{{ $var->sectorial }}</td>
                                <td>{{ $var->referral }}</td>
                                @php
                                    if($var->philhealth == 'M'):
                                        $philheath = 'Member';
                                    elseif($var->philhealth == 'D'):
                                        $philheath = 'Dependent';
                                    else:
                                        $philheath = '';
                                    endif;
                                @endphp
                                <td>{{ $philheath }}-{{ $var->membership }}</td>
                                <td class="text-capitalize">{{ strtolower($var->users) }}</td>
                                <td align="center">
                                    <a href="{{ url('mssform/'.$var->id) }}" class="btn btn-primary btn-sm" target="_blank" 
                                        data-toggle="tooltip" data-placement="top"
                                        data-id="{{ $var->id }}" 
                                        title="click me to print patient MSWD Assessment form">
                                        <span class="fa fa-print"></span>
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{ url('mss/'.$var->id.'/edit') }}" class="btn btn-success btn-sm" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to edit patient data">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                </td>
                                <td align="center">
                                    <a href="{{ url('malasakitprint/'.$var->id) }}" class="btn btn-danger btn-sm" 
                                        target="_blank" class="btn btn-default" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to print patient data in malasakit form">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    <button class="btn btn-warning btn-sm" id="patient-charges" 
                                        patient-id="{{ $var->patient_id }}" 
                                        data-toggle="tooltip" data-placement="top"
                                        title="click me to view patient charges">
                                         <span class="fa fa-money"></span> 
                                    </button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="choosedatemodal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <form method="post" action="{{ url('classifiedbyday') }}">
                       {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">CHOOSE DATE</h4>
                    </div>
                    <div class="modal-body">
                        <input type="date" name="date" id="choose_date" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">OK</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    @include('mss.modals.charges.main')    
    @include('mss.modals.charges.adjust')    
    @endsection 




    @section('pagescript')
        <script>
            // $('#patient-adjust-charges').modal('toggle');
            var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
            var mss_user_id = '{{ Auth::user()->id }}';
        </script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/mss/classified.js?v2.0.1') }}"></script>
        <script src="{{ asset('public/js/mss/charges.js?v2.0.2') }}"></script>
    @stop


@endcomponent

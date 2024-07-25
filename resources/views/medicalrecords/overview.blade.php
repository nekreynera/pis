@component('partials/header')

  @slot('title')
    PIS | MEDICAL RECORDS
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/medicalrecords/overview.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/medicalrecords/patientinfo.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/medicalrecords/consultationrecords.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/medicalrecords/addpatient.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('medicalrecords/navigation')
  @endsection

  @section('content')
    <div class="container overview-container">
        <h4 class="text-center">PATIENTS REQUESTED BY DOCTORS</h4>
            <ul class="nav nav-tabs">
                @php
                    $p = 0;
                    $d = 0;
                @endphp
                @foreach($tab as $list)
                    @if($list->status == "P")
                        @php
                            $p++;
                        @endphp
                    @else
                         @php
                            $d++;
                        @endphp
                    @endif
                @endforeach
                <li >
                    <a href="{{ url('medicalrecord?stats=P') }}"
                        class="text-warning @if($request->stats == 'P') {{ 'active-warning' }} @endif">
                        Pending
                        <span class="badge badge-warning">{{ $p }}</span>
                    </a>
                </li>
                <li >
                    <a href="{{ url('medicalrecord?stats=D') }}"
    
                        class="text-info @if($request->stats == 'D') {{ 'active-primary' }} @endif">
                        Done
                        <span class="badge badge-primary">{{ $d }}</span>
                    </a>
                </li>
                <li >
                    <a href="{{ url('medicalrecord?stats=ALL') }}"

                        class="text-default @if($request->stats == 'ALL') {{ 'active-default' }} @endif">
                        Total
                        <span class="badge badge-default">{{ count($tab) }}</span>
                    </a>
                    </li>
            </ul>
                <div class="text-right search-group">
                    <form class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control">
                            <span class="input-group-addon fa fa-search"></span>
                        </div>
                    </form>
                </div>
        <div class="table-responsive" id="overview-table">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="pt-info" rowspan="2" data-toggle="tooltip" data-placement="top" title="click to view patient info"><span class="fa fa-user-circle-o"></span></th>
                        <th rowspan="2">Patients Name</th>
                        <th rowspan="2">Consultation <br>Record</th>
                        <th rowspan="2">Request</th>
                        <th rowspan="2">Datetime</th>
                        <th colspan="2" style="padding: 3px;">Request by</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th style="padding: 3px;">Doctor</th>
                        <th style="padding: 3px;">Clinic</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $list)
                    <tr>
                        <td align="center" class="pt-info" data-id="{{$list->patient_id}}"><span class="fa fa-user"></span><br><small>{{ $list->hospital_no }}</small></td>
                        <td>{{ $list->last_name.', '.$list->first_name.' '.substr($list->middle_name, 0,1).'.' }}</td>
                        <td align="center" style="padding: 4px;">
                            @if($list->records > 0)
                            <button type="button" class="btn btn-default btn-circle" id="view-consultation" data-id="{{$list->patient_id}}" 
                                style="background-color: rgb(46, 109, 164); color: #ffffff;border: 1px solid rgb(46, 109, 164);">
                                <span class="fa fa-file-text-o"></span>
                                <span class="badge badge-info">{{ $list->records }}</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-default btn-circle"><span class="fa fa-file-text-o"></span></button>
                            @endif
                        </td>
                        <td>
                            @php
                            $category = App\Ancillaryrequist::getpatientrequest($list->patient_id);

                            @endphp
                            @foreach($category as $var)
                                {!! $var->sub_category."<br>" !!}
                            @endforeach
                        </td>
                       
                        <td align="center">{{ Carbon::parse($list->created_at)->format('m/d/Y h:i a') }}</td>
                        <td>{{ $list->users }}</td>
                        <td>{{ $list->name }}</td>
                        <td align="center" style="padding: 4px;" class="action">
                            <!-- <a href="{{ $list->id }}" class="btn btn-default btn-sm"><span class="fa fa-arrow-right"></span> Proceed</a> -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">Proceed</button>
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="#">Tablet</a></li>
                                    <li><a href="#">Smartphone</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('medicalrecords.patientinfo')
    @include('medicalrecords.consultationrecords')
    @include('medicalrecords.addpatient')
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <script type="text/javascript">
        $(window).load(function(){
            $('#addpatient-modal').modal('toggle');
        })
    </script>
    <script src="{{ asset('public/js/medicalrecords/overview.js') }}"></script>
    <script src="{{ asset('public/js/medicalrecords/navigation.js') }}"></script>

  @endsection

@endcomponent

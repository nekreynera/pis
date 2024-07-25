@component('partials/header')

    @slot('title')
        PIS | Admitted Patients
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/searchpatient.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/css/patients/admitted.css') }}" />
    @stop


    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')
        <div class="container">
            <br/>
            <div class="row searchpatient">

                <form method="post" action="{{ url('searchadmitted') }}">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <a href="#" class="btn btn-success btn-sm"
                            data-toggle="tooltip"
                            title="Register new in-patient"
                            id="addinpatient">
                            <span class="fa fa-user-plus"></span> REGISTER PATIENT</a>
                    </div>
                   {{-- <div class="col-md-6">
                             <div class="form-group">
                                     <div class="input-group">
                                         <div class="input-group-btn">
                                             <button type="button" class="btn btn-default dropdown-toggle" 
                                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Filter By <span class="caret"></span>
                                             </button>
                                             <ul class="dropdown-menu">
                                                 <li><a href="" class="name">Patient Name</a></li>
                                                 <li><a href=""  class="birthday">Patient Birthday</a></li>
                                                 <li><a href="" class="barcode">Patient Barcode</a></li>
                                                 <li><a href="" class="hospital_no">Patient Hospital No.</a></li>
                                                 <li><a href="" class="created_at">Date Registered</a></li>
                                             </ul>
                                         </div><!-- /btn-group -->
                                         <input type="text" name="name" id="searchInput" class="form-control" placeholder="Search For Patient Name..." />
                                         <span class="input-group-btn">
                                             <button class="btn btn-success" type="submit">
                                                 <i class="fa fa-search"></i> Search
                                             </button>
                                         </span>
                                     </div><!-- /input-group -->
                             </div>
                         </div> --}}
                </form>
            </div>
            <br>

            @include('message.msg')

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="unprintedTable">
                    <thead>
                        <tr>
                            <th hidden></th>
                            <!-- <th><i class="fa fa-user-circle-o"></i></th> -->
                            <th>HOSPITAL#</th>
                            <!-- <th>BARCODE</th> -->
                            <th>FULLNAME</th>
                            <!-- <th>ADDRESS</th> -->
                            <th>BIRTHDAY</th>
                            <th>AGE</th>
                            <th>SEX</th>
                            <th>REGISTERED<br>DATETIME</th>
                            <!-- <th class="info">STATUS</th>
                            <th>ACTION</th> -->
                            <th>PRINT ID</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                            <th>WATCHER</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($data))
                        @foreach($data as $list)
                            <tr>
                                <td hidden></td>
                                <!-- <td><i class="fa fa-user"></i></td> -->
                                <td align="center">{{ $list->hospital_no }}</td>
                                <!-- <td align="center">{{ $list->barcode }}</td> -->
                                <td>{{ $list->last_name.', '.$list->first_name.' '.substr($list->middle_name, 0,1).'.' }} {{ $list->suffix }}</td>
                                <!-- <td>{{ $list->address }}</td> -->
                                @if($list->birthday)
                                <td align="center">{{ Carbon::parse($list->birthday)->format('M d, Y') }}</td>
                                @else
                                <td align="center">N/A</td>
                                @endif
                                 @php
                                  $agePatient = App\Patient::age($list->birthday)
                                @endphp
                                <td align="center">{{ ($agePatient)?$agePatient:'N/A' }}</td>
                                <td align="center">{{ ($list->sex == 'M')?"MALE":"FEMALE" }}</td>
                                <td align="center">{{ Carbon::parse($list->created_at)->format('M d, Y') }}<br>{{ Carbon::parse($list->created_at)->format('h:i a') }}</td>
                                {{--<!-- <td class="{{ ($list->status == 'A')?'info':'success' }}">{{ ($list->status == 'A')?"ADMITTED":"DISCHARGED" }}</td> -->
                                <!-- <td align="center">@if($list->status == 'A')
                                        <a 
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Discharge Patient"
                                        href="{{ url('dischargedpatient') }}/{{$list->id}}" 
                                        class="btn btn-success btn-circle">
                                        <span class="fa fa-user-plus"></span></a>
                                    @else
                                        <a 
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Admit Patient"
                                        href="{{ url('admitpatientbyid') }}/{{$list->id}}"
                                        class="btn btn-warning btn-circle">
                                        <span class="fa fa-user-times"></span></a>
                                    @endif
                                </td> -->--}}
                               <td align="center">
                                   <a href="{{ url('hospitalcard/'.$list->patients_id) }}"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Print Patient ID CARD"
                                        target="_blank" 
                                        data-id="{{ $list->patients_id }}" 
                                        class="btn btn-primary btn-circle">
                                       <i class="fa fa-print"></i>
                                   </a>
                               </td>
                               <td align="center">
                                   <a href="{{ url('patients/'.$list->patients_id.'/edit') }}" 
                                    data-toggle="tooltip"
                                    title="Edit Patient Information"
                                    class="btn btn-info btn-circle edit">
                                       <i class="fa fa-pencil"></i>
                                   </a>
                               </td>
                               <td align="center">
                                   <a href="{{ url('deleteinpatient/'.$list->patients_id) }}" 
                                    data-toggle="tooltip"
                                    title="Delete Patient"
                                    class="btn btn-danger btn-circle delete"
                                    onclick="return confirm('Delete This Row?')">
                                       <i class="fa fa-remove"></i>
                                   </a>
                               </td>
                                <td align="center">
                                    <a  href="#" 
                                        data-toggle="tooltip"
                                        title="Patient Watcher"
                                        class="btn btn-warning btn-circle"
                                        data-id="{{ $list->patients_id }}"
                                        id="viewwatcher">
                                        <i class="fa fa-user-plus"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @include('patients.watchermodal')
        @include('patients.addpatientmodal')

        <br><br>
    @endsection




    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/patients/unprinted.js') }}"></script>
        <script src="{{ asset('public/js/patients/admitted.js') }}"></script>
    @stop


@endcomponent

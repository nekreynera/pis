@component('partials/header')

    @slot('title')
        PIS | Classified Patient
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/css/partials/navigation.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/mss/classified.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('mss/navigation')
    @stop



    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-4 col-xs-3">
                    <button class="btn btn-primary btn-sm btn-new-sponsor">
                      <span class="fa fa-plus"> </span>
                      New
                    </button>
                </div>
                <div class="col-md-6 col-sm-8 col-xs-9  pull-right">
                    <form class="text-center" method="GET" action="">
                        <div class="input-group">
                             <!--  <div class="input-group-btn">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-search"></i> Search By <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu search-menu">
                                      <li><a href="#" class="lname">Label</a></li>
                                      <li><a href="#" class="hospital_no">Discount</a></li>
                                  </ul>
                              </div> -->
                              
                              <!-- /btn-group -->
                              <input type="text" name="patient" id="patient" onkeyup="searchsponsors($(this))" class="form-control patient input-sm" placeholder="Label, Discount..." autofocus/>
                              <span class="input-group-btn">
                                  <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                      <i class="fa fa-search"></i> Search
                                  </button>
                              </span>
                        </div>
                        <span class="fa fa-info-circle"></span> <small class="search-guide"> Label, Discount</small>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
                
            <div class="table-responsive ">
                <table class="table table-striped table-hover" id="sponsorsTable">
                    <thead>
                        <tr>
                            <th style="width: 20px;">#</th>
                            <th>Label</th>
                            <th>Discription</th>
                            <th>Discount Rate <br><small>( amount * discount )</small></th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $var)
                            <tr>
                                <th  style="background-color: #ccc;text-align: center;">{{ $key+1 }}</th>
                                <td>{{ $var->label }}</td>
                                <td class="text-center">{{ (is_numeric($var->description))? $var->description.'%' : $var->description }}</td>
                                <td class="text-right">{{ $var->discount }}</td>
                                <td class="text-center">{!! ($var->type)? '<span class="label bg-primary">Sponsor</span>' : '<span class="label bg-success">Discount</span>'  !!}</td>
                                <td class="text-center">{!! ($var->status)? '<span class="label bg-primary">Active</span>' : '<span class="label bg-danger">In-active</span>' !!}</td>
                                <td class="text-center"> 
                                    <button class="btn btn-success btn-edit-sponsor btn-sm" 
                                          data-toggle="tooltip" data-placement="top"
                                          title="click me to edit classification data"
                                          data-id="{{ $var->id }}">
                                          <i class="fa fa-pencil"></i>
                                          Edit
                                    </button>
                                    <button class="btn btn-info btn-view-monitoring btn-sm" @if(!$var->type) style="display:none;" @endif
                                          data-toggle="tooltip" data-placement="top"
                                          title="click me to view guarantor transaction summary"
                                          data-id="{{ $var->id }}">
                                          <span class="fa fa-hourglass-2"></span>
                                          Monitoring
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @include('mss.modals.sponsors.new')
    @include('mss.modals.sponsors.edit')
    @include('mss.modals.sponsors.monitoring')
    @endsection 



    @section('pagescript')
        <script>
            // $('#modal-monitoring-mss-guarantor').modal('toggle');
            var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
            var mss_user_id = '{{ Auth::user()->id }}';
        </script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/js/mss/sponsors.js') }}"></script>
    @stop


@endcomponent

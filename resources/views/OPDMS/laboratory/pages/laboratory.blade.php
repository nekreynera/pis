@component('OPDMS.partials.header')


@slot('title')
    PIS | LABORATORY
@endslot


@section('pagestyle')
    <link href="{{ asset('public/OPDMS/css/patients/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/main.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('public/OPDMS/css/patients/action.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('public/OPDMS/css/laboratory/laboratory/action.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/laboratory/sub.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/laboratory/laboratory/infolist.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('public/OPDMS/css/patients/check_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/result_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/print_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/edit_patient.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/remove.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/patient_information.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/medical_records.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/OPDMS/css/patients/transaction.css') }}" rel="stylesheet" /> -->
@endsection


@section('navigation')
    @include('OPDMS.partials.boilerplate.navigation')
@endsection


@section('dashboard')
    @component('OPDMS.partials.boilerplate.dashboard')
        {{--
            @section('search_form')
                @include('OPDMS.partials.boilerplate.search_form', ['redirector' => 'admin.search'])
            @endsection
        --}}
    @endcomponent
@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-page">

        @include('OPDMS.partials.boilerplate.header',
        ['header' => 'Laboratory', 'sub' => 'All laboratory services are showned here.'])

        <!-- Main content -->
        <section class="content laboratory-content">

            <div class="box">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-4 side-bar-container">
                        <div class="row action-sub">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            {{--<button class="btn btn-success btn-sm " id="new-sub"><i class="fa fa-plus"></i> New</button>--}}
                            <button class="btn btn-success btn-sm" id="edit-sub" data-id="1"><i class="fa fa-pencil"></i> Edit</button>
                          </div>
                         {{-- <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group">
                                      <!-- /btn-group -->
                                      <input type="text" name="sub" id="sub-search-input" class="form-control input-sm" placeholder="Pathology keyword..." autofocus/>
                                      <span class="input-group-btn">
                                          <button class="btn btn-success btn-sm" type="submit" id="search-button">
                                              <i class="fa fa-search"></i>
                                          </button>
                                      </span>
                                </div>
                              </div>
                          --}}

                        </div>              
                        <ul class="sidebar-menu ancillary-sidebar-special" data-widget="tree" id="ancillary-sidebar-special">
                            @foreach($laboratory as $list)
                            <li class="header text-uppercase" data-id={{ $list->id }}>
                              {{ $list->name }}
                            </li>
                              @foreach($sub as $sublist)
                                @if($list->id == $sublist->laboratory_id)
                                <li data-id="{{ $sublist->id }}" 
                                  class="text-capitalize">
                                  <a href="#">
                                    <span>{{ $sublist->name }}</span>
                                  </a>
                                </li>
                                @endif
                              @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-8 content-container">
                      <div class="row sub-list-action">
                          <div class="col-md-6 col-sm-6 col-xs-6 col-xxs-12">
                              <button class="btn btn-success btn-sm" id="new-list"><span class="fa fa-flask"></span> New</button>
                              <button class="btn btn-success btn-sm disabled" id="edit-list" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-6 col-xxs-12">
                              <form class="list-search text-center" id="list-search" method="POST" action="{{ url('searchlist') }}">
                                      <div class="input-group">
                                            <!-- /btn-group -->
                                            <input type="text" name="list_search" id="list-search-input" class="form-control input-sm" placeholder="Service Keyword..." autofocus/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success btn-sm" type="submit" form="#list-search">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                      </div>
                                      <!-- /input-group -->
                              </form>
                          </div>
                          
                      </div>
                      <div class="btn-group-vertical trial-click">
                        <button type="button" class="btn btn-default btn-sm" id="edit-list" data-id="#"><span class="fa fa-pencil"></span> Edit</button>
                        <a href="#" class="btn btn-default btn-sm" id="service-information" data-id="#"><span class="fa fa-info-circle"></span> Service Information </a>
                      </div>
                    @include('OPDMS.partials.loader')
                      <div class="table-responsive" style="max-height: 400px;">
                          <table class="table table-striped table-hover" id="ancillary-table">
                              <thead>
                                  <tr class="bg-gray">
                                      <th></th>
                                      <th hidden></th>
                                      <th>Service Name</th>
                                      <th>Price</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                  </tr>
                              </thead>
                              <tbody class="ancillary-tbody">
                                  @if(count($lablist) > 0)
                                    @foreach($lablist as $list)
                                    <tr data-id="{{ $list->id }}">
                                      <td><span class="fa fa-caret-right"></span></td>
                                      <td hidden></td>
                                      <td class="text-capitalize">{{ ucwords($list->name) }}</td>
                                      <td class="text-right">{{ number_format($list->price, 2, '.', '') }}</td>
                                      @if($list->status == 'Active')
                                      <td class="text-center"><small class="label bg-green">Active</small></td>
                                      @else
                                      <td class="text-center"><small class="label bg-red">Inactive</small></td>
                                      @endif
                                      <td class="text-center">{{ Carbon::parse($list->created_at)->format('m/d/Y') }}</td>
                                    </tr>
                                    @endforeach
                                  @else
                                    <tr>
                                      <td hidden></td>
                                      <td colspan="5" class="text-center text-bold"><span class="fa fa-warning"></span> Empty Data</td>
                                    </tr>
                                  @endif
                              </tbody>
                          </table>
                      </div>    
                    </div>
                    
                  </div>
                </div>

                <div class="box-footer">
                    <small>
                        <em class="text-muted">
                          Showing <b> {{ count($lablist) }} </b> result(s).
                        </em>
                    </small>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    @include('OPDMS.laboratory.modals.laboratory.newsub')
    @include('OPDMS.laboratory.modals.laboratory.editsub')
    @include('OPDMS.laboratory.modals.laboratory.newlist')
    @include('OPDMS.laboratory.modals.laboratory.editlist')
    @include('OPDMS.laboratory.modals.laboratory.infolist')
    <!-- /.content-wrapper -->
@endsection

{{--@section('footer')
    @include('OPDMS.partials.boilerplate.footer')
@endsection--}}

@section('aside')
    @include('OPDMS.partials.boilerplate.aside')
@endsection



@section('pluginscript')
    
@endsection

@section('pagescript')
    <script>
        var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
    </script>
    <script src="{{ asset('public/OPDMS/js/laboratory/main.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/action.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/sub.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/list.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/category.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/table.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/laboratory/search.js') }}"></script>
    <!-- <script src="{{ asset('public/OPDMS/js/patients/check_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/result_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/print_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/store_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/edit_patient.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/remove.js') }}"></script>-->
    <script src="{{ asset('public/OPDMS/js/laboratory/roles.js') }}"></script>
   <!--  <script src="{{ asset('public/OPDMS/js/patients/patient_information.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/medical_record.js') }}"></script>
    <script src="{{ asset('public/OPDMS/js/patients/transaction.js') }}"></script>

    <script src="{{ asset('public/OPDMS/js/patients/address.js') }}"></script> -->


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();



            $(window).load(function(){
                $('body').attr('oncontextmenu', 'return false');
            })
        });
    </script>

@endsection


@endcomponent
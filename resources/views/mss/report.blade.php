@component('partials/header')

  @slot('title')
    PIS | REPORT
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/mss/report.css?v2.0.1') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('mss/navigation')
  @endsection

  @section('content')
    <div class="container mainWrapper" id="wrapper">
        <div class="submitclassificationgenerate">
            <img src="public/images/loader.svg">
        </div>
            <h3 class="text-center">MSS REPORT <i class="fa fa-file-text-o"></i></h3>
            <form class="form-horizontal generatemssreport" method="post" action="{{ url('genaratedreport') }}">
                 {{ csrf_field() }}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>TYPE</th>
                            <th>EMPLOYEE NAME</th>
                            <th colspan="2">DATE OF TRANSACTION</th>
                        </tr>
                        <tr>
                            <td rowspan="2">
                              <br><br>
                              <select name="type" class="form-control">
                                <option value="1">STATISTICAL REPORT</option>
                                <option value="2">CLASSIFIED PATIENT REPORT</option>
                                <option value="3">SPONSORED PATIENT REPORT</option>
                              </select>
                            </td>
                            <td rowspan="2">
                                <br><br>
                                <select name="users_id" class="form-control text-capitalize" required>
                                    <option value="" hidden>--choose--</option>
                                    @if(Auth::user()->id == 41)
                                      @foreach($employee as $list);
                                      <option value="{{ $list->id }}" class="text-capitalize">{{ strtolower($list->last_name).' '.strtolower($list->first_name) }}</option>
                                      @endforeach
                                      <option value="ALL">All</option>
                                    @else
                                    <option value="{{ Auth::user()->id }}" class="text-capitalize" selected>{{ strtolower(Auth::user()->last_name).' '.strtolower(Auth::user()->first_name) }}</option>
                                    @endif
                                    
                                </select>
                            </td>
                            <td>FROM(start of date transacted)</td>
                            <td>TO(end of date transacted)</td>
                        </tr>
                        <tr>
                            <td><input type="date" name="from" class="form-control text-center" required></td>
                            <td><input type="date" name="to" class="form-control text-center" required></td>
                        </tr>
                    </table>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">GENERATE <i class="fa fa-cog"></i></button>
                </div>
            </form>
    </div>
  @endsection
  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/mss/report.js?v2.0.1') }}"></script>
  @endsection
@endcomponent

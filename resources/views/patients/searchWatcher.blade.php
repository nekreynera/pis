@component('partials/header')

    @slot('title')
        PIS | Search Watcher
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/patients/searchpatient.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('patients/navigation')
    @stop



    @section('content')


        <div class="container searchwatcher">
            

            <div class="row">
                <div class="col-md-12">
                    <br>
                    @if($watchers != 'noresult')
                        <h4 class="text-muted">Showing search results with your query <strong class="text-success">' {{ $search }} '</strong> </h4>
                    @endif

                    <br>
                </div>
                    
            

                <div class="col-md-12">
                    @if($watchers != 'noresult')
                    @if($watchers)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Hospital#</th>
                                    <th>Watchers Name</th>
                                    <th>Patients Name</th>
                                    <th>DateTime</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #fff;">
                                @foreach($watchers as $watcher)
                                    <tr>
                                        <td>{{ $watcher->hospital_no }}</td>
                                        <td>{{ $watcher->wName }}</td>
                                        <td>{{ $watcher->pName }}</td>
                                        <td>{{ Carbon::parse($watcher->created_at)->toFormattedDateString() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <hr>
                            <h4 class="text-danger text-center">No Results Found!</h4>
                        <hr>
                    @endif
                    @else
                        <hr>
                            <h4 class="text-info text-center">Please use the search box to search for watchers.</h4>
                        <hr>
                    @endif
                </div>



            </div>


        </div>

        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery-ui.min.js') }}"></script>
    @stop


@endcomponent

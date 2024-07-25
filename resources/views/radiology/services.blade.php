@component('partials/header')

    @slot('title')
        PIS | Radiology
    @endslot

    @section('pagestyle')
         <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
         <link href="{{ asset('public/css/radiology/services.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('radiology/navigation')
    @stop



    @section('content')
        
        <div class="container-fluid">
            <div class="container">

                <div class="loaderWrapper col-md-1">
                    <img src="{{ asset('public/images/loader.svg') }}" alt="loader" class="img-responsive" />
                    <p>Saving...</p>
                </div>

                @include('radiology.servicesModal')

                <div class="row">
                    <br>
                    <div class="row text-center SrvicesTitleWrapper">
                        <h2>Radiology Services</h2>
                        <a href="" class="btn btn-default" data-toggle="modal" data-target="#addServices">
                            <i class="fa fa-plus"></i> Add Service
                        </a>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CATEGORY</th>
                                    <th>DESCRIPTION</th>
                                    <th>PRICE</th>
                                    <th>STATUS</th>
                                    <th>EDIT</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($services) > 0)
                                @foreach($services as $service)
                                <tr>
                                    <td class="{{ ($service->trash == 'N')? 'trSuccess' : 'trDanger' }}">{{ $loop->index + 1 }}</td>
                                    <td class="clinic_code">{{ ($service->clinic_code == 1034)? 'X-RAY' : 'ULTRASOUND' }}</td>
                                    <td class="description">{{ $service->item_description }}</td>
                                    <td class="price">&#8369; <span>{{ number_format($service->price, 2) }}</span></td>
                                    <td class="status">
                                        {!! ($service->trash == 'N')? 
                                            '<span class="text-success">Active</span>' : 
                                            '<span class="text-danger">In-Active</span>' !!}
                                    </td>
                                    <td>
                                        <a href="#" data-id="{{ $service->id }}" onclick="radiologyEdit($(this))"
                                           class="btn btn-default btn-circle radiologyEdit"
                                            data-toggle="modal" data-target="#editServices">
                                            <i class="fa fa-pencil text-primary"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('deleteService/'.$service->id) }}" class="btn btn-default btn-circle"
                                           onclick="return confirm('Delete this radiology service?')">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    @endsection





    @section('footer')
    @stop



    @section('pagescript')
        @include('message.toaster')
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/form.js') }} "></script>
        <script src="{{ asset('public/js/radiology/services.js') }} "></script>
        
    @stop


@endcomponent

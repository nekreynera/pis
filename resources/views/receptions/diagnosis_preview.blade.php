@component('partials/header')

    @slot('title')
        PIS | Dignosis Details
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/preview.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('receptions.navigation')
@stop



@section('content')

    <div class="container-fluid">

        <div class="container">
            <div class="row">

                <h2 class="text-center">Diagnosis Details</h2>
                <br>
                <div class="diagnosisPreview">
                    {!! $diagnosis->diagnosis !!}
                </div>


                @if(count($diagnosis_icds) > 0)
                    <div class="diagnosisWrapper">
                        <br>
                        <br>
                        @foreach($diagnosis_icds as $diagnosis_icd)
                            <div class="form-group input-group">
                                <input type="text" class="form-control" value="{{ $diagnosis_icd->description }}" readonly="" />
                                <span class="input-group-addon">
                            <i class="fa fa-trash-o"></i>
                        </span>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>


    </div>

@endsection



@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent

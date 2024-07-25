@component('partials/header')

    @slot('title')
        PIS | Laboratory
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/jquery-ui.css') }}" rel="stylesheet" />
@stop



@section('header')
    @include('patients/navigation')
@stop



@section('content')
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
@stop


@endcomponent

@component('partials/header')

    @slot('title')
        PIS | Classified Patient
    @endslot

    @section('pagestyle')
        <link href="{{ asset('public/css/partials/navigation.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/css/mss/classifiedreport.css') }}" rel="stylesheet" />
    @stop



    @section('header')
        @include('mss/navigation')
    @stop



    @section('content')
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="min-width: 120px;">SPONSOR</th>
                            <th style="min-width: 100px;">DATE</th>
                            <th style="min-width: 70px;">TIME</th>
                            <th>HOSPITAL NO</th>
                            <th style="min-width: 180px;">NAME OF PATIENT</th>
                            <th>AGE</th>
                            <th>GENDER</th>
                            <th style="min-width: 320px;">ADDRESS</th>
                            <th style="min-width: 350px;">SUPPLY/SERVICES</th>
                            <th style="min-width: 90px;">AMOUNT</th>
                            <th style="min-width: 90px;">DISCOUNT</th>
                            <th style="min-width: 180px;">USER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $amount = 0;
                            $discount = 0;
                        @endphp
                        @foreach($data as $key => $var)
                            <tr>
                                <td class="text-center">{{ strtoupper($var->sponsor) }}</td>
                                <td class="text-center">{{ Carbon::parse($var->created_at)->format('m/d/Y') }}</td>
                                <td class="text-center">{{ Carbon::parse($var->created_at)->format('h:i A') }}</td>
                                <td class="text-center">{{ $var->hospital_no }}</td>
                                <td class="text-capitalize">{{ strtolower($var->last_name).', '.strtolower($var->first_name).' '.substr(strtolower($var->middle_name), 0,1) }}.</td>
                                <td class="text-center" @if(Carbon::parse($var->birthday)->age >= 60) style="font-weight: bold;color: red;" @endif>{{ Carbon::parse($var->birthday)->age }}</td>
                                <td class="text-center">{{ $var->sex }}</td>
                                <td class="text-capitalize">{{ strtolower($var->brgyDesc).', '.strtolower($var->citymunDesc) }}</td>
                                <td class="text-capitalize">{!! '(<b>'.strtoupper($var->category).'</b>) '.strtolower($var->sub_category) !!}</td>
                                <td class="text-right">{{ number_format($var->amount,3) }}</td>
                                <td class="text-right">{{ number_format($var->discount,3) }}</td>
                                <td class="text-capitalize">{{ strtolower($var->user_lname).', '.strtolower($var->user_fname).' '.substr(strtolower($var->user_mname), 0,1) }}.</td>
                            </tr>
                            @php
                            $amount+=$var->amount;
                            $discount+=$var->discount;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="9" class="text-center">TOTAL</th>
                        <th class="text-right">{{ number_format($amount,3) }}</th>
                        <th class="text-right">{{ number_format($discount,3) }}</th>
                        <th colspan="3"></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection 




    @section('pagescript')
        <script>
            var dateToday = '{{ Carbon::today()->format("m/d/Y") }}';
            var mss_user_id = '{{ Auth::user()->id }}';
        </script>
        <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    @stop


@endcomponent

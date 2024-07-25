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
                            <th style="min-width: 120px;">MSWD NO</th>
                            <th>HOSPITAL NO</th>
                            <th style="min-width: 150px;">DATE</th>
                            <th style="min-width: 200px;">NAME OF PATIENT</th>
                            <th>AGE</th>
                            <th>GENDER</th>
                            <th style="min-width: 350px;">ADDRESS</th>
                            <th>CATEGORY</th>
                            <th style="min-width: 150px;">CLASSIFICATION</th>
                            <th style="min-width: 150px;">SECTORIAL GROUPING</th>
                            <th style="min-width: 150px;">SOURCE OF REFERRAL</th>
                            <th style="min-width: 200px;">PHILHEALTH CATEGORY</th>
                            <th style="min-width: 200px;">USER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $var)
                            <tr>
                                <td class="text-center text-capitalize">
                                    {{ $var->mswd }}
                                </td>
                                <td class="text-center">{{ $var->hospital_no }}</td>
                                <td class="text-center">{{ Carbon::parse($var->created_at)->format('m/d/Y g:ia') }}</td>
                                <td class="text-capitalize">{{ strtolower($var->last_name).', '.strtolower($var->first_name).' '.substr(strtolower($var->middle_name), 0,1) }}.</td>
                                @if(Carbon::parse($var->birthday)->age >= 60)
                                <td class="text-center" style="font-weight: bold;color: red;">{{ Carbon::parse($var->birthday)->age }}</td>
                                @else
                                <td class="text-center">{{ Carbon::parse($var->birthday)->age }}</td>
                                @endif
                                <td class="text-center">{{ $var->gender }}</td>
                                <td class="text-capitalize">{{ strtolower($var->brgyDesc).', '.strtolower($var->citymunDesc) }}</td>
                                @php
                                    if($var->category == 'O'):
                                        $category = 'Old';
                                    elseif($var->category == 'N'):
                                        $category = 'New';
                                    else:
                                        $category = 'Cases Forward';
                                    endif;
                                @endphp
                                <td class="text-center">{{ $category }}</td>
                                <td class="text-center">
                                    {{ $var->mss }}
                                </td>
                                <td class="text-center">{{ $var->sectorial }}</td>
                                <td class="text-center">{{ $var->referral }}</td>
                                @php
                                    if($var->philhealth == 'M'):
                                        $philheath = 'Member';
                                    elseif($var->philhealth == 'D'):
                                        $philheath = 'Dependent';
                                    else:
                                        $philheath = '';
                                    endif;
                                @endphp
                                <td class="text-center">{{ $philheath }}-{{ $var->membership }}</td>
                                <td class="text-capitalize">{{ strtolower($var->users) }}</td>
                              
                                
                            </tr>
                        @endforeach
                    </tbody>
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

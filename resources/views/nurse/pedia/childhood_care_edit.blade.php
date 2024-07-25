@component('partials/header')

    @slot('title')
        PIS | Childhood Care Edit
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/nurse/pedia/children_care.css') }}" rel="stylesheet" />
@stop


@section('header')
    @include('nurse.pedia.navigation')
@stop



@section('content')


    <div class="loaderRefresh" style="position: fixed">
        <div class="loaderWaiting">
            <i class="fa fa-spinner fa-spin"></i>
            <span> Please Wait...</span>
        </div>
    </div>

    <div class="container" id="children_care">

        <form action="{{ url('save_early_childhood_care') }}" method="post" id="children_careForm">

            {{ csrf_field() }}


            <input type="hidden" name="updateChildhoodCare" value="{{ $data->id }}" />

            <div class="col-md-6 col-md-offset-3">


                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('public/images/doh-logo2.png') }}" class="img-responsive center-block" alt="">
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-center">
                            <strong>EARLY CHILDHOOD CARE AND DEVELOPMENT FORM</strong>
                        </h4>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('public/images/sentrong_sigla.png') }}" class="img-responsive center-block img-circle" alt="">
                    </div>
                </div>

                <br>


                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                Clinic:
                                <input type="text" name="clinic_name" value="{{ $data->clinic_name }}" class="smallInput" />
                            </td>
                            <td colspan="3">
                                Childs No.:
                                <input type="text" name="child_no" value="{{ $patient->hospital_no }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Barangay:
                                <input type="text" name="brgy"
                                       value="{{ $patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc }}"
                                       class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Family No.:
                                <input type="text" name="family" value="{{ $data->family }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Childs Name
                                <input type="text" name="childs_name"
                                       value="{{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}"
                                       class="smallInput" />
                            </td>
                            <td>
                                Sex: &nbsp; &nbsp; &nbsp;
                                <label class="normalLabel">
                                    <input type="radio" name="sex" value="M"
                                           @if($patient->sex == 'M') checked @endif> M
                                </label>
                                &nbsp; &nbsp;
                                <label class="normalLabel">
                                    <input type="radio" name="sex" value="F"
                                           @if($patient->sex == 'F') checked @endif> F
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Mothers Name:
                                <input type="text" name="mother" value="{{ $data->mother }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Educational Level:
                                <input type="text" name="education" value="{{ $data->education }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Occupation:
                                <input type="text" name="occupation" value="{{ $data->occupation }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date First Seen:
                                <input type="date" name="date_first_seen" value="{{ $data->date_first_seen }}" class="smallInput" />
                            </td>
                            <td>
                                Birth Date:
                                <input type="date" name="birth_date" value="{{ $patient->birthday }}" class="smallInput" />
                            </td>
                            <td>
                                Birth Weight:
                                <input type="text" name="birth_weight" value="{{ $data->birth_weight }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Place of delivery:
                                <input type="text" name="place_of_delivery" value="{{ $data->place_of_delivery }}" class="smallInput" />
                            </td>
                            <td colspan="2">
                                Birth registered at local civil registry (date):
                                <input type="text" name="birth_registered" value="{{ $data->birth_registered }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Complete address of family (House No., Street, City/Province):
                                <input type="text" name="complete_address" value="{{ $data->complete_address }}" class="smallInput" />
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center">BROTHERS AND SISTERS</th>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td>Sex:</td>
                            <td>Date of Birth:</td>
                        </tr>

                        <?php
                            $bro_sis = array_map('removeAsterisk', explode('^', $data->bro_sis));
                            $gender = array_map('removeAsterisk', explode('^', $data->gender));
                            $date_birth = array_map('removeAsterisk', explode('^', $data->date_birth));

                            function removeAsterisk($value){
                                if ($value == '*'){
                                    return '';
                                }else{
                                    return $value;
                                }
                        }
                        ?>
                        @for($i=0;$i<12;$i++)
                            <tr>
                                <td>
                                    <input type="text" name="bro_sis{{ $i }}" value="{{ $bro_sis[$i] }}" class="smallInput" />
                                </td>
                                <td class="text-center">
                                    <label class="normalLabel">
                                        <input type="radio" name="gender{{ $i }}" value="M"
                                            @if($gender[$i] == 'M') checked @endif> M
                                    </label>
                                    &nbsp; &nbsp; &nbsp; &nbsp;
                                    <label class="normalLabel">
                                        <input type="radio" name="gender{{ $i }}" value="F"
                                               @if($gender[$i] == 'F') checked @endif> F
                                    </label>
                                </td>
                                <td>
                                    <input type="date" name="date_birth{{ $i }}" value="{{ $date_birth[$i] }}" class="smallInput" />
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>

                </div>



            </div>

            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-bordered" id="essentialHealthTable">
                        <tr>
                            <th colspan="7" class="text-center bg-info">ESSENTIAL HEALTH AND NUTRITION SERVICES</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="6" class="text-center">DATE OF VISITS</td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>1st</td>
                            <td>2nd</td>
                            <td>3rd</td>
                            <td>4th</td>
                            <td>5th</td>
                            <td>6th</td>
                        </tr>
                        <tr>
                            <th>NEWBORN_SCREENING</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>0) class="stripedLine" @endif>
                                    @if($i<1)
                                        <input type="date" name="newborn_screening" value="{{ $data->newborn_screening }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>BCG (at birth)</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>0) class="stripedLine" @endif>
                                    @if($i<1)
                                        <input type="date" name="bcg" value="{{ $data->bcg }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>

                        <?php
                            $pv = array_map('removeAsterisk', explode('^', $data->pv));
                            $opv = array_map('removeAsterisk', explode('^', $data->opv));
                            $mmr_two = array_map('removeAsterisk', explode('^', $data->mmr_two));
                            $ipv = array_map('removeAsterisk', explode('^', $data->ipv));
                            $pcv = array_map('removeAsterisk', explode('^', $data->pcv));
                        ?>

                        <tr>
                            <th>PV (6 wks, 10 wks, 14 wks old)</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>2) class="stripedLine" @endif>
                                    @if($i<3)
                                        <input type="date" name="pv{{ $i }}" value="{{ $pv[$i] }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>OPV (6 wks, 10 wks, 14 wks old)</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>2) class="stripedLine" @endif>
                                    @if($i<3)
                                        <input type="date" name="opv{{ $i }}" value="{{ $opv[$i] }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>HEPATITIS B (6 wks, 10 wks, 14 wks old)</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>0) class="stripedLine" @endif>
                                    @if($i<1)
                                        <input type="date" name="hepatitis" value="{{ $data->hepatitis }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>MMR1</th>
                            @for($i=0;$i<6;$i++)
                                <td @if($i>0) class="stripedLine" @endif>
                                    @if($i<1)
                                        <input type="date" name="mmr_one" value="{{ $data->mmr_one }}" class="smallInput" />
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>MMR2</th>
                            @for($i=0;$i<6;$i++)
                                <td>
                                    <input type="date" name="mmr_two{{ $i }}" value="{{ $mmr_two[$i] }}" class="smallInput" />
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>IPV</th>
                            @for($i=0;$i<6;$i++)
                                <td>
                                    <input type="date" name="ipv{{ $i }}" value="{{ $ipv[$i] }}" class="smallInput" />
                                </td>
                            @endfor
                        </tr>
                        <tr>
                            <th>
                                PCV
                            </th>
                            @for($i=0;$i<6;$i++)
                                <td>
                                    <input type="date" name="pcv{{ $i }}" value="{{ $pcv[$i] }}" class="smallInput" />
                                </td>
                            @endfor
                        </tr>

                    </table>

                </div>


                <div class="buttonWrapper">
                    <a href="#0" class="cd-top js-cd-top">Top</a>
                    @if(Auth::user()->clinic == 26)
                        <button type="submit" class="btn btn-success btnSaveEssential" title="Click to save">
                            <i class="fa fa-save"></i>
                        </button>
                    @endif
                </div>


            </div>


        </form>

    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/otpc.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/childhood_care.js') }}"></script>

    @include('receptions.message.notify')

@stop


@endcomponent

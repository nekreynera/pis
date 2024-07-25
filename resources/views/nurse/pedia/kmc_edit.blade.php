@component('partials/header')

@slot('title')
PIS | KMC
@endslot

@section('pagestyle')
    <link href="{{ asset('public/plugins/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/nurse/pedia/kmc.css') }}" rel="stylesheet" />
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

    <div class="container">




        <div class="col-md-10 col-md-offset-1">



            <form action="{{ url('kmc_store') }}" method="post" id="kmc_form">

                {{ csrf_field() }}


                <input type="hidden" name="updatedKMC" value="{{ $data->id }}" />

                <input type="hidden" name="patient_id" value="{{ $data->patient_id }}" />

                <div class="table-responsive">

                    <h5 class="text-center"><strong>KMC (Kangaroo Mother Care Program)</strong></h5>

                    <table class="table table-bordered" id="kmc_table">
                        <tbody>
                        <tr>
                            <td>Baby's Name:
                                <input type="text" class="smallInput"
                                       value="{{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}" readonly style="width: 80%"/>
                            </td>
                            <td>KMC #:
                                <input type="text" name="kmc_no" value="{{ $data->kmc_no }}" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Mother's Name:
                                <input type="text" name="mother" value="{{ $data->mother }}" class="smallInput" style="width: 80%"/>
                            </td>
                            <td>AOG:
                                <input type="text" name="aog" value="{{ $data->aog }}" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:
                                <input type="text" class="smallInput"
                                       value="{{ $patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc }}"
                                       style="width: 80%" readonly/>
                            </td>
                            <td>Birth Weight:
                                <input type="text" class="smallInput" name="birth_weight" value="{{ $data->birth_weight }}" style="width: 20%"/>
                                Discharge Weight:
                                <input type="text" class="smallInput" name="discharge_weight" value="{{ $data->discharge_weight }}" style="width: 20%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Birthday:
                                <input type="text" class="smallInput"
                                       value="{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}" readonly style="width: 30%"/>
                            </td>
                            <td>Contact #:
                                <input type="text" name="contact_no" value="{{ $data->contact_no }}" class="smallInput" style="width: 60%"/>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center titleHead" colspan="2">Follow-up</th>
                        </tr>
                        <tr>
                            <td>Date: <input type="date" class="smallInput" name="date_ff" value="{{ $data->date_ff }}" style="width: 50%"/></td>
                            <td>Head Circumference: <input type="text" name="head_circumference" value="{{ $data->head_circumference }}" class="smallInput" style="width: 20%"/> &nbsp;
                                Temperature: <input type="text" name="temperature" value="{{ $data->temperature }}" class="smallInput" style="width: 20%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Age: &nbsp;
                                <input type="text" name="month" class="smallInput" value="{{ $data->month }}" placeholder="Month" style="width: 20%"/> Month.
                                <input type="text" name="week" class="smallInput" value="{{ $data->week }}" placeholder="Week" style="width: 20%"/> Week.
                                <input type="text" name="days" class="smallInput" value="{{ $data->days }}" placeholder="Days" style="width: 20%"/> Days.
                            </td>
                            <td>Corrected Age:
                                <input type="text" name="corrected_age" value="{{ $data->corrected_age }}" class="smallInput" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Weight: <input type="text" name="weight" value="{{ $data->weight }}" class="smallInput" style="width: 30%"/></td>
                            <td>Body Length/Height: <input type="text" name="body_length_height" value="{{ $data->weight }}" class="smallInput" style="width: 30%"/></td>
                        </tr>
                        <tr>

                            <?php

                            $feed = ($data->feeding)? unserialize($data->feeding) : false;
                            $wayofadministration = ($data->way_of_administration)? unserialize($data->way_of_administration) : false;

                            ?>
                            <td>Feeding: <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="feed[]" value="Human Milk"
                                           @if($feed) @if(in_array('Human Milk', $feed)) checked="checked" @endif @endif>Human Milk
                                </label>
                                <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Mixed"
                                    @if($feed) @if(in_array('Mixed', $feed)) checked="checked" @endif @endif>Mixed
                                </label>
                                <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Formula Milk"
                                    @if($feed) @if(in_array('Formula Milk', $feed)) checked="checked" @endif @endif>Formula Milk
                                </label>
                            </td>
                            <td>Way of administration: <br/>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Breast"
                                    @if($wayofadministration) @if(in_array('Breast', $wayofadministration)) checked="checked" @endif @endif>Breast</label>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Bottle"
                                    @if($wayofadministration) @if(in_array('Bottle', $wayofadministration)) checked="checked" @endif @endif>Bottle</label>
                                <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Tube"
                                    @if($wayofadministration) @if(in_array('Tube', $wayofadministration)) checked="checked" @endif @endif>Tube</label>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center titleHead" colspan="2">Clinical DX</th>
                        </tr>
                        <tr>
                            <?php



                                if($data->condition_of_baby){
                                    $conditionOfBaby = ($data->condition_of_baby == 'Not Well')? true : false;
                                }else{
                                    $conditionOfBaby = false;
                                }
                                $not_well = ($data->not_well)? unserialize($data->not_well) : false;


                            ?>
                            <td><label><input type="radio" name="condition_of_baby" value="Well Baby"
                                    @if($data->condition_of_baby == 'Well Baby') checked="checked" @endif/> Well Baby</label>
                                </td>
                            <td class="notwell">
                                <label><input type="radio" name="condition_of_baby" value="Not Well"
                                    @if($conditionOfBaby) checked="checked" @endif/> Not Well</label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                           @if($conditionOfBaby)
                                                 @if($not_well)
                                                       @if(in_array('Infectious Diseases', $not_well)) checked="checked" @endif
                                                 @endif
                                           @else
                                                 disabled
                                           @endif
                                           name="notwell[]" value="Infectious Diseases">Infectious Diseases</label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                            @if($conditionOfBaby)
                                                @if($not_well)
                                                    @if(in_array('Aspiration Pneumonia', $not_well)) checked="checked" @endif
                                                @endif
                                            @else
                                                disabled
                                            @endif name="notwell[]" value="Aspiration Pneumonia">
                                    Aspiration Pneumonia
                                </label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                    @if($conditionOfBaby)
                                        @if($not_well)
                                            @if(in_array('Anemia', $not_well)) checked="checked" @endif
                                        @endif
                                    @else
                                        disabled
                                    @endif name="notwell[]" value="Anemia">
                                    Anemia
                                </label>
                                <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox"
                                    @if($conditionOfBaby)
                                        @if($not_well)
                                            @if(in_array('Hypoglycemia', $not_well)) checked="checked" @endif
                                        @endif
                                    @else
                                        disabled
                                    @endif name="notwell[]" value="Hypoglycemia">Hypoglycemia
                                </label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    @if($conditionOfBaby)
                                        @if($not_well)
                                            @if(in_array('Failure to thrive', $not_well)) checked="checked" @endif
                                        @endif
                                    @else
                                        disabled
                                    @endif name="notwell[]" value="Failure to thrive">Failure to thrive</label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    @if($conditionOfBaby)
                                        @if($not_well)
                                            @if(in_array('Hemorrhagic illness', $not_well)) checked="checked" @endif
                                        @endif
                                    @else
                                        disabled
                                    @endif name="notwell[]" value="Hemorrhagic illness">Hemorrhagic illness</label>
                                <br/>
                                <label class="checkbox-inline"><input type="checkbox"
                                    @if($conditionOfBaby)
                                        @if($not_well)
                                            @if(in_array('Others', $not_well)) checked="checked" @endif
                                        @endif
                                    @else
                                        disabled
                                    @endif name="notwell[]" value="Others">Others:</label>
                                <input type="text" class="smallInput"
                                @if($conditionOfBaby)
                                    @if($not_well)
                                        @if(in_array('Others', $not_well))
                                            value="{{ $data->not_well_others }}"
                                        @else
                                            disabled
                                        @endif
                                    @endif
                                @else
                                    disabled
                                @endif
                                 name="not_well_others" style="width: 50%"/>
                            </td>
                        </tr>
                        <tr>
                            <?php



                                $neurological = ($data->neuro)? unserialize($data->neuro) : false;
                                $chronic = ($data->chronic_pathology)? unserialize($data->chronic_pathology) : false;


                            ?>
                            <td class="notwell"><strong>Neurological Status:</strong> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        @if($neurological) @if(in_array('Hypertania', $neurological)) checked="checked" @endif @endif
                                           value="Hypertania">Hypertania
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        @if($neurological) @if(in_array('Hypotania', $neurological)) checked="checked" @endif @endif
                                           value="Hypotania">Hypotania
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        @if($neurological) @if(in_array('Dystonia', $neurological)) checked="checked" @endif @endif
                                           value="Dystonia">Dystonia
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="neurological[]"
                                        @if($neurological) @if(in_array('Normal', $neurological)) checked="checked" @endif @endif
                                           value="Normal">Normal
                                    </label> <br/>
                            </td>
                            <td class="notwell"><strong>Ongoing Chronic Pathology:</strong> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="chronicpathology[]"
                                        @if($chronic) @if(in_array('Respiratory', $chronic)) checked="checked" @endif @endif
                                           value="Respiratory">Respiratory
                                </label> <br/>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="chronicpathology[]"
                                        @if($chronic) @if(in_array('Neurological', $chronic)) checked="checked" @endif @endif
                                           value="Neurological">Neurological
                                </label> <br/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Prescription:
                                <textarea id="" cols="30" rows="5" style="font-size: 12px" name="prescription"
                                          placeholder="Type your prescription here..." class="form-control">{{ $data->prescription}}</textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="buttonWrapper">
                        <a href="#0" class="cd-top js-cd-top">Top</a>
                        @if(Auth::user()->clinic == 26)
                            <button type="submit" class="btn btn-success btnSave" title="Click to save">
                                <i class="fa fa-save"></i>
                            </button>
                        @endif
                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection



@section('footer')
@stop



@section('pagescript')

    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/nurse/pedia/kmc.js') }}"></script>

    @include('receptions.message.notify')

@stop


@endcomponent

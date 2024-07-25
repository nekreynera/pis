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


            <input type="hidden" name="patient_id" value="{{ $patient->id }}" />

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
                            <input type="text" name="kmc_no" class="smallInput" style="width: 50%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Mother's Name:
                            <input type="text" name="mother" class="smallInput" style="width: 80%"/>
                        </td>
                        <td>AOG:
                            <input type="text" name="aog" class="smallInput" style="width: 50%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:
                            <input type="text" class="smallInput"
                                   value="{{ $patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc }}"
                                   style="width: 80%" readonly/>
                        </td>
                        <td>Birth Weight:
                            <input type="text" class="smallInput" name="birth_weight" style="width: 20%"/>
                            Discharge Weight:
                            <input type="text" class="smallInput" name="discharge_weight" style="width: 20%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Birthday:
                            <input type="text" class="smallInput"
                                   value="{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}" readonly style="width: 30%"/>
                        </td>
                        <td>Contact #:
                            <input type="text" name="contact_no" value="{{ $patient->contact_no }}" class="smallInput" style="width: 60%"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center titleHead" colspan="2">Follow-up</th>
                    </tr>
                    <tr>
                        <td>Date: <input type="date" class="smallInput" name="date_ff" style="width: 50%"/></td>
                        <td>Head Circumference: <input type="text" name="head_circumference" class="smallInput" style="width: 20%"/> &nbsp;
                            Temperature: <input type="text" name="temperature" class="smallInput" style="width: 20%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Age: &nbsp;
                            <input type="text" name="month" class="smallInput" placeholder="Month" style="width: 20%"/> Month.
                            <input type="text" name="week" class="smallInput" placeholder="Week" style="width: 20%"/> Week.
                            <input type="text" name="days" class="smallInput" placeholder="Days" style="width: 20%"/> Days.
                        </td>
                        <td>Corrected Age:
                            <input type="text" name="corrected_age" class="smallInput" style="width: 50%"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Weight: <input type="text" name="weight" class="smallInput" style="width: 30%"/></td>
                        <td>Body Length/Height: <input type="text" name="body_length_height" class="smallInput" style="width: 30%"/></td>
                    </tr>
                    <tr>
                        <td>Feeding: <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Human Milk">Human Milk</label>
                            <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Mixed">Mixed</label>
                            <label class="checkbox-inline"><input type="checkbox" name="feed[]" value="Formula Milk">Formula Milk</label>
                        </td>
                        <td>Way of administration: <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Breast">Breast</label>
                            <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Bottle">Bottle</label>
                            <label class="checkbox-inline"><input type="checkbox" name="wayofadministration[]" value="Tube">Tube</label>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center titleHead" colspan="2">Clinical DX</th>
                    </tr>
                    <tr>
                        <td><label><input type="radio" name="condition_of_baby" value="Well Baby" /> Well Baby</label>
                        <td class="notwell">
                            <label><input type="radio" name="condition_of_baby" value="Not Well" /> Not Well</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Infectious Diseases">Infectious Diseases</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Aspiration Pneumonia">Aspiration Pneumonia</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Anemia">Anemia</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Hypoglycemia">Hypoglycemia</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Failure to thrive">Failure to thrive</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Hemorrhagic illness">Hemorrhagic illness</label>
                            <br/>
                            <label class="checkbox-inline"><input type="checkbox" disabled name="notwell[]" value="Others">Others:</label>
                            <input type="text" class="smallInput" disabled name="not_well_others" style="width: 50%"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="notwell"><strong>Neurological Status:</strong> <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="neurological[]" value="Hypertania">Hypertania</label> <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="neurological[]" value="Hypotania">Hypotania</label> <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="neurological[]" value="Dystonia">Dystonia</label> <br/>
                            <label class="checkbox-inline"><input type="checkbox" name="neurological[]" value="Normal">Normal</label> <br/>
                        </td>
                        <td class="notwell"><strong>Ongoing Chronic Pathology:</strong> <br/>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="chronicpathology[]" value="Respiratory">Respiratory
                            </label> <br/>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="chronicpathology[]" value="Neurological">Neurological
                            </label> <br/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Prescription:
                            <textarea id="" cols="30" rows="5" style="font-size: 12px" name="prescription" placeholder="Type your prescription here..." class="form-control"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>


            <div class="buttonWrapper">
                <a href="#0" class="cd-top js-cd-top">Top</a>
                <button type="submit" class="btn btn-success btnSave" title="Click to save">
                    <i class="fa fa-save"></i>
                </button>
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

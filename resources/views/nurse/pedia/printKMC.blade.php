<style>
    table{
        font-size: 10px;
    }
    .titleHead{
        text-align: center;
        background-color: #ccc;
    }
</style>

<div>
    <table border="1">
        <tbody>
        <tr>
            <td>Baby's Name:
                {{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}
            </td>
            <td>KMC #:
                {{ $data->kmc_no }}
            </td>
        </tr>
        <tr>
            <td>Mother's Name:
                {{ $data->mother }}
            </td>
            <td>AOG:
                "{{ $data->aog }}
            </td>
        </tr>
        <tr>
            <td>Address:
                {{ $patient->provDesc.' '.$patient->citymunDesc.' '.$patient->brgyDesc }}
            </td>
            <td><span style="margin-right: 100px">Birth Weight:
                {{ $data->birth_weight }}
                </span>
                Discharge Weight:
                {{ $data->discharge_weight }}
            </td>
        </tr>
        <tr>
            <td>Birthday:
                {{ Carbon::parse($patient->birthday)->toFormattedDateString() }}
            </td>
            <td>Contact #:
                {{ $data->contact_no }}
            </td>
        </tr>
        <tr>
            <th class="titleHead" colspan="2">Follow-up</th>
        </tr>
        <tr>
            <td>Date: {{ $data->date_ff }}</td>
            <td>Head Circumference: {{ $data->head_circumference }} &nbsp;
                Temperature: {{ $data->temperature }}
            </td>
        </tr>
        <tr>
            <td>Age: &nbsp;
                {{ $data->month }} Month.
                {{ $data->week }} Week.
                {{ $data->days }} Days.
            </td>
            <td>Corrected Age:
                {{ $data->corrected_age }}
            </td>
        </tr>
        <tr>
            <td>Weight: {{ $data->weight }}</td>
            <td>Body Length/Height: {{ $data->weight }}</td>
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
            <th class="titleHead" colspan="2">Clinical DX</th>
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
            <td>
                <input type="checkbox" name="condition_of_baby" value="Well Baby"
                    @if($data->condition_of_baby == 'Well Baby') checked="checked" @endif/> Well Baby
                </td>
            <td>
                <label><input type="checkbox" name="condition_of_baby" value="Not Well"
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
                <label class="checkbox-inline">
                    <input type="checkbox"
                    @if($conditionOfBaby)
                        @if($not_well)
                            @if(in_array('Failure to thrive', $not_well)) checked="checked" @endif
                                                      @endif
                                                      @else
                                                      disabled
                                                      @endif name="notwell[]" value="Failure to thrive">Failure to thrive</label>
                <br/>
                <label class="checkbox-inline">
                    <input type="checkbox"
                    @if($conditionOfBaby)
                        @if($not_well)
                            @if(in_array('Hemorrhagic illness', $not_well)) checked="checked" @endif
                                                      @endif
                                                      @else
                                                      disabled
                                                      @endif name="notwell[]" value="Hemorrhagic illness">Hemorrhagic illness</label>
                <br/>
                <label class="checkbox-inline">
                    <input type="checkbox"
                    @if($conditionOfBaby)
                        @if($not_well)
                            @if(in_array('Others', $not_well)) checked="checked" @endif
                                                      @endif
                                                      @else
                                                      disabled
                                                      @endif name="notwell[]" value="Others">Others:</label>
                @if($conditionOfBaby)
                    @if($not_well)
                        @if(in_array('Others', $not_well))
                            {{ $data->not_well_others }}
                        @endif
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <?php



            $neurological = ($data->neuro)? unserialize($data->neuro) : false;
            $chronic = ($data->chronic_pathology)? unserialize($data->chronic_pathology) : false;


            ?>
            <td class="notwell">Neurological Status: <br/>
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
            <td class="notwell">Ongoing Chronic Pathology: <br/>
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
                                <p style="margin: 30px 30px">{{ $data->prescription}}</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
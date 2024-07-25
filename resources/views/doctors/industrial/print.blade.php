<style>
    #industrialForm{
        font-family: courier;
    }
    .industrialFormcLASS{
        font-size: 10px;
    }
    .dateOfConsult{
        font-size: 12px;
        padding: 5px;
        outline-color: green;
    }
    #industrialForm table .checkbox{
        margin: 0;
    }
    #industrialForm .smallInput{
        width: 30px;
    }
    #industrialForm .styledForm{
        height: 30px;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #ccc;
        outline: none;
        font-family: courier, monospace;
        transition: border .3s;
    }
    #industrialForm .styledForm:focus{
        border-bottom: 1px solid green;
    }
    #industrialForm h5 strong{
        color: green;
    }
    #industrialForm .styledFormSmall{
        height: 30px;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #ccc;
        outline: none;
        font-family: courier, monospace;
        transition: border .3s;
        width: 6%;
    }
    #industrialForm .styledFormSmall:focus{
        border-bottom: 1px solid green;
    }
    #industrialForm .strng{
        font-weight: bolder;
        color: #008000;
    }
    #industrialForm .styledFormat{
        height: 30px;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #ccc;
        outline: none;
        font-family: courier, monospace;
        transition: border .3s;
        width: 60%;
    }
    #industrialForm .styledFormat:focus{
        border-bottom: 1px solid green;
    }
    #industrialForm .lastInputBox{
        width: 70%;
    }
    .printIConIndustrial{
        display: none;
    }
</style>



<div id="industrialForm" class="industrialFormcLASS">



<div class="form-group">
    <label for="">Name: &nbsp; </label>
    <strong style="font-size: 12px;color: green">
        {{ $patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name }}
    </strong>
</div>



<div class="form-group">
    <label for="">Date of Consult: &nbsp; </label>
    <input type="text" name="date_consulted" class="dateOfConsult"
    @if($industrialConsultations)
           value="{{ $industrialConsultations->date_consulted }}"
           @else
           value="{{ Carbon::now()->toDateString() }}"
            @endif/>
</div>


<div class="form-group">
    <textarea name="result" id="" class="form-control" cols="105" rows="8" style="border: 12px solid red">
        {{ $industrialConsultations->result or '' }}
    </textarea>
</div>




<div class="row">




    <?php
    $heentArray = array();
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $heentArray = explode(',', $industrialConsultations->system_reviews->heent);
    }
    ?>

        <br/>
        <br/>
        <br/>
        <br/>

        <p>Review of Systems:</p>



                <table class="table table-condensed" style="display: inline">
                    <thead>
                    <tr>
                        <th><em>HEENT</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$heentArray)) checked @endif
                                    name="heent[]" value="1">Blurring of Vision</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$heentArray)) checked @endif
                                    name="heent[]" value="2">Ringing of Ears</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$heentArray)) checked @endif
                                    name="heent[]" value="3">Eye Redness</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>



    <?php
    $gastrointestinalArray = array();
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $gastrointestinalArray = explode(',', $industrialConsultations->system_reviews->gastrointestinal);
    }
    ?>

    
                <table class="table table-condensed" style="display: inline;margin-left: 300px">
                    <thead>
                    <tr>
                        <th><em>Gastrointestinal</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$gastrointestinalArray)) checked @endif
                                    name="gastrointestinal[]" value="1">Abdominal Pain</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$gastrointestinalArray)) checked @endif
                                    name="gastrointestinal[]" value="2">Jaundice</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$gastrointestinalArray)) checked @endif
                                    name="gastrointestinal[]" value="3">Nausea/Vomiting</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$gastrointestinalArray)) checked @endif
                                    name="gastrointestinal[]" value="4">Diarrhea</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(5,$gastrointestinalArray)) checked @endif
                                    name="gastrointestinal[]" value="5">Melena/Hematochezia</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>


    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $neurologicArray = explode(',', $industrialConsultations->system_reviews->neurologic);
    }else{
        $neurologicArray = array();
    }
    ?>

    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Neurologic</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$neurologicArray)) checked @endif
                                    name="neurologic[]" value="1">Weakness</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$neurologicArray)) checked @endif
                                    name="neurologic[]" value="2">Numbness/Paresthesia</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$neurologicArray)) checked @endif
                                    name="neurologic[]" value="3">Headache</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$neurologicArray)) checked @endif
                                    name="neurologic[]" value="4">Dizziness</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(5,$neurologicArray)) checked @endif
                                    name="neurologic[]" value="5">Galt Disturbances</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>





<div class="row">



    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $respiratoryArray = explode(',', $industrialConsultations->system_reviews->respiratory);
    }else{
        $respiratoryArray = array();
    }
    ?>


    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Respiratory</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$respiratoryArray)) checked @endif
                                    name="respiratory[]" value="1">Difficulty of Breathing</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$respiratoryArray)) checked @endif
                                    name="respiratory[]" value="2">Wheezes</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$respiratoryArray)) checked @endif
                                    name="respiratory[]" value="3">Hemoptysis</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $genitourinaryArray = explode(',', $industrialConsultations->system_reviews->genitourinary);
    }else{
        $genitourinaryArray = array();
    }
    ?>


    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Genitourinary</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$genitourinaryArray)) checked @endif
                                    name="genitourinary[]" value="1">Frequency</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$genitourinaryArray)) checked @endif
                                    name="genitourinary[]" value="2">Hematuria</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$genitourinaryArray)) checked @endif
                                    name="genitourinary[]" value="3">Passage of sandy material</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$genitourinaryArray)) checked @endif
                                    name="genitourinary[]" value="4">Dribbling</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(5,$genitourinaryArray)) checked @endif
                                    name="genitourinary[]" value="5">Hesitancy</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $musculoskeletalArray = explode(',', $industrialConsultations->system_reviews->musculoskeletal);
    }else{
        $musculoskeletalArray = array();
    }
    ?>

    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Musculoskeletal</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$musculoskeletalArray)) checked @endif
                                    name="musculoskeletal[]" value="1">Muscle Pain</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$musculoskeletalArray)) checked @endif
                                    name="musculoskeletal[]" value="2">Bore Pain</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$musculoskeletalArray)) checked @endif
                                    name="musculoskeletal[]" value="3">Sprain/Strain</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$musculoskeletalArray)) checked @endif
                                    name="musculoskeletal[]" value="4">Joint Pains</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>





<div class="row">


    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $cardiovascularArray = explode(',', $industrialConsultations->system_reviews->cardiovascular);
    }else{
        $cardiovascularArray = array();
    }
    ?>


    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Cardiovascular</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$cardiovascularArray)) checked @endif
                                    name="cardiovascular[]" value="1">Chest Pain</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$cardiovascularArray)) checked @endif
                                    name="cardiovascular[]" value="2">Orthopnea</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$cardiovascularArray)) checked @endif
                                    name="cardiovascular[]" value="3">Paroxysmal Nocturnal Dyspnea</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$cardiovascularArray)) checked @endif
                                    name="cardiovascular[]" value="4">Easy Fatigability</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(5,$cardiovascularArray)) checked @endif
                                    name="cardiovascular[]" value="5">Edegma</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-4">

        <?php
        if($industrialConsultations && $industrialConsultations->system_reviews){
            $metabolic_endocrineArray = explode(',', $industrialConsultations->system_reviews->metabolic_endocrine);
        }else{
            $metabolic_endocrineArray = array();
        }
        ?>

        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Metabolic/Endocrine</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$metabolic_endocrineArray)) checked @endif
                                    name="metabolic_endocrine[]" value="1">Polyuria</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$metabolic_endocrineArray)) checked @endif
                                    name="metabolic_endocrine[]" value="2">Polydipsia</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$metabolic_endocrineArray)) checked @endif
                                    name="metabolic_endocrine[]" value="3">Polyphagia</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(4,$metabolic_endocrineArray)) checked @endif
                                    name="metabolic_endocrine[]" value="4">Unexplained Weight Loss/Gain</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    if($industrialConsultations && $industrialConsultations->system_reviews){
        $skin_integumentArray = explode(',', $industrialConsultations->system_reviews->skin_integument);
    }else{
        $skin_integumentArray = array();
    }
    ?>

    <div class="col-md-4">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th><em>Skin/Integument</em></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(1,$skin_integumentArray)) checked @endif
                                    name="skin_integument[]" value="1">Pallor</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(2,$skin_integumentArray)) checked @endif
                                    name="skin_integument[]" value="2">Cyanosis</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" @if(in_array(3,$skin_integumentArray)) checked @endif
                                    name="skin_integument[]" value="3">Rashes</label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




</div>


<?php
if($industrialConsultations && $industrialConsultations->industrial_history){
    $history = true;
}else{
    $history = false;
}
?>


<div class="row">

    <div class="col-md-4">
        <h5><strong>Past Medical History</strong></h5>
        <br/>
        <div class="form-inline">
            <label>Illnesses:</label>
            <input type="text" name="illnesses" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->illnesses }}"
                    @endif />
        </div>
        <br/>
        <div class="form-inline">
            <label>Hospitalization:</label>
            <input type="text" name="hospitalization" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->hospitalization }}"
                    @endif/>
        </div>
        <br/>
        <div class="form-inline">
            <label>Allergies:</label>
            <input type="text" name="allergies" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->allergies }}"
                    @endif/>
        </div>
    </div>

    <div class="col-md-4">
        <h5><strong>Personal/Social History</strong></h5>
        <br/>
        <div class="form-inline">
            <label for="">Smoker? </label>
            <div class="radio">
                <label><input type="radio" name="smoker" value="Yes"
                    @if($history)
                        @if($industrialConsultations->industrial_history->smoker == 'Yes')
                              checked
                                @endif
                            @endif> Yes,</label>
                <label><input type="radio" name="smoker" value="No"
                    @if($history)
                        @if($industrialConsultations->industrial_history->smoker == 'No')
                              checked
                                @endif
                            @endif> No</label>
            </div>
        </div>
        <br/>
        <div class="form-inline">
            <label>Pack Year?</label>
            <input type="text" name="packyear" maxlength="20" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->packyear }}"
                    @endif/>
        </div>
        <br/>
        <div class="form-inline">
            <label>Alcohol Beverage Drinker?</label>
            <input type="text" name="drinker" maxlength="20" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->drinker }}"
                    @endif/>
        </div>
    </div>


    <?php
    if($industrialConsultations && $history){
        $obstetric = explode(',', $industrialConsultations->industrial_history->obstetric);
    }
    ?>

    <div class="col-md-4">
        <h5><strong>Obstetric/Menstrual History</strong></h5>
        <br/>
        <div class="form-inline">
            <label for="">G</label>
            <input type="text" name="obstetric1" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[0] or '' }}"  @endif/>
            <label for="">P</label>
            <input type="text" name="obstetric2" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[1] or '' }}"  @endif/>

            <strong style="font-size: 20px">(</strong>
            <input type="text" name="obstetric3" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[2] or '' }}"  @endif/>,
            <input type="text" name="obstetric4" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[3] or '' }}"  @endif/>,
            <input type="text" name="obstetric5" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[4] or '' }}"  @endif/>,
            <input type="text" name="obstetric6" maxlength="2" class="smallInput"
            @if($industrialConsultations && $history) value="{{ $obstetric[5] or '' }}"  @endif/>
            <strong style="font-size: 20px">)</strong>
        </div>
        <br/>
        <div class="form-inline">
            <label>Age of Menarche</label>
            <input type="text" name="menarche" maxlength="20" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->menarche }}"
                    @endif/>
        </div>
        <br/>
        <div class="form-inline">
            <label>Age of First Coitus</label>
            <input type="text" name="coitus" maxlength="20" class="styledForm"
            @if($history)
                   value="{{ $industrialConsultations->industrial_history->coitus }}"
                    @endif/>
        </div>
    </div>



</div>


<br/>
<br/>
<br/>
<br/>
<br/>


<?php
if($gastrointestinalArray && $industrialConsultations->physical_exams){
    $pe = true;
}else{
    $pe = false;
}
?>

<div class="col-md-12 row">
    <div class="form-inline">
        <label>Physical Examination: </label>
        <strong class="strng">BP</strong>
        <input type="text" name="bp" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->bp }}" @endif/>
        <label>mmHg,</label>
        <strong class="strng">HR</strong>
        <input type="text" name="hr" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->hr }}" @endif/>
        <label>bpm,</label>
        <strong class="strng">RR</strong>
        <input type="text" name="rr" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->rr }}" @endif/>
        <label>cpm,</label>
        <strong class="strng">Temp</strong>
        <input type="text" name="temp" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->temp }}" @endif/>
        <label> &#176;C,</label>
        <strong class="strng">BMI</strong>
        <input type="text" name="bmi" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->bmi }}" @endif/>
        <strong class="strng">WT.</strong>
        <input type="text" name="wt" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->wt }}" @endif/>
        <strong class="strng">HT.</strong>
        <input type="text" name="ht" class="styledFormSmall"
        @if($pe) value="{{ $industrialConsultations->physical_exams->ht }}" @endif/>
    </div>
</div>



<?php
if($industrialConsultations && $industrialConsultations->industrial_surveys){
    $surveys = true;
    $srv = $industrialConsultations->industrial_surveys;
}else{
    $surveys = false;
}
//dd($surveys);
?>

<div class="row">
    <br/><br/><br/><br/><br/>
    <div class="col-md-2">
        <label for="">General Survey: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="general_surveyRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->general_survey == '0')? 'checked' : '' }} @endif>
                    No Significant Findings
                </label>
            </div>
            <div class="radio">
                <label><input type="radio" name="general_surveyRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->general_survey != '0' && $srv->general_survey != null)? 'checked' : '' }} @endif>
                    Noted the following
                </label>
                <input type="text" name="general_survey" class="styledFormat"
                @if($surveys)
                    @if($srv->general_survey != '0' && $srv->general_survey != null)
                       value="{{ $srv->general_survey }}"
                            @elseif($srv->general_survey == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <label for="">Skin/Integument: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="skin_integumentRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->skin_integument == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="skin_integumentRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->skin_integument != '0' && $srv->skin_integument != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_skin_integument" class="styledFormat"
                @if($surveys)
                    @if($srv->skin_integument != '0' && $srv->skin_integument != null)
                       value="{{ $srv->skin_integument }}"
                            @elseif($srv->skin_integument == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <label for="">HEENT: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="heentRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->heent == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="heentRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->heent != '0' && $srv->heent != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_heent" class="styledFormat"
                @if($surveys)
                    @if($srv->heent != '0' && $srv->heent != null)
                       value="{{ $srv->heent }}"
                            @elseif($srv->heent == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <label for="">Respiratory: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="respiratoryRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->respiratory == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="respiratoryRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->respiratory != '0' && $srv->respiratory != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_respiratory" class="styledFormat"
                @if($surveys)
                    @if($srv->respiratory != '0' && $srv->respiratory != null)
                       value="{{ $srv->respiratory }}"
                            @elseif($srv->respiratory == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-2">
        <label for="">Cardiovascular: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="cardiovascularRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->cardiovascular == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="cardiovascularRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->cardiovascular != '0' && $srv->cardiovascular != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_cardiovascular" class="styledFormat"
                @if($surveys)
                    @if($srv->cardiovascular != '0' && $srv->cardiovascular != null)
                       value="{{ $srv->cardiovascular }}"
                            @elseif($srv->cardiovascular == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <label for="">Gastrointestinal: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="gastrointestinalRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->gastrointestinal == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="gastrointestinalRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_gastrointestinal" class="styledFormat"
                @if($surveys)
                    @if($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)
                       value="{{ $srv->gastrointestinal }}"
                            @elseif($srv->gastrointestinal == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-2">
        <label for="">Genitourinary: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="genitourinaryRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->genitourinary == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="genitourinaryRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->genitourinary != '0' && $srv->genitourinary != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_genitourinary" class="styledFormat"
                @if($surveys)
                    @if($srv->genitourinary != '0' && $srv->genitourinary != null)
                       value="{{ $srv->genitourinary }}"
                            @elseif($srv->genitourinary == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <label for="">Neurologic: </label>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <div class="radio">
                <label><input type="radio" name="neurologicRadio" class="surveyNoFindings" value="0"
                    @if($surveys) {{ ($srv->neurologic == '0')? 'checked' : '' }} @endif> No Significant Findings</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="neurologicRadio" class="surveyNoted" value="1"
                    @if($surveys) {{ ($srv->neurologic != '0' && $srv->neurologic != null)? 'checked' : '' }} @endif> Noted the following</label>
                <input type="text" name="survey_neurologic" class="styledFormat"
                @if($surveys)
                    @if($srv->neurologic != '0' && $srv->neurologic != null)
                       value="{{ $srv->neurologic }}"
                            @elseif($srv->neurologic == '0')
                       disabled
                            @endif
                        @endif/>
            </div>
        </div>
    </div>
</div>


<br/>
<br/>
<br/>


<?php
if($gastrointestinalArray && $industrialConsultations->final_results){
    $fin = true;
    $fn = $industrialConsultations->final_results;
}else{
    $fin = false;
}
?>


<div class="row">
    <div class="col-md-12">
        <label for="">Assesment: </label>
        <input type="text" name="assesment" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->assesment }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Plan: </label>
        <input type="text" name="plan" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->plan }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Diagnostic: </label>
        <input type="text" name="diagnostic" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->diagnostic }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Follow-up: </label>
        <input type="text" name="followup" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->followup }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Referral: </label>
        <input type="text" name="referral" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->referral }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Health Education and Advise: </label>
        <input type="text" name="advise" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->advise }}" @endif/>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <label for="">Therapeutics: </label>
        <input type="text" name="therapeutics" class="styledFormat lastInputBox"
        @if($fin) value="{{ $fn->therapeutics }}" @endif/>
    </div>
</div>



</div>





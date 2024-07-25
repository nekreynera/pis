<!-- Modal -->
<div id="industrialForm" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-uppercase">Industrial Clinic Consultation</h4>
            </div>



            <div class="modal-body">



                <div class="col-md-1 bg-danger overlayLoader">
                    <div>
                        <i class="fa fa-spinner fa-spin"></i>
                        <span>Please Wait...</span>
                    </div>
                </div>


                <form action="<?php echo e(url('industrial')); ?>" method="post" id="industrialMainForm">

                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="pid" value="<?php echo e($patient->id); ?>"/>

                    <input type="hidden" name="industrialFormId" <?php if($industrialConsultations): ?> value="<?php echo e($industrialConsultations->id); ?>" <?php endif; ?>/>


                    <div class="form-group">
                        <label for="">Name: &nbsp; </label>
                        <strong style="font-size: 19px;color: green">
                            <?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?>

                        </strong>
                    </div>



                    <div class="form-group">
                        <label for="">Date of Consult: &nbsp; </label>
                        <input type="text" name="date_consulted" class="dateOfConsult"
                                <?php if($industrialConsultations): ?>
                                    value="<?php echo e($industrialConsultations->date_consulted); ?>"
                                <?php else: ?>
                                    value="<?php echo e(Carbon::now()->toDateString()); ?>"
                               <?php endif; ?>/>
                    </div>
                    
                    
                    <div class="form-group">
                        <textarea name="result" id="" class="form-control" cols="30" rows="8"><?php echo e(isset($industrialConsultations->result) ? $industrialConsultations->result : ''); ?></textarea>
                        <br/>
                        <label for="">Review of Systems:</label>
                    </div>




                    <div class="row">




                                <?php
                                    $heentArray = array();
                                    if($industrialConsultations && $industrialConsultations->system_reviews){
                                        $heentArray = explode(',', $industrialConsultations->system_reviews->heent);
                                    }
                                ?>


                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th><em>HEENT</em></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(1,$heentArray)): ?> checked <?php endif; ?>
                                                        name="heent[]" value="1">Blurring of Vision</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$heentArray)): ?> checked <?php endif; ?>
                                                        name="heent[]" value="2">Ringing of Ears</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$heentArray)): ?> checked <?php endif; ?>
                                                        name="heent[]" value="3">Eye Redness</label>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                                    <?php
                                    $gastrointestinalArray = array();
                                    if($industrialConsultations && $industrialConsultations->system_reviews){
                                        $gastrointestinalArray = explode(',', $industrialConsultations->system_reviews->gastrointestinal);
                                    }
                                    ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th><em>Gastrointestinal</em></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(1,$gastrointestinalArray)): ?> checked <?php endif; ?>
                                                        name="gastrointestinal[]" value="1">Abdominal Pain</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$gastrointestinalArray)): ?> checked <?php endif; ?>
                                                        name="gastrointestinal[]" value="2">Jaundice</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$gastrointestinalArray)): ?> checked <?php endif; ?>
                                                        name="gastrointestinal[]" value="3">Nausea/Vomiting</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$gastrointestinalArray)): ?> checked <?php endif; ?>
                                                        name="gastrointestinal[]" value="4">Diarrhea</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(5,$gastrointestinalArray)): ?> checked <?php endif; ?>
                                                        name="gastrointestinal[]" value="5">Melena/Hematochezia</label>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$neurologicArray)): ?> checked <?php endif; ?>
                                                        name="neurologic[]" value="1">Weakness</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$neurologicArray)): ?> checked <?php endif; ?>
                                                        name="neurologic[]" value="2">Numbness/Paresthesia</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$neurologicArray)): ?> checked <?php endif; ?>
                                                        name="neurologic[]" value="3">Headache</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$neurologicArray)): ?> checked <?php endif; ?>
                                                        name="neurologic[]" value="4">Dizziness</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(5,$neurologicArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$respiratoryArray)): ?> checked <?php endif; ?>
                                                        name="respiratory[]" value="1">Difficulty of Breathing</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$respiratoryArray)): ?> checked <?php endif; ?>
                                                        name="respiratory[]" value="2">Wheezes</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$respiratoryArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(3,$genitourinaryArray)): ?> checked <?php endif; ?>
                                                        name="genitourinary[]" value="1">Frequency</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$genitourinaryArray)): ?> checked <?php endif; ?>
                                                        name="genitourinary[]" value="2">Hematuria</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$genitourinaryArray)): ?> checked <?php endif; ?>
                                                        name="genitourinary[]" value="3">Passage of sandy material</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$genitourinaryArray)): ?> checked <?php endif; ?>
                                                        name="genitourinary[]" value="4">Dribbling</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(5,$genitourinaryArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$musculoskeletalArray)): ?> checked <?php endif; ?>
                                                        name="musculoskeletal[]" value="1">Muscle Pain</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$musculoskeletalArray)): ?> checked <?php endif; ?>
                                                        name="musculoskeletal[]" value="2">Bore Pain</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$musculoskeletalArray)): ?> checked <?php endif; ?>
                                                        name="musculoskeletal[]" value="3">Sprain/Strain</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$musculoskeletalArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$cardiovascularArray)): ?> checked <?php endif; ?>
                                                        name="cardiovascular[]" value="1">Chest Pain</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$cardiovascularArray)): ?> checked <?php endif; ?>
                                                        name="cardiovascular[]" value="2">Orthopnea</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$cardiovascularArray)): ?> checked <?php endif; ?>
                                                        name="cardiovascular[]" value="3">Paroxysmal Nocturnal Dyspnea</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$cardiovascularArray)): ?> checked <?php endif; ?>
                                                        name="cardiovascular[]" value="4">Easy Fatigability</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(5,$cardiovascularArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$metabolic_endocrineArray)): ?> checked <?php endif; ?>
                                                        name="metabolic_endocrine[]" value="1">Polyuria</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$metabolic_endocrineArray)): ?> checked <?php endif; ?>
                                                        name="metabolic_endocrine[]" value="2">Polydipsia</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$metabolic_endocrineArray)): ?> checked <?php endif; ?>
                                                        name="metabolic_endocrine[]" value="3">Polyphagia</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(4,$metabolic_endocrineArray)): ?> checked <?php endif; ?>
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
                                                    <label><input type="checkbox" <?php if(in_array(1,$skin_integumentArray)): ?> checked <?php endif; ?>
                                                        name="skin_integument[]" value="1">Pallor</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(2,$skin_integumentArray)): ?> checked <?php endif; ?>
                                                        name="skin_integument[]" value="2">Cyanosis</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" <?php if(in_array(3,$skin_integumentArray)): ?> checked <?php endif; ?>
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
                                       <?php if($history): ?>
                                            value="<?php echo e($industrialConsultations->industrial_history->illnesses); ?>"
                                       <?php endif; ?> />
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Hospitalization:</label>
                                <input type="text" name="hospitalization" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->hospitalization); ?>"
                                <?php endif; ?>/>
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Allergies:</label>
                                <input type="text" name="allergies" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->allergies); ?>"
                                <?php endif; ?>/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h5><strong>Personal/Social History</strong></h5>
                            <br/>
                            <div class="form-inline">
                                <label for="">Smoker? </label>
                                <div class="radio">
                                    <label><input type="radio" name="smoker" value="Yes"
                                        <?php if($history): ?>
                                            <?php if($industrialConsultations->industrial_history->smoker == 'Yes'): ?>
                                                checked
                                            <?php endif; ?>
                                        <?php endif; ?>> Yes,</label>
                                    <label><input type="radio" name="smoker" value="No"
                                        <?php if($history): ?>
                                            <?php if($industrialConsultations->industrial_history->smoker == 'No'): ?>
                                                  checked
                                            <?php endif; ?>
                                        <?php endif; ?>> No</label>
                                </div>
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Pack Year?</label>
                                <input type="text" name="packyear" maxlength="20" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->packyear); ?>"
                                <?php endif; ?>/>
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Alcohol Beverage Drinker?</label>
                                <input type="text" name="drinker" maxlength="20" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->drinker); ?>"
                                <?php endif; ?>/>
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
                                        <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[0]) ? $obstetric[0] : ''); ?>"  <?php endif; ?>/>
                                <label for="">P</label>
                                <input type="text" name="obstetric2" maxlength="2" class="smallInput"
                                <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[1]) ? $obstetric[1] : ''); ?>"  <?php endif; ?>/>

                                <strong style="font-size: 20px">(</strong>
                                <input type="text" name="obstetric3" maxlength="2" class="smallInput"
                                <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[2]) ? $obstetric[2] : ''); ?>"  <?php endif; ?>/>,
                                <input type="text" name="obstetric4" maxlength="2" class="smallInput"
                                <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[3]) ? $obstetric[3] : ''); ?>"  <?php endif; ?>/>,
                                <input type="text" name="obstetric5" maxlength="2" class="smallInput"
                                <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[4]) ? $obstetric[4] : ''); ?>"  <?php endif; ?>/>,
                                <input type="text" name="obstetric6" maxlength="2" class="smallInput"
                                <?php if($industrialConsultations && $history): ?> value="<?php echo e(isset($obstetric[5]) ? $obstetric[5] : ''); ?>"  <?php endif; ?>/>
                                <strong style="font-size: 20px">)</strong>
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Age of Menarche</label>
                                <input type="text" name="menarche" maxlength="20" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->menarche); ?>"
                                <?php endif; ?>/>
                            </div>
                            <br/>
                            <div class="form-inline">
                                <label>Age of First Coitus</label>
                                <input type="text" name="coitus" maxlength="20" class="styledForm"
                                <?php if($history): ?>
                                       value="<?php echo e($industrialConsultations->industrial_history->coitus); ?>"
                                <?php endif; ?>/>
                            </div>
                        </div>



                    </div>


                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>


                    <?php
                        if($industrialConsultations && $industrialConsultations->physical_exams){
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
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->blood_pressure); ?>" <?php endif; ?>/>
                            <label>mmHg,</label>
                            <strong class="strng">HR</strong>
                            <input type="text" name="hr" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->pulse_rate); ?>" <?php endif; ?>/>
                            <label>bpm,</label>
                            <strong class="strng">RR</strong>
                            <input type="text" name="rr" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->respiration_rate); ?>" <?php endif; ?>/>
                            <label>cpm,</label>
                            <strong class="strng">Temp</strong>
                            <input type="text" name="temp" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->body_temperature); ?>" <?php endif; ?>/>
                            <label> &#176;C,</label>
                            <strong class="strng">BMI</strong>
                            <input type="text" name="bmi" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> 
                                <?php if($vital_signs[0]->weight && $vital_signs[0]->height): ?>
                                    <?php
                                        $w = $vital_signs[0]->weight;
                                        $h = $vital_signs[0]->height / 100;
                                        $th = $h * $h;
                                        $bmi = $w / $th;
                                    ?>
                                    value="<?php echo e(number_format($bmi, 3, '.', '')); ?>"
                                <?php endif; ?>
                             <?php endif; ?>/>
                            <strong class="strng">WT.</strong>
                            <input type="text" name="wt" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->weight); ?>" <?php endif; ?>/>
                            <strong class="strng">HT.</strong>
                            <input type="text" name="ht" class="styledFormSmall"
                            <?php if(count($vital_signs) > 0): ?> value="<?php echo e($vital_signs[0]->height); ?>" <?php endif; ?>/>
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
                                                <?php if($surveys): ?> <?php echo e(($srv->general_survey == '0')? 'checked' : ''); ?> <?php endif; ?>>
                                        No Significant Findings
                                    </label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="general_surveyRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->general_survey != '0' && $srv->general_survey != null)? 'checked' : ''); ?> <?php endif; ?>>
                                        Noted the following
                                    </label>
                                    <input type="text" name="general_survey" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->general_survey != '0' && $srv->general_survey != null): ?>
                                            value="<?php echo e($srv->general_survey); ?>"
                                        <?php elseif($srv->general_survey == '0'): ?>
                                            disabled
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->skin_integument == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="skin_integumentRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->skin_integument != '0' && $srv->skin_integument != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_skin_integument" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->skin_integument != '0' && $srv->skin_integument != null): ?>
                                           value="<?php echo e($srv->skin_integument); ?>"
                                                <?php elseif($srv->skin_integument == '0'): ?>
                                           disabled
                                                <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->heent == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="heentRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->heent != '0' && $srv->heent != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_heent" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->heent != '0' && $srv->heent != null): ?>
                                           value="<?php echo e($srv->heent); ?>"
                                        <?php elseif($srv->heent == '0'): ?>
                                           disabled
                                        <?php else: ?>
                                           disabled
                                        <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->respiratory == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="respiratoryRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->respiratory != '0' && $srv->respiratory != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_respiratory" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->respiratory != '0' && $srv->respiratory != null): ?>
                                           value="<?php echo e($srv->respiratory); ?>"
                                                <?php elseif($srv->respiratory == '0'): ?>
                                           disabled
                                           <?php else: ?>
                                           disabled
                                                <?php endif; ?>
                                                <?php else: ?>
                                                disabled
                                                <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->cardiovascular == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="cardiovascularRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->cardiovascular != '0' && $srv->cardiovascular != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_cardiovascular" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->cardiovascular != '0' && $srv->cardiovascular != null): ?>
                                           value="<?php echo e($srv->cardiovascular); ?>"
                                                <?php elseif($srv->cardiovascular == '0'): ?>
                                           disabled
                                           <?php else: ?>
                                           disabled
                                                <?php endif; ?>
                                                <?php else: ?>
                                                disabled
                                                <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->gastrointestinal == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="gastrointestinalRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->gastrointestinal != '0' && $srv->gastrointestinal != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_gastrointestinal" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->gastrointestinal != '0' && $srv->gastrointestinal != null): ?>
                                           value="<?php echo e($srv->gastrointestinal); ?>"
                                                <?php elseif($srv->gastrointestinal == '0'): ?>
                                           disabled
                                           <?php else: ?>
                                           disabled
                                                <?php endif; ?>
                                                <?php else: ?>
                                                disabled
                                                <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->genitourinary == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="genitourinaryRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->genitourinary != '0' && $srv->genitourinary != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_genitourinary" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->genitourinary != '0' && $srv->genitourinary != null): ?>
                                           value="<?php echo e($srv->genitourinary); ?>"
                                                <?php elseif($srv->genitourinary == '0'): ?>
                                           disabled
                                           <?php else: ?>
                                           disabled
                                                <?php endif; ?>
                                                <?php else: ?>
                                                disabled
                                                <?php endif; ?>/>
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
                                        <?php if($surveys): ?> <?php echo e(($srv->neurologic == '0')? 'checked' : ''); ?> <?php endif; ?>> No Significant Findings</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="neurologicRadio" class="surveyNoted" value="1"
                                        <?php if($surveys): ?> <?php echo e(($srv->neurologic != '0' && $srv->neurologic != null)? 'checked' : ''); ?> <?php endif; ?>> Noted the following</label>
                                    <input type="text" name="survey_neurologic" class="styledFormat"
                                    <?php if($surveys): ?>
                                        <?php if($srv->neurologic != '0' && $srv->neurologic != null): ?>
                                           value="<?php echo e($srv->neurologic); ?>"
                                                <?php elseif($srv->neurologic == '0'): ?>
                                           disabled
                                           <?php else: ?>
                                           disabled
                                                <?php endif; ?>
                                    <?php else: ?>
                                        disabled
                                    <?php endif; ?>/>
                                </div>
                            </div>
                        </div>
                    </div>


                    <br/>
                    <br/>
                    <br/>


                    <?php
                        if($industrialConsultations && $industrialConsultations->final_results){
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
                                    <?php if($fin): ?> value="<?php echo e($fn->assesment); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Plan: </label>
                            <input type="text" name="plan" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->plan); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Diagnostic: </label>
                            <input type="text" name="diagnostic" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->diagnostic); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Follow-up: </label>
                            <input type="text" name="followup" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->followup); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Referral: </label>
                            <input type="text" name="referral" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->referral); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Health Education and Advise: </label>
                            <input type="text" name="advise" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->advise); ?>" <?php endif; ?>/>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Therapeutics: </label>
                            <input type="text" name="therapeutics" class="styledFormat lastInputBox"
                            <?php if($fin): ?> value="<?php echo e($fn->therapeutics); ?>" <?php endif; ?>/>
                        </div>
                    </div>




                </form>


                <br/>
                <br/>
                <br/>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?php if($industrialConsultations): ?>
                    <?php $href = url('industrialPrint/'.$industrialConsultations->id); ?>
                <?php else: ?>
                    <?php $href = ''; ?>
                <?php endif; ?>
               
                <a href="<?php echo e($href); ?>"
                    target="_blank" class="btn btn-primary printIConIndustrial">
                    <i class="fa fa-print"></i>  
                    Print
                </a>
                <button type="submit" form="industrialMainForm" class="btn btn-success submitIndustrialBtn">
                    <i class="fa fa-save"></i> 
                    Save
                </button>
            </div>
        </div>

    </div>
</div>




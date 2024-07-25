<div id="patientInfo" class="modal" role="dialog">
    <div class="modal-dialog modal-xxl">

        <!-- Modal content-->
        <div class="modal-content">

            

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered patientInfo">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <h4 class="text-center">Patient Information</h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>PATIENT NAME:</td>
                                    <td><h4 class="text-danger"><?php echo e($patient->last_name.', '.$patient->first_name.' '.$patient->suffix.' '.$patient->middle_name); ?></h4></td>
                                </tr>
                                <tr>
                                    <td>HOSPITAL NO:</td>
                                    <td><?php echo e($patient->hospital_no); ?></td>
                                </tr>
                                <tr>
                                    <td>BARCODE:</td>
                                    <td><?php echo e($patient->barcode); ?></td>
                                </tr>
                                <tr>
                                    <td>BIRTHDAY:</td>
                                    <td><?php echo e(Carbon::parse($patient->birthday)->format('F d, Y')); ?></td>
                                </tr>
                                <tr>
                                    <td>AGE:</td>
                                    <td>
                                        <?php echo e(App\Patient::age($patient->birthday)); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>ADDRESS:</td>
                                    <td><?php echo e($patient->address); ?></td>
                                </tr>
                                <tr>
                                    <td>SEX:</td>
                                    <td>
                                        <?php
                                            switch($patient->sex)
                                            {
                                                case 'M':
                                                    echo 'Male';
                                                    break;
                                                case 'F':
                                                    echo 'Female';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CIVIL STATUS:</td>
                                    <td><?php echo e($patient->civil_status); ?></td>
                                </tr>
                                <tr>
                                    <td>MSS CLASSIFICATION</td>
                                    <!-- <td><?php echo e(($patient->label)? $patient->label.' '.($patient->description).'%' : 'Unclassified'); ?></td> -->
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>DATE REGISTERED:</td>
                                    <td><?php echo e(Carbon::parse($patient->created_at)->format('jS \o\f F, Y')); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-4 col-md-offset-1">

                        <br>
                        <table class="table table-bordered vitalSigns">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <h4 class="text-center">Vital Signs</h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Blood Pressure:</td>
                                <td><?php echo e((isset($vital_signs[0]->blood_pressure))? $vital_signs[0]->blood_pressure : ''); ?></td>
                            </tr>
                            <tr>
                                <td>Pulse Rate:</td>
                                <td><?php echo e((isset($vital_signs[0]->pulse_rate))? $vital_signs[0]->pulse_rate : ''); ?></td>
                            </tr>
                            <tr>
                                <td>Respiration Rate:</td>
                                <td><?php echo e((isset($vital_signs[0]->respiration_rate))? $vital_signs[0]->respiration_rate : ''); ?></td>
                            </tr>
                            <tr>
                                <td>Body Temperature:</td>
                                <td><?php echo e((isset($vital_signs[0]->body_temperature))? $vital_signs[0]->body_temperature : ''); ?></td>
                            </tr>
                            <tr>
                                <td>Weight:</td>
                                <td><?php echo e((isset($vital_signs[0]->weight))? $vital_signs[0]->weight : ''); ?></td>
                            </tr>
                            <tr>
                                <td>Height:</td>
                                <td><?php echo e((isset($vital_signs[0]->height))? $vital_signs[0]->height : ''); ?></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <?php if(isset($vital_signs[0]->created_at)): ?>
                                    <td class="text-right" colspan="2" style="background-color: #fff">
                                        <?php echo e('Date examined : '. Carbon::parse($vital_signs[0]->created_at)->format('jS \o\f F, Y')); ?>

                                    </td>
                                <?php else: ?>
                                    <td class="text-right" colspan="2" style="background-color: #fff">
                                        <span class='text-danger'>Todays Vital Signs is Unavailable!</span>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
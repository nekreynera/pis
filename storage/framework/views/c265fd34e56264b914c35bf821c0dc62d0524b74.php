<?php $__env->startComponent('partials/header'); ?>

    <?php $__env->slot('title'); ?>
        OPD | Consultations Details
    <?php $__env->endSlot(); ?>

<?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/doctors/preview.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('receptions.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="text-left" style="margin: 0">Consultation Details</h2>
                    </div>
                    <div class="col-md-3 text-right">
                        <a href="<?php echo e(url('printNurseNotes/'.$consultation->id)); ?>" target="_blank" class="btn btn-default text-success">
                            <i class="fa fa-print text-success"></i> <span class="text-success">Print</span>
                        </a>
                        <a href="<?php echo e(url('nurseNotes/'.$consultation->id)); ?>" class="btn btn-default">
                            <i class="fa fa-pencil text-danger"></i> <span class="text-danger">Write Nurse Notes</span>
                        </a>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-md-4">Last Name:</th>
                                <td><?php echo e($patient->last_name); ?></td
                            </tr>
                            <tr>
                                <th>Given Name:</th>
                                <td><?php echo e($patient->first_name); ?></td>
                            </tr>
                            <tr>
                                <th>CIVIL STATUS:</th>
                                <td><?php echo e($patient->civil_status); ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?php echo e($patient->address); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th class="col-md-4">Middle Name:</th>
                                <td><?php echo e($patient->middle_name); ?></td
                            </tr>
                            <tr>
                                <th>Birthday:</th>
                                <td><?php echo e(Carbon::parse($patient->birthday)->toFormattedDateString()); ?></td>
                            </tr>
                            <tr>
                                <th>Age:</th>
                                <td><?php echo e(App\Patient::age($patient->birthday)); ?></td>
                            </tr>
                            <tr>
                                <th>Contact No:</th>
                                <td><?php echo e($patient->contact_no); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                

                <div class="table-responsive">
                    <?php echo $consultation->consultation; ?>

                </div>


                <?php if(count($consultations_icds) > 0): ?>
                    <div class="diagnosisWrapper">
                        <br>
                        <h2 class="">International Classification of Diseases</h2>
                        <br>
                        <?php $__currentLoopData = $consultations_icds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultations_icd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group input-group">
                                <input type="text" class="form-control" value="<?php echo e($consultations_icd->description); ?>" readonly="" />
                                <span class="input-group-addon">
                            <i class="fa fa-trash-o"></i>
                        </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>


                <?php if(count($files) > 0): ?>

                    

                    <div class="">
                        <br>
                        <br>
                        <h2 class="">Uploaded Files for this Consultation</h2>
                        <br>
                        <div class="bg-danger filesWrapper">

                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="imgWrapperPreview">
                                    <?php
                                        $filetype = array('doc','docx','txt','xlsx','xls','pdf','ppt','pptx');
                                        $filename = explode('.',$file->filename);
                                    ?>
                                    <?php if(!in_array($filename[1],$filetype)): ?>
                                        <img src="<?php echo e($directory.$file->filename); ?>" alt="" class="img-responsive" width="100%" />
                                        <a href="" class="btn btn-primary btn-circle viewImage" data-placement="top" data-toggle="tooltip" title="View this file?">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    <?php else: ?>
                                        <?php if($filename[1] == 'doc' || $filename[1] == 'docx'): ?>
                                            <img src="<?php echo e(asset('public/images/mswordlogo.svg')); ?>" alt="" class="img-responsive" />
                                        <?php elseif($filename[1] == 'xlsx' || $filename[1] == 'xls'): ?>
                                            <img src="<?php echo e(asset('public/images/excellogo.svg')); ?>" alt="" class="img-responsive" />
                                        <?php elseif($filename[1] == 'ppt' || $filename[1] == 'pptx'): ?>
                                            <img src="<?php echo e(asset('public/images/powerpointlogo.svg')); ?>" alt="" class="img-responsive" />
                                        <?php elseif($filename[1] == 'pdf'): ?>
                                            <img src="<?php echo e(asset('public/images/pdflogo.svg')); ?>" alt="" class="img-responsive" />
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('public/images/textlogo.svg')); ?>" alt="" class="img-responsive" />
                                        <?php endif; ?>
                                        <a href="<?php echo e($directory.$file->filename); ?>" target="_blank" class="btn btn-info btn-circle" data-placement="top" data-toggle="tooltip" title="Open this file?">
                                            <i class="fa fa-file-text-o"></i>
                                        </a>
                                    <?php endif; ?>
                                    <input type="hidden" value="<?php echo e($file->title); ?>" class="title" />
                                    <textarea hidden class="description"><?php echo e($file->description); ?></textarea>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>


                        <div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreview" aria-hidden="true">
                            <div class="modal-dialog modal-xxl colorless" role="document">
                                <div class="modal-content colorless">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1">
                                            <span class="text-danger">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body colorless">
                                        <div class="row colorless">
                                            <div class="col-md-8">
                                                <img src="" id="showImage" alt="Failed to load image." class="img-responsive center-block" />
                                            </div>
                                            <div class="col-md-4 imageDescWrapper">
                                                <div class="form-group">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" readonly id="showTitle" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Description</label>
                                                    <textarea id="showDescription" cols="30" rows="10" class="form-control" readonly style="background-color: transparent"></textarea>
                                                </div>
                                                <br>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endif; ?>

                <br>
                <br>
                <br>

            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message.toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/js/doctors/filemanager.js')); ?>"></script>
    <script src="<?php echo e(asset('public/plugins/js/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/richtexteditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/doctors/preview.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->renderComponent(); ?>

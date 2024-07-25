<?php $__env->startComponent('partials/header'); ?>

  <?php $__env->slot('title'); ?>
    EVRMC | MALASAKIT CENTER
  <?php $__env->endSlot(); ?>

  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/malasakit/main.css')); ?>" rel="stylesheet" />
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('malasakit/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>
   <table border="1">
     <thead>
       <tr>
         <th colspan="2">
            Official Receipt/<br>
            Report of Collections <br>
            by Sub-Collector
          </th>
          <th rowspan="2">
            Responsibilty <br>
            Center <br>
            Code
          </th>
          <th rowspan="2">
            Payor 
          </th>
          <th rowspan="2">
            Particulars
          </th>
          <th rowspan="2">
            MFO/PAP
          </th>
          <th colspan="6">
            AMOUNT
          </th>
       </tr>
       <tr>
         <th>
            DATE
          </th>
         <th>
            NUMBER
          </th>
         <th>
            TOTAL <br>
            PER <br>
            OR
          </th>
          <th>
            OTHER <br>
            FEES <br>
            (4020217099)
          </th>
          <th>
            MEDICAL FEES <br>
            - PHYSICAL <br>
            MEDICINE & <br>
             REHABILITATION <br>
             SERVICES <br>
            (4020217009) <br>
          </th>
          <th>
            LABORATORY
          </th>
          <th>
            RADIOLOGY
          </th>
          <th>
            CARDIOLOGY
          </th>
       </tr>
     </thead>
   </table>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- <script src="<?php echo e(asset('public/js/mss/scan.js')); ?>"></script> -->

  <?php $__env->stopSection(); ?>

<?php echo $__env->renderComponent(); ?>

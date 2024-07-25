<?php 

use app\Http\Controllers\MssController;

?>
<?php $__env->startComponent('partials/header'); ?>

  <?php $__env->slot('title'); ?>
    OPD | REPORT
  <?php $__env->endSlot(); ?>

  <?php $__env->startSection('pagestyle'); ?>
    <link href="<?php echo e(asset('public/css/mss/report.css')); ?>" rel="stylesheet" />
    <style>
      #mssreport td{
        padding: 4px;
      }
      body{
        background-color: rgb(82, 86, 89);
      }
    </style>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('header'); ?>
    <?php echo $__env->make('mss/navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('content'); ?>
    <div class="container mainWrapper" id="wrapper">
      <div class="panel" id="mssreport">
        <div class="panel-body" id="login-body" style="font-size: 12px;">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <p>STATISTICAL REPORT</p>

            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-4">
                <?php if($request->users_id == 'ALL'): ?>
                <p>OVERALL REPORT OF OPDRMS(MSS) USERS</p>
                <?php else: ?>
                <p style="text-transform: capitalize;">NAME: <?php echo e($employee->last_name.' '.$employee->first_name); ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              
              <p class="text-right">DATE/SHIFT: <?php echo e($request->from.'-'.$request->to); ?></p>
            </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
              <table class="table table-bordered" style="margin-bottom: 0px;">
                <!-- <tr>
                  <th style="text-align: center;" colspan="11">DOH-MAP</th>
                </tr> -->
                <tr>
                  <td colspan="10" align="center"><h4>REFERRING PARTY</h4></td>
                  <th rowspan="2" align="center"><br><br>TOTAL</th>
                </tr>
                <tr>
                  <th style="min-width: 200px;max-width: 200px;">DISTRICT</th>
                  <th>GH</th>
                  <th>PH/PC</th>
                  <th>POLITICIAN</th>
                  <th>MEDIA</th>
                  <th>HCT/RHU<br>/TACRU</th>
                  <th>NGO/<br>PRIVATE <br>WELFARE</th>
                  <th>GOVT<br> AGENCIES</th>
                  <th>WALK-IN</th>
                  <th>OTHER</th>
                  
                </tr>
                <?php 
                $district = '1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,WESTERN SAMAR,1ST,2ND,EASTERN SAMAR,1ST,2ND,NORTHERN SAMAR,1ST,2ND, OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
                $content = '967,969,970,973,975,977,978,983,985,996,1000,1001,1004,1005,1006-
                      976,987,989,993,998,1003,1007-
                      974,988,999,1002,1008-
                      968,982,986,991,994,997,995-
                      966,971,972,979,980,981,984,990,992-
                      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
                      1078,1079,1080,1081,1082,1083,1084,1085-
                      122333434-
                      1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
                      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
                      122333434-
                      943,946,947,948,953,956,959,962,963,964,965-
                      944,945,949,950,951,952,954,955,957,958,960,961-
                      122333434-
                      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
                      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
                      08';

                $excont = explode('-', $content);
                $exdist = explode(',', $district);
                $d = 0;
                foreach ($exdist as $keyso):
                // if ($exdist[$d] == 'OUTSIDE R08') {
                //   $disresult = $query->getplaceoforiginoutside($_POST['user'], $_POST['from'], $_POST['to']);
                // }else{
                  $disresult = MssController::getresultreferringperdistrict($excont[$d], $request->users_id, $request->from, $request->to);
                // }

                ?>
                <?php 
                  $walkin = 0;
                  $other = 0;
                  $gh = 0;
                  $hct = 0;
                  $phpc = 0;
                  $polit = 0;
                  $ngo = 0;
                  $media = 0;
                  $govt = 0;

                  foreach($disresult as $list):
                    if(substr($list->referral, 0,5) == "GH"):
                      $gh++;
                    endif;
                    if(substr($list->referral, 0,5) == "PH/PC"):
                      $phpc++;
                    endif;
                    if(substr($list->referral, 0,5) == "POLIT"):
                      $polit++;
                    endif;
                    if(substr($list->referral, 0,5) == "MEDIA"):
                      $media++;
                    endif;
                    if(substr($list->referral, 0,5) == "HCT/R"):
                      $hct++;
                    endif;
                    if(substr($list->referral, 0,5) == "NGO/P"):
                      $ngo++;
                    endif;
                    if(substr($list->referral, 0,4) == "GOVT"):
                      $govt++;
                    endif;
                    if(substr($list->referral, 0,5) == "WALK-"):
                      $walkin++;
                    endif;
                    if(substr($list->referral, 0,5) == "other"):
                      $other++;
                    endif;
                  endforeach;
                 ?> 
                <tr>
                  <?php if($exdist[$d] == "WESTERN SAMAR" || $exdist[$d] == "NORTHERN SAMAR" || $exdist[$d] == "EASTERN SAMAR"): ?>
                  <td><b><?php echo e($exdist[$d]); ?></b></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="success"></td>
                  <?php else: ?>
                  <td><?php echo e($exdist[$d]); ?></td>
                  <td align="center" class="gh"><?php if($gh <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($gh); ?> <?php endif; ?></td>
                  <td align="center" class="phpc"><?php if($phpc <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($phpc); ?> <?php endif; ?></td>
                  <td align="center" class="polit"><?php if($polit <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($polit); ?> <?php endif; ?></td>
                  <td align="center" class="media"><?php if($media <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($media); ?> <?php endif; ?></td>
                  <td align="center" class="hct"><?php if($hct <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($hct); ?> <?php endif; ?></td>
                  <td align="center" class="ngo"><?php if($ngo <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($ngo); ?> <?php endif; ?></td>
                  <td align="center" class="govt"><?php if($govt <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($govt); ?> <?php endif; ?></td>
                  <td align="center" class="walkin"><?php if($walkin <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($walkin); ?> <?php endif; ?></td>
                  <td align="center" class="other"><?php if($other <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($other); ?> <?php endif; ?></td>
                  <td align="center" class="tot_totalperline success"><?php echo e(count($disresult)); ?></td>
                  <?php endif; ?>
                  
                </tr>
                <?php 
                $d++;
                endforeach;
                ?>
                <tr>
                  <th><b>TOTAL</b></th>
                  <th class="tot_gh success"></th>
                  <th class="tot_phpc success"></th>
                  <th class="tot_polit success"></th>
                  <th class="tot_media success"></th>
                  <th class="tot_hct success"></th>
                  <th class="tot_ngo success"></th>
                  <th class="tot_govt success"></th>
                  <th class="tot_walkin success"></th>
                  <th class="tot_other success"></th>
                  <th class="tot_totals success"></th>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6">
            <br>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <td align="center" rowspan="2">DISTRICT</td>
                  <td colspan="7" align="center">REGULAR PATIENTS CLASSIFICATION</td>
                 
                  <td align="center" rowspan="2">TOTAL</td>
                </tr>
                <tr>
                  <td align="center">A</td>
                  <td align="center">B</td>
                  <td align="center">C1</td>
                  <td align="center">C2</td>
                  <td align="center">C3</td>
                  <td align="center">SC</td>
                  <td align="center">D</td>
                </tr>
                <?php 
                $district = '1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,WESTERN SAMAR,1ST,2ND,EASTERN SAMAR,1ST,2ND,NORTHERN SAMAR,1ST,2ND, OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
                $content = '967,969,970,973,975,977,978,983,985,996,1000,1001,1004,1005,1006-
                      976,987,989,993,998,1003,1007-
                      974,988,999,1002,1008-
                      968,982,986,991,994,997,995-
                      966,971,972,979,980,981,984,990,992-
                      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
                      1078,1079,1080,1081,1082,1083,1084,1085-
                      122333434-
                      1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
                      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
                      122333434-
                      943,946,947,948,953,956,959,962,963,964,965-
                      944,945,949,950,951,952,954,955,957,958,960,961-
                      122333434-
                      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
                      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
                      08';
                $excont = explode('-', $content);
                $exdist = explode(',', $district);
                $d = 0;
                foreach ($exdist as $keyso):
                  $mss = MssController::getresultreferringperdistrict($excont[$d], $request->users_id, $request->from, $request->to);
                $a = 0;
                $b = 0;
                $c1 = 0;
                $c2 = 0;
                $c3 = 0;
                $de = 0;

                foreach ($mss  as $list): 
                  if ($list->mss_id == 1) {
                    $a++;
                  }
                  if ($list->mss_id == 16) {
                    $b++;
                  }

                  if ($list->mss_id == 3) {
                    $c1++;
                  }
                  if ($list->mss_id == 4) {
                    $c2++;
                  }
                  if ($list->mss_id == 5 ||
                      $list->mss_id == 6 ||
                      $list->mss_id == 7 ||
                      $list->mss_id == 8) {
                    $c3++;
                  }
                  if ($list->mss_id == 9) {
                    $de++;
                  }

                endforeach;
                $total = 0;
                ?>

                <tr>
                  <td><?php echo e($exdist[$d]); ?></td>
                  <td align="center" class="a"><?php if($a <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($a); ?> <?php endif; ?></td>
                  <td align="center" class="b"><?php if($b <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($b); ?> <?php endif; ?></td>
                  <td align="center" class="c1"><?php if($c1 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($c1); ?> <?php endif; ?></td>
                  <td align="center" class="c2"><?php if($c2 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($c2); ?> <?php endif; ?></td>
                  <td align="center" class="c3"><?php if($c3 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($c3); ?> <?php endif; ?>  </td>
                  <td align="center" class="sc"></td>
                  <td align="center" class="de"><?php if($de <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($de); ?> <?php endif; ?></td>
                  <td align="center" class="totals success" style="font-weight: bold;font-size: 12px;"><?php echo e($total+$a+$b+$c1+$c2+$c3+$de); ?></td>
                </tr>
                <?php
                $d++;
                endforeach; ?>
                <tr>
                  <th><b>TOTAL</b></th>
                  <th class="tot_a success"></th>
                  <th class="tot_b success"></th>
                  <th class="tot_c1 success"></th>
                  <th class="tot_c2 success"></th>
                  <th class="tot_c3 success"></th>
                  <th class="tot_sc success"></th>
                  <th class="tot_de success"></th>
                  <th class="tot_total success"></th>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <td align="center" rowspan="2">DISTRICT</td>
                  <td colspan="3" align="center">EMPLOYEE PATIENTS CLASSIFICATION</td>
                 
                  <td align="center" rowspan="2">TOTAL</td>
                </tr>
                <tr>
                  <td align="center">C1</td>
                  <td align="center">C2</td>
                  <td align="center">C3</td>
                </tr>
                <?php 
                $ed_district = '1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,WESTERN SAMAR,1ST,2ND,EASTERN SAMAR,1ST,2ND,NORTHERN SAMAR,1ST,2ND, OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
                $ed_content = '967,969,970,973,975,977,978,983,985,996,1000,1001,1004,1005,1006-
                      976,987,989,993,998,1003,1007-
                      974,988,999,1002,1008-
                      968,982,986,991,994,997,995-
                      966,971,972,979,980,981,984,990,992-
                      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
                      1078,1079,1080,1081,1082,1083,1084,1085-
                      122333434-
                      1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
                      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
                      122333434-
                      943,946,947,948,953,956,959,962,963,964,965-
                      944,945,949,950,951,952,954,955,957,958,960,961-
                      122333434-
                      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
                      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
                      08';
                $ed_excont = explode('-', $ed_content);
                $ed_exdist = explode(',', $ed_district);
                $ed_d = 0;
                foreach ($ed_exdist as $ed_keyso):
                  $mss = MssController::getresultreferringperdistrict($ed_excont[$ed_d], $request->users_id, $request->from, $request->to);
                $ed_c1 = 0;
                $ed_c2 = 0;
                $ed_c3 = 0;

                foreach ($mss  as $list): 

                  if ($list->mss_id == 17) {
                    $ed_c1++;
                  }
                  if ($list->mss_id == 18) {
                    $ed_c2++;
                  }
                  if ($list->mss_id == 19 ||
                      $list->mss_id == 20 ||
                      $list->mss_id == 21 ||
                      $list->mss_id == 22) {
                    $ed_c3++;
                  }

                endforeach;
                $ed_total = 0;
                ?>

                <tr>
                  <td><?php echo e($ed_exdist[$ed_d]); ?></td>
                  <td align="center" class="ed_c1"><?php if($ed_c1 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($ed_c1); ?> <?php endif; ?></td>
                  <td align="center" class="ed_c2"><?php if($ed_c2 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($ed_c2); ?> <?php endif; ?></td>
                  <td align="center" class="ed_c3"><?php if($ed_c3 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($ed_c3); ?> <?php endif; ?>  </td>
                  <td align="center" class="ed_totals success" style="font-weight: bold;font-size: 12px;"><?php echo e($ed_total+$ed_c1+$ed_c2+$ed_c3); ?></td>
                </tr>
                <?php
                $ed_d++;
                endforeach; ?>
                <tr>
                  <th><b>TOTAL</b></th>
                  <th class="ed_tot_c1 success"></th>
                  <th class="ed_tot_c2 success"></th>
                  <th class="ed_tot_c3 success"></th>
                  <th class="ed_tot_total success"></th>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <td align="center" rowspan="2">DISTRICT</td>
                  <td colspan="3" align="center">DEPENDENT PATIENTS CLASSIFICATION</td>
                 
                  <td align="center" rowspan="2">TOTAL</td>
                </tr>
                <tr>
                  <td align="center">C1</td>
                  <td align="center">C2</td>
                  <td align="center">C3</td>
                </tr>
                <?php 
                $d_district = '1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,WESTERN SAMAR,1ST,2ND,EASTERN SAMAR,1ST,2ND,NORTHERN SAMAR,1ST,2ND, OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
                $d_content = '967,969,970,973,975,977,978,983,985,996,1000,1001,1004,1005,1006-
                      976,987,989,993,998,1003,1007-
                      974,988,999,1002,1008-
                      968,982,986,991,994,997,995-
                      966,971,972,979,980,981,984,990,992-
                      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
                      1078,1079,1080,1081,1082,1083,1084,1085-
                      122333434-
                      1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
                      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
                      122333434-
                      943,946,947,948,953,956,959,962,963,964,965-
                      944,945,949,950,951,952,954,955,957,958,960,961-
                      122333434-
                      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
                      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030-
                      08';
                $d_excont = explode('-', $d_content);
                $d_exdist = explode(',', $d_district);
                $d_d = 0;
                foreach ($d_exdist as $d_keyso):
                  $mss = MssController::getresultreferringperdistrict($d_excont[$d_d], $request->users_id, $request->from, $request->to);
                $d_c1 = 0;
                $d_c2 = 0;
                $d_c3 = 0;

                foreach ($mss  as $list): 

                  if ($list->mss_id == 24) {
                    $d_c1++;
                  }
                  if ($list->mss_id == 25) {
                    $d_c2++;
                  }
                  if ($list->mss_id == 26 ||
                      $list->mss_id == 27 ||
                      $list->mss_id == 28 ||
                      $list->mss_id == 29) {
                    $d_c3++;
                  }

                endforeach;
                $d_total = 0;
                ?>

                <tr>
                  <td><?php echo e($d_exdist[$d_d]); ?></td>
                  <td align="center" class="d_c1"><?php if($d_c1 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($d_c1); ?> <?php endif; ?></td>
                  <td align="center" class="d_c2"><?php if($d_c2 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($d_c2); ?> <?php endif; ?></td>
                  <td align="center" class="d_c3"><?php if($d_c3 <= 0): ?> <?php echo e(" "); ?> <?php else: ?> <?php echo e($d_c3); ?> <?php endif; ?>  </td>
                  <td align="center" class="d_totals success" style="font-weight: bold;font-size: 12px;"><?php echo e($d_total+$d_c1+$d_c2+$d_c3); ?></td>
                </tr>
                <?php
                $d_d++;
                endforeach; ?>
                <tr>
                  <th><b>TOTAL</b></th>
                  <th class="d_tot_c1 success"></th>
                  <th class="d_tot_c2 success"></th>
                  <th class="d_tot_c3 success"></th>
                  <th class="d_tot_total success"></th>
                </tr>
              </table>
            </div>
          </div>



         <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="min-width: 200px;max-width: 200px;">PLACE OF ORIGIN</th>
                    <th>OP</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $plorigin = 'LEYTE,SOUTHERN LEYTE,BILIRAN,SAMAR (WESTERN SAMAR),EASTERN SAMAR,NORTHERN SAMAR,OUTSIDE R08';
                  $explo = explode(',', $plorigin);
                  $po = 0;
                  foreach ($explo as $key):
                    $origin = MssController::getplaceoforigin($explo[$po], $request->users_id, $request->from, $request->to);
                  ?>
                  <tr>
                    <td><?php echo e($explo[$po]); ?></td>
                    <td align="center" class="origclass"><?php if($origin): ?> <?php echo e($origin[0]->result); ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?></td>
                  </tr>
                  <?php
                  $po++; 
                  endforeach;
                  ?>
                  <tr>
                    <td>&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>TOTAL</td>
                    <td align="center" class="tot_orig success"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
         
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="min-width: 200px;max-width: 200px;">SECTORIAL GROUPINGS</th>
                  <th>OP</th>
                </tr>
              </thead>
              <tbody>

              <?php 
              $sectorial = 'SC,BRGY,PWD,BHW,INDIGENOUS PEOPLE,VETERANS,VAWC/IN INSTITUTION,ELDERLY,OTHERS';
              $exsect = explode(',', $sectorial);
              $s = 0;
              foreach ($exsect as $keyso): 
                $secresult = MssController::getsectorialreport($exsect[$s], $request->users_id, $request->from, $request->to);
                ?>
                <tr>
                  <?php if($exsect[$s] == 'BRGY'): ?>
                  <td><?php echo e('BRGY. OFFICIAL'); ?></td> 
                  <?php else: ?>
                  <td><?php echo e($exsect[$s]); ?></td>
                  <?php endif ?>
                  <td align="center" class="sectclass"><?php if($secresult): ?> <?php if($secresult[0]->result > 0): ?> <?php echo e($secresult[0]->result); ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?></td>
                </tr>
              <?php 
              $s++;
              endforeach; ?>  
                <tr>
                  <td>TOTAL</td>
                  <td align="center" class="tot_sect success"></td>
                </tr>
              </tbody>
            </table>  
          </div>
        </div> 

          <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="min-width: 200px;max-width: 200px;">PATIENT CATEGORY</th>
                    <th>OP</th>
                  </tr>
                </thead>
                <tbody>

                <?php 
                $category = 'O,N,C';
                $excat = explode(',', $category);
                $cat = 0;
                
                foreach ($excat as $keys): 
                $catresult = MssController::getpatcategoryreport($excat[$cat], $request->users_id, $request->from, $request->to);
                ?>
                  <tr>
                    <?php if($excat[$cat] == 'O'): ?> 
                    <td><?php echo e('OLD'); ?></td>
                    <?php elseif($excat[$cat] == 'N'): ?>
                    <td><?php echo e('NEW'); ?></td>
                    <?php else: ?>
                    <td><?php echo e('CASE FORWARD'); ?></td>
                    <?php endif; ?>
                    
                    <td align="center" class="catclass"><?php if($catresult): ?> <?php if($catresult[0]->result > 0): ?> <?php echo e($catresult[0]->result); ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?></td>
                  </tr>
                <?php 
                $cat++;
                endforeach ?> 
                  <tr>
                    <td>TOTAL</td>
                    <td align="center" class="tot_cat success"></td>
                  </tr>
                </tbody>
              </table>  
            </div>
        </div> 
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="min-width: 200px;max-width: 200px;">4P's / MCCT</th>
                  <th>OP</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach (MssController::getpatfuorpsreport($request->users_id, $request->from, $request->to) as $key): ?>
              
                <tr>
                  <td><?php echo e(($key->fourpis == 'Y')?"YES":"NO"); ?></td>
                  <td align="center" class="fourclass"><?php echo e($key->result); ?></td>
                </tr>
              <?php endforeach ?> 
                <tr>
                  <td>&nbsp;</td>
                  <td></td>
                </tr>
                <tr>
                  <td>TOTAL</td>
                  <td align="center" class="tot_four success"></td>
                </tr>
              </tbody>
            </table>  
          </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="text-center" style="border: 1px solid black;height: 28px;">
            DOH-MAP         
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="table-responsive">
            <table class="table table-bordered" style="margin-bottom: 0px;">
               
              <tr>
                <th style="min-width: 200px;max-width: 200px;">LEYTE</th>
                <th>OP</th>
                
              </tr>
              <?php 

              $district = '1ST,2ND,3RD,4TH,5TH,SO. LEYTE,BILIRAN,OUTSIDE R08';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
              $content = '967,969,970,973,975,977,978,983,985,996,1000,1001,1004,1005,1006-
                      976,987,989,993,998,1003,1007-
                      974,988,999,1002,1008-
                      968,982,986,991,994,997,995-
                      966,971,972,979,980,981,984,990,992-
                      1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077-
                      1078,1079,1080,1081,1082,1083,1084,1085-
                      08';

              $excont = explode('-', $content);
              $exdist = explode(',', $district);
              $d = 0;
              foreach ($exdist as $keyso):
              // if ($exdist[$d] == 'OUTSIDE R08') {
              //   $disresult = $query->getplaceoforiginoutside($_POST['user'], $_POST['from'], $_POST['to']);
              // }else{
                $disresult = MssController::getresultperdistrict($excont[$d], $request->users_id, $request->from, $request->to);
              // }
              ?> 
              <tr>
                <td><?php echo e($exdist[$d]); ?></td>
                <td align="center" class="dohclass"><?php if($disresult[0]->result > 0): ?> <?php echo e($disresult[0]->result); ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?></td>
              </tr>
              <?php 
              $d++;
              endforeach;
              ?>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="table-responsive">
            <table class="table table-bordered" style="margin-bottom: 0px;">
              
              <tr>
                <th style="min-width: 200px;max-width: 200px;">W. SAMAR</th>
                <th>OP</th>
                
              </tr>
              <?php 

              $district = '1ST,2ND,E.SAMAR,1ST,2ND,N.SAMAR,1ST,2ND';/*,SO. LEYTE,BILIRAN,OUTSIDE R08*/
              $content = '1033,1035,1039,1043,1057,1054,1048,1050,1056,1052,1058-
                      1034,1042,1036,1037,1038,1041,1045,1055,1044,1046,1051,1053,1040,1047,1049-
                      122333434-
                      943,946,947,948,953,956,959,962,963,964,965-
                      944,945,949,950,951,952,954,955,957,958,960,961-
                      122333434-
                      1009,1010,1011,1012,1013,1019,1021,1024,1025,1026,1027,1029,1031,1032-
                      1014,1015,1016,1017,1018,1020,1022,1023,1028,1030';

              $excont = explode('-', $content);
              $exdist = explode(',', $district);
              $d = 0;
              foreach ($exdist as $keyso):
                $disresult = MssController::getresultperdistrict($excont[$d], $request->users_id, $request->from, $request->to); 
              ?> 
              <tr>
                <td><?php echo e($exdist[$d]); ?></td>
                <td align="center" class="dohclass"><?php if($exdist[$d] == 'E.SAMAR' || $exdist[$d] == 'N.SAMAR'): ?> <?php echo e(' '); ?> <?php else: ?> <?php if($disresult[0]->result > 0): ?> <?php echo e($disresult[0]->result); ?> <?php else: ?> <?php echo e(" "); ?> <?php endif; ?> <?php endif; ?></td>
              </tr>
              <?php 
              $d++;
              endforeach;
              ?>
            </table>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="text-left" style="border: 1px solid black;height: 28px;">
            TOTAL  <font class="pull-right tot_doh" style="margin-right: 10px;margin-top: 5px;"></font>     
          </div>
        </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
        <div class="btn-group print_classification"> 
            <button  class="btn btn-default btn-fab" id="print_classification" onclick="window.print();"><i class="fa fa-print"></i></button>
        </div>
    </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('pagescript'); ?>
    <?php echo $__env->make('message/toaster', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="<?php echo e(asset('public/js/mss/report.js')); ?>"></script>

  <?php $__env->stopSection(); ?>

<?php echo $__env->renderComponent(); ?>

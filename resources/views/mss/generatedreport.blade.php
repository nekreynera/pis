<?php 

use app\Http\Controllers\MssController;

?>
@component('partials/header')

  @slot('title')
    PIS | REPORT
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/mss/report.css') }}" rel="stylesheet" />
    <style>
      #mssreport td{
        padding: 4px;
      }
      body{
        background-color: rgb(82, 86, 89);
      }
    </style>
  @endsection

  @section('header')
    @include('mss/navigation')
  @endsection

  @section('content')
    <div class="container mainWrapper" id="wrapper">
      <div class="panel" id="mssreport">
        <div class="panel-body" id="login-body" style="font-size: 12px;">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <p>STATISTICAL REPORT</p>

            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-4">
                @if($request->users_id == 'ALL')
                <p>OVERALL REPORT OF OPDRMS(MSS) USERS</p>
                @else
                <p style="text-transform: capitalize;">NAME: {{ $employee->last_name.' '.$employee->first_name }}</p>
                @endif
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              
              <p class="text-right">DATE/SHIFT: {{ $request->from.'-'.$request->to }}</p>
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
                  @if($exdist[$d] == "WESTERN SAMAR" || $exdist[$d] == "NORTHERN SAMAR" || $exdist[$d] == "EASTERN SAMAR")
                  <td><b>{{ $exdist[$d] }}</b></td>
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
                  @else
                  <td>{{ $exdist[$d] }}</td>
                  <td align="center" class="gh">@if($gh <= 0) {{ " " }} @else {{ $gh }} @endif</td>
                  <td align="center" class="phpc">@if($phpc <= 0) {{ " " }} @else {{ $phpc }} @endif</td>
                  <td align="center" class="polit">@if($polit <= 0) {{ " " }} @else {{ $polit }} @endif</td>
                  <td align="center" class="media">@if($media <= 0) {{ " " }} @else {{ $media }} @endif</td>
                  <td align="center" class="hct">@if($hct <= 0) {{ " " }} @else {{ $hct }} @endif</td>
                  <td align="center" class="ngo">@if($ngo <= 0) {{ " " }} @else {{ $ngo }} @endif</td>
                  <td align="center" class="govt">@if($govt <= 0) {{ " " }} @else {{ $govt }} @endif</td>
                  <td align="center" class="walkin">@if($walkin <= 0) {{ " " }} @else {{ $walkin }} @endif</td>
                  <td align="center" class="other">@if($other <= 0) {{ " " }} @else {{ $other }} @endif</td>
                  <td align="center" class="tot_totalperline success">{{ count($disresult) }}</td>
                  @endif
                  
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
                  <td>{{ $exdist[$d] }}</td>
                  <td align="center" class="a">@if($a <= 0) {{ " " }} @else {{ $a }} @endif</td>
                  <td align="center" class="b">@if($b <= 0) {{ " " }} @else {{ $b }} @endif</td>
                  <td align="center" class="c1">@if($c1 <= 0) {{ " " }} @else {{ $c1 }} @endif</td>
                  <td align="center" class="c2">@if($c2 <= 0) {{ " " }} @else {{ $c2 }} @endif</td>
                  <td align="center" class="c3">@if($c3 <= 0) {{ " " }} @else {{ $c3 }} @endif  </td>
                  <td align="center" class="sc"></td>
                  <td align="center" class="de">@if($de <= 0) {{ " " }} @else {{ $de }} @endif</td>
                  <td align="center" class="totals success" style="font-weight: bold;font-size: 12px;">{{ $total+$a+$b+$c1+$c2+$c3+$de }}</td>
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
                  <td>{{ $ed_exdist[$ed_d] }}</td>
                  <td align="center" class="ed_c1">@if($ed_c1 <= 0) {{ " " }} @else {{ $ed_c1 }} @endif</td>
                  <td align="center" class="ed_c2">@if($ed_c2 <= 0) {{ " " }} @else {{ $ed_c2 }} @endif</td>
                  <td align="center" class="ed_c3">@if($ed_c3 <= 0) {{ " " }} @else {{ $ed_c3 }} @endif  </td>
                  <td align="center" class="ed_totals success" style="font-weight: bold;font-size: 12px;">{{ $ed_total+$ed_c1+$ed_c2+$ed_c3 }}</td>
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
                  <td>{{ $d_exdist[$d_d] }}</td>
                  <td align="center" class="d_c1">@if($d_c1 <= 0) {{ " " }} @else {{ $d_c1 }} @endif</td>
                  <td align="center" class="d_c2">@if($d_c2 <= 0) {{ " " }} @else {{ $d_c2 }} @endif</td>
                  <td align="center" class="d_c3">@if($d_c3 <= 0) {{ " " }} @else {{ $d_c3 }} @endif  </td>
                  <td align="center" class="d_totals success" style="font-weight: bold;font-size: 12px;">{{ $d_total+$d_c1+$d_c2+$d_c3 }}</td>
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
                    <td>{{ $explo[$po] }}</td>
                    <td align="center" class="origclass">@if($origin) {{ $origin[0]->result }} @else {{ " " }} @endif</td>
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
                  @if ($exsect[$s] == 'BRGY')
                  <td>{{ 'BRGY. OFFICIAL' }}</td> 
                  <?php else: ?>
                  <td>{{ $exsect[$s] }}</td>
                  <?php endif ?>
                  <td align="center" class="sectclass">@if($secresult) @if($secresult[0]->result > 0) {{ $secresult[0]->result }} @else {{ " " }} @endif @else {{ " " }} @endif</td>
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
                    @if($excat[$cat] == 'O') 
                    <td>{{ 'OLD' }}</td>
                    @elseif($excat[$cat] == 'N')
                    <td>{{ 'NEW' }}</td>
                    @else
                    <td>{{ 'CASE FORWARD' }}</td>
                    @endif
                    
                    <td align="center" class="catclass">@if($catresult) @if($catresult[0]->result > 0) {{ $catresult[0]->result }} @else {{ " " }} @endif @else {{ " " }} @endif</td>
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
                  <td>{{ ($key->fourpis == 'Y')?"YES":"NO" }}</td>
                  <td align="center" class="fourclass">{{ $key->result }}</td>
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
                <td>{{ $exdist[$d] }}</td>
                <td align="center" class="dohclass">@if($disresult[0]->result > 0) {{ $disresult[0]->result }} @else {{ " " }} @endif</td>
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
                <td>{{ $exdist[$d] }}</td>
                <td align="center" class="dohclass">@if($exdist[$d] == 'E.SAMAR' || $exdist[$d] == 'N.SAMAR') {{ ' ' }} @else @if($disresult[0]->result > 0) {{ $disresult[0]->result }} @else {{ " " }} @endif @endif</td>
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
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/mss/report.js') }}"></script>

  @endsection

@endcomponent

@component('partials/header')

  @slot('title')
    PIS | MALASAKIT
  @endslot

  @section('pagestyle')
    <link href="{{ asset('public/css/mss/malasakit.css') }}" rel="stylesheet" />
  @endsection

  @section('header')
    @include('mss/navigation')
  @endsection

  @section('content')
    <div class="container mainWrapper">
          <div class="panel" id="malasakit-form">
            <div class="panel-default">
              <div class="panel-header">
                <h3>MALASAKIT FORM <i class="fa fa-file-o"></i></h3>
              </div>
              <div class="panel-body">
                <form class="form-horizontal malasakitformsubmit" method="post" action='{{ url("malasakitsave") }}'>
                   {{ csrf_field() }}
                     <input type="hidden" name="patients_id" value="{{ $patient->patients_id }}" />
                     <input type="hidden" name="classification_id" value="{{ $id }}">
                <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr>
                        <td align="center">Date of Intake/Interview</td>
                        <td><input type="text" name="" class="form-control" value="{{ Carbon::parse()->now()->format('d/m/Y') }}"><p align="center">dd/mm/yyyy</p></td>
                        <td align="center">Time of Interview</td>
                        <td><input type="text" name="" class="form-control" value="{{ Carbon::parse()->now()->format('h:i:a') }}"></td>
                      </tr>
                      <tr>
                        <td align="center">Name of Informant</td>
                        <td><input type="text" name="mlkstinterviewed" class="form-control" value="{{ $patient->mlkstinterviewed }}"><p align="center">Full Name</p></td>
                        <td align="center">Relation to Patient</td>
                        <td><input type="text" name="mlkstrelpatient" class="form-control" value="{{ $patient->mlkstrelpatient }}"></td>
                      </tr>
                      <tr>
                        <td colspan="3"><input type="text" name="mlkstaddress" class="form-control" value="{{ $patient->mlkstaddress }}"><p align="center">Address</p></td>
                        <td><input type="text" name="mlkstcontact" class="form-control" value="{{ $patient->mlkstcontact }}"><p align="center">Contact Number</p></td>
                      </tr>
                      <tr>
                        <th colspan="4" class="">I. IDENTIFYING INFORMATION</th>
                      </tr>
                      <tr>
                        <td align="center">Client's Name</td>
                        <td colspan="2">
                          <input type="text" name="" class="form-control" value="{{ $patient->last_name.', '.$patient->first_name.' '.$patient->middle_name }}" style="text-align: center;">
                          <p align="center">Last Name&nbsp;&nbsp; , &nbsp;&nbsp;First Name&nbsp;&nbsp;&nbsp;&nbsp; Middle Name&nbsp;&nbsp;&nbsp;&nbsp; Ext(Sr. Jr. ) </p></td>
                        <td>
                            <input type="text" name="" class="form-control" value='{{ ($patient->sex == "M")?"MALE":"FEMALE" }}' style="text-align: center;">
                            <p align="center">Gender</p>
                          </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" name="" class="form-control" value="{{ Carbon::parse($patient->birthday)->format('d/m/Y') }}" style="text-align: center;">
                          <p align="center">Date of Birth (dd/mm/yyyy)</p></td>
                          @php
                              $agePatient = App\Patient::age($patient->birthday)
                          @endphp
                        <td><input type="text" name="" class="form-control" value="{{ $agePatient }}" style="text-align: center;"><p align="center">Age</p></td>
                        <td colspan="2"><input type="text" name="pob" class="form-control" value="{{ $patient->pob }}"><p align="center">Place of Birth</p></td>
                      </tr>
                      <tr>
                        <td colspan="4">
                          <div class="row col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon">Permanent Address: </span>
                              <input type="text" name="" class="form-control" value="{{ $patient->address }}">
                            </div>
                            <p align="center">St. Number, Barangay, City/Municipality, District, Province, Region</p>
                            
                          </div>
                          
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4">
                          <div class="row col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon">Present Address: </span>
                              <input type="text" name="temp_address" class="form-control" value="{{ $patient->temp_address }}">
                            </div><p align="center">St. Number, Barangay, City/Municipality, District, Province, Region</p>
                          </div>
                        </td>
                      </tr>
                      
                        <tr>
                          <td> &nbsp;&nbsp;&nbsp;&nbsp;Civil Status : </td>
                          <td>
                           
                                <select class="form-control" name="civil_statuss">
                                  <option value="" @if ($patient->civil_statuss == "") {{ "selected" }} @endif>--choose--</option>
                                  <option value="child" @if ($patient->civil_statuss == "Infant") {{ "selected" }} @endif>Infant</option>
                                  <option value="child" @if ($patient->civil_statuss == "child") {{ "selected" }} @endif>Child</option>
                                  <option value="minor" @if ($patient->civil_statuss == "minor") {{ "selected" }} @endif>Minor</option>
                                  <option value="Common-law" @if ($patient->civil_statuss == "Common-law") {{ "selected" }} @endif>Common law</option>
                                  <option value="Married" @if ($patient->civil_statuss == "Married") {{ "selected" }} @endif>Married</option>
                                  <option value="Sep-fact" @if ($patient->civil_statuss == "Unwed") {{ "selected" }} @endif>Unwed</option>
                                  <option value="Sep-fact" @if ($patient->civil_statuss == "Sep-fact") {{ "selected" }} @endif>Separated - infact</option>
                                  <option value="Sep-legal" @if ($patient->civil_statuss == "Sep-legal") {{ "selected" }} @endif>Separated - legal</option>
                                  <option value="Single" @if ($patient->civil_statuss == "Single") {{ "selected" }} @endif>Single</option>
                                  <option value="Widow" @if ($patient->civil_statuss == "Widow") {{ "selected" }} @endif>Widow</option>
                                  <option value="Divorce" @if ($patient->civil_statuss == "Divorce") {{ "selected" }} @endif>Divorce</option>
                                
                                </select>
                               
                            
                          </td>
                          <td colspan="2">
                            
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <div class="input-group col-md-12">
                                <span class="input-group-addon">Religion : </span>
                                <input type="" name="religion" class="form-control" value="{{ $patient->religion }}">
                              </div>
                          </td>
                          <td colspan="2">
                              <div class="input-group col-md-12">
                                <span class="input-group-addon">Nationality : </span>
                                <input type="" name="mlkstnationality" class="form-control" value="{{ $patient->mlkstnationality }}">
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <td> &nbsp;&nbsp;&nbsp;&nbsp;Highest Educational Attainment : </td>
                          <td>
                                <select class="form-control" name="education">
                                  <option value="" hidden></option>
                                  <option value="Post-graduate" @if($patient->education == "Post-graduate") selected @endif> Post-graduate</option>
                                  <option value="College" @if($patient->education == "College") selected @endif> College</option>
                                  <option value="Vocational" @if($patient->education == "Vocational") selected @endif> Vocational</option>
                                  <option value="High School" @if($patient->education == "High School") selected @endif> High School</option>
                                  <option value="Elementary" @if($patient->education == "Elementary") selected @endif> Elementary</option>
                                  <option value=" " @if($patient->education == " ") selected @endif> None</option>
                                </select>
                          </td>
                          <td colspan="2">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                              <div class="input-group col-md-12">
                                <span class="input-group-addon">Occupation : </span>
                                <input type="" name="occupation" class="form-control" value="{{ $patient->occupation }}">
                              </div>
                          </td>
                          <td colspan="2">
                              <div class="input-group col-md-12">
                                <span class="input-group-addon">Monthly Income : </span>
                                <input type="" name="income" class="form-control" value="{{ $patient->income }}">
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">Sectoral Membership</td>
                        </tr>
                        <tr>
                          @php  
                            $sectorial = explode(",", $patient->mlkstsectorial);
                          @endphp
                          <td colspan="4">
                              <div class="col-md-4 col-md-offset-1" style="padding: 3px;">
                                @if (in_array(1, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='1' checked> Children in need of special protection<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='1'> Children in need of special protection<br>
                                @endif
                                @if (in_array(2, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='2' checked> Youth in need of special protection<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='2'> Youth in need of special protection<br>
                                @endif
                                @if (in_array(3, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='3' checked> Women in Especially Difficult Circumstance<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='3'> Women in Especially Difficult Circumstance<br>
                                @endif
                                @if (in_array(4, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='4' checked> Family Head & Other Needy Adult<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='4'> Family Head & Other Needy Adult<br>
                                @endif
                                @if (in_array(5, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='5' checked @if($patient->sectorial == "INDIGENOUS PEOPLE") checked @endif> Indigenous People<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='5' @if($patient->sectorial == "INDIGENOUS PEOPLE") checked @endif> Indigenous People<br>
                                @endif
                              </div>
                              <div class="col-md-4" style="padding: 3px;">
                                @if (in_array(6, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='6' checked> Inmate<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='6'> Inmate<br>
                                @endif
                                @if (in_array(7, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='7' checked> Senior Citizen<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='7'> Senior Citizen<br>
                                @endif
                                @if (in_array(8, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='8' checked @if($patient->sectorial == "PWD") checked @endif> Person with Disability<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='8' @if($patient->sectorial == "PWD") checked @endif> Person with Disability<br>
                                @endif
                                @if (in_array(9, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='9' checked @if($patient->sectorial == "BRGY") checked @endif> Barangay Official<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='9' @if($patient->sectorial == "BRGY") checked @endif> Barangay Official<br>
                                @endif
                                @if (in_array(10, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='10' checked @if($patient->sectorial == "BHW") checked @endif> BHW<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='10' @if($patient->sectorial == "BHW") checked @endif> BHW<br>
                                @endif
                               
                              </div>
                              <div class="col-md-3" style="padding: 3px;">
                                @if (in_array(11, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='11' checked> Personnel<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='11'> Personnel<br>
                                @endif
                                @if (in_array(12, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='12' checked> Personnel Dependent<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='12'> Personnel Dependent<br>
                                @endif
                                @if (in_array(13, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='13' checked> 4Ps<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='13'> 4Ps<br>
                                @endif
                                @if (in_array(14, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='14' checked> Gov't Employee<br>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='14'> Gov't Employee<br>
                                @endif
                                @if (in_array(15, $sectorial))
                                <input type="checkbox" name="mlkstsectorial[]" value='15' checked @if(substr($patient->sectorial,0,6) == "OTHERS") checked @endif>
                                @else
                                <input type="checkbox" name="mlkstsectorial[]" value='15' @if(substr($patient->sectorial,0,6) == "OTHERS") checked @endif>
                                @endif
                                  @if(substr($patient->sectorial,0,6) == "OTHERS")
                                    {{ $patient->sectorial }} 
                                  @else
                                    {{ "Others(specify)" }}
                                  @endif<br>
                              </div>
                              <!-- <div class="col-md-10">Children in need of special protection</div> -->
                          </td>
                        </tr>
                        <tr>
                          <th colspan="4">
                            II BENEFICIARIES INFORMATION (for DSWD use only)
                          </th>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-4">
                              Nature of Assistance Requested input
                            </div>
                            <div class="col-md-2">
                              <input type="checkbox" name=""> &nbsp;In - Patient
                            </div>
                            <div class="col-md-6">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> &nbsp;Out - Patient
                            </div>
                            <div class="col-md-6">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> Confinement
                            </div>
                             <div class="col-md-6">
                              <input type="checkbox" name=""> Laboratory/Diagnostic Procedure (Specify)
                            </div>
                            <div class="col-md-2">
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> Dialysis:  
                            </div>
                            <div class="col-md-4">
                              <input type="checkbox" name=""> Hemodialysis
                            </div>
                             <div class="col-md-6">
                              <input type="checkbox" name=""> Medical Device (pacemaker, stent, etc)
                            </div>

                            <div class="col-md-4 col-md-offset-2">
                              <input type="checkbox" name=""> Peritoneal
                            </div>
                            <div class="col-md-6">
                              <input type="checkbox" name=""> Surgical Supplies
                            </div>
                             
                             <div class="col-md-6">
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> Chemotherapy
                             </div>
                              <div class="col-md-6">
                               <input type="checkbox" name=""> Impalnt (bone, cochlear, etc)
                             </div>
                             <div class="col-md-6">
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> Radation Therapy
                             </div>
                              <div class="col-md-6">
                               <input type="checkbox" name=""> Assistive Device (hearing aid, wheelchair, prosthesis)
                             </div>
                             <div class="col-md-6">
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""> Medicines
                             </div>
                              <div class="col-md-6">
                               <input type="checkbox" name=""> Non & Minimally Non-invasive Procedures
                             </div>
                             <div class="col-md-2 col-md-offset-1">
                               <input type="checkbox" name=""> Anti Rabies
                             </div>
                             <div class="col-md-3">
                               <input type="checkbox" name=""> Psychiatric
                             </div>
                             <div class="col-md-6">
                               <input type="checkbox" name=""> (ESWL, Endoscopy, Laparoscopic Procedure, etc)
                             </div>

                             <div class="col-md-2 col-md-offset-1">
                               <input type="checkbox" name=""> Post-Op
                             </div>
                             <div class="col-md-3">
                               <input type="checkbox" name=""> Post Transplant
                             </div>
                             <div class="col-md-6">
                               <input type="checkbox" name=""> Transplant (Specify)
                             </div>

                             <div class="col-md-2 col-md-offset-1">
                               <input type="checkbox" name=""> Factor 8,9
                             </div>
                             <div class="col-md-3">
                               <input type="checkbox" name=""> Antibiotics
                             </div>
                             <div class="col-md-6">
                               <input type="checkbox" name=""> Rehabilittative Therapy (Physical, Occupational, Speech)
                             </div>

                             <div class="col-md-2 col-md-offset-1">
                               <input type="checkbox" name=""> OR Medicines
                             </div>
                             <div class="col-md-3">
                               <input type="checkbox" name=""> IVIG
                             </div>
                             <div class="col-md-6">
                               <input type="checkbox" name=""> Others (specify)
                             </div>
                             <div class="col-md-2 col-md-offset-1">
                               <input type="checkbox" name=""> Others (specify)
                             </div>
                          </td>
                          
                        </tr>
                        <tr>
                          <th colspan="4">
                            III. FAMILY COMPOSITION
                          </th>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <table class="table table-bordered" id="familytable">
                              <tr>
                                <td>Last Name/First Name/Middle Name</td>
                                <td>Birthdate</td>
                                <td>Sex</td>
                                <td>Civil Status</td>
                                <td>Relation to Patient</td>
                                <td>Highest Education Attainment</td>
                                <td>Occupation</td>
                                <td>Monthly Income</td>
                              </tr>
                              @php
                              $s = 0
                              @endphp
                              @foreach($family as $list)
                              <tr>
                                <td hidden><input type="" name="id[]" value="{{ $list->id }}"></td>
                                <td><input type="text" name="name[]" class="form-control" value="{{ $list->name }}"></td>
                                <td><input type="date" name="birthday[]" class="form-control" value="{{ $list->birthday }}"></td>
                                <td><select class="form-control" name="sex[]">
                                      <option></option>
                                      <option value="M" @if($list->sex == "M") selected @endif>MALE</option>
                                      <option value="F" @if($list->sex == "F") selected @endif>FEMALE</option>
                                    </select>
                                </td>
                                <td><select class="form-control" name="status[]">
                                        <option value="" @if ($list->status == "") selected @endif>--choose--</option>
                                        <option value="child" @if ($list->status == "Infant") selected @endif>Infant</option>
                                        <option value="child" @if ($list->status == "child") selected @endif>Child</option>
                                        <option value="minor" @if ($list->status == "minor") selected @endif>Minor</option>
                                        <option value="Common-law" @if ($list->status == "Common-law") selected @endif>Common law</option>
                                        <option value="Married" @if ($list->status == "Married") selected @endif>Married</option>
                                        <option value="Sep-fact" @if ($list->status == "Unwed") selected @endif>Unwed</option>
                                        <option value="Sep-fact" @if ($list->status == "Sep-fact") selected @endif>Separated - infact</option>
                                        <option value="Sep-legal" @if ($list->status == "Sep-legal") selected @endif>Separated - legal</option>
                                        <option value="Single" @if ($list->status == "Single") selected @endif>Single</option>
                                        <option value="Widow" @if ($list->status == "Widow") selected @endif>Widow</option>
                                        <option value="Divorce" @if ($list->status == "Divorce") selected @endif>Divorce</option>
                                    </select>
                                </td>
                                <td><input type="text" name="relationship[]" class="form-control" value="{{ $list->relationship }}"></td>
                                <td><input type="text" name="feducation[]" class="form-control" value="{{ $list->feducation }}"></td>
                                <td><input type="text" name="foccupation[]" class="form-control" value="{{ $list->foccupation }}"></td>
                                <td><input type="text" name="fincome[]" class="form-control" value="{{ $list->fincome }}"></td>
                              </tr>
                              @php
                              $s++;
                              @endphp
                              @endforeach
                              @for($i=$s;$i<=8;$i++)
                              <tr>
                                <td hidden><input type="" name="id[]" value=""></td>
                                <td><input type="text" name="name[]" class="form-control"></td>
                                <td><input type="date" name="birthday[]" class="form-control"></td>
                                <td><select class="form-control" name="sex[]">
                                      <option></option>
                                      <option>MALE</option>
                                      <option>FEMALE</option>
                                    </select>
                                </td>
                                <td><select class="form-control" name="status[]">
                                        <option value=""></option>
                                        <option value="Infant">Infant</option>
                                        <option value="child">Child</option>
                                        <option value="minor">Minor</option>
                                        <option value="Common-law">Common law</option>
                                        <option value="Married">Married</option>
                                        <option value="Unwed">Unwed</option>
                                        <option value="Sep-fact">Separated - infact</option>
                                        <option value="Sep-legal">Separated - legal</option>
                                        <option value="Single">Single</option>
                                        <option value="Widow">Widow</option>
                                        <option value="Divorce">Divorce</option>
                                    </select>
                                </td>
                                <td><input type="text" name="relationship[]" class="form-control"></td>
                                <td><input type="text" name="feducation[]" class="form-control"></td>
                                <td><input type="text" name="foccupation[]" class="form-control"></td>
                                <td><input type="text" name="fincome[]" class="form-control"></td>
                              </tr>
                              @endfor
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>Other Source/s Family income</td>
                          <td><input type="text" name="source_income" class="form-control" placeholder="Php" value="{{ $patient->source_income }}"></td>
                          <td>Total Family Income</td>
                          <td><input type="text" name="mlksttfincome" class="form-control" placeholder="Php" value="{{ $patient->mlksttfincome }}"></td>
                        </tr>
                        <tr>
                          <td align="center" colspan="4"><b>Breakdown</b></td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-6">
                              <div class="input-group">
                                
                                <span class="input-group-addon"><b>House/Lot : </b></span>
                                <input type="text" name="" class="form-control" disabled="" style="background-color: white;cursor: text;">
                              </div>
                            </div>
                             <div class="col-md-6">
                             
                                
                               <div class="input-group">
                                <input type="checkbox" name="" class="form-control">
                                <span class="input-group-addon">Food : </span>
                                <input type="text" name="food" class="form-control" value="{{ $patient->food }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            @php $house = explode('-',trim($patient->houselot)); @endphp
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="rentedcheck" name="houselot" value="{{ $patient->houselot }}" @if ($house[0] == "rented") checked @endif> Rented </span>
                                <input type="text" name="" class="form-control rentedtext" @if($house[0] == 'rented') value="{{ $house[1] }}"  @endif>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="ownedcheck" name="houselot"  value="owned" @if ($house[0] == "owned") checked @endif> Owned </span>
                                <input type="text" name="" class="form-control" disabled style="background-color: white;cursor: text;">
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Education : </span>
                                <input type="text" name="educationphp" class="form-control" value="{{ $patient->educationphp }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><b>Light Source : </b></span>
                                <input type="text" name="" class="form-control" disabled="" style="background-color: white;cursor: text;">
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Clothing : </span>
                                <input type="text" name="clothing" class="form-control" value="{{ $patient->clothing }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                             @php $light = explode('-',trim($patient->light)); @endphp
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="electriccheck" name="light" value="{{ $patient->light }}" @if ($light[0] == "electric") checked @endif> Electric(amount) </span>
                                <input type="text" class="form-control electrictext" @if($light[0] == 'electric') value="{{ $light[1] }}"  @endif>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="candlecheck" name="light" value="{{ $patient->light }}" @if ($light[0] == "candle") checked @endif> Candle(amount) </span>
                                <input type="text" class="form-control candletext" @if($light[0] == 'candle') value="{{ $light[1] }}"  @endif>
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Transportation : </span>
                                <input type="text" name="transportation" class="form-control" value="{{ $patient->transportation }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="4">
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="kerosenecheck" name="light" value="{{ $patient->light }}" @if ($light[0] == "kerosene") checked @endif> kerosene(amount) : </span>
                                <input type="text" class="form-control kerosenetext" @if($light[0] == 'kerosene') value="{{ $light[1] }}"  @endif>
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Househelp : </span>
                                <input type="text" name="house_help" class="form-control" value="{{ $patient->house_help }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="4">
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><b>Water Source : </b></span>
                                <input type="text" name="" class="form-control" disabled style="background-color: white;cursor: text;">
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Medical Expenditure : </span>
                                <input type="text" name="expinditures" class="form-control" value="{{ $patient->expinditures }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                         <tr>
                          <td colspan="4">
                            <?php $water = explode('-',trim($patient->water));?>
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp; Artesian Well</span>
                                <input type="text" name="" class="form-control" disabled style="background-color: white;cursor: text;">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="publicchecked" name="water" value="{{ $patient->water }}" @if ($water[0] == "public") checked @endif> public(amount)</span>
                                <input type="text" name="" class="form-control publictext" @if($water[0] == 'public') value="{{ $water[1] }}"  @endif>
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Insurance Premium : </span>
                                <input type="text" name="insurance" class="form-control" value="{{ $patient->insurance }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-3 col-md-offset-3">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="ownedwcheck" name="water" value="{{ $patient->water }}" @if ($water[0] == "owned") checked @endif> owned(amount)</span>
                                <input type="text" name="" class="form-control ownedwtext" @if($water[0] == 'owned') value="{{ $water[1] }}"  @endif>
                              </div>
                            </div>
                             <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon">Others : </span>
                                <input type="text" name="other_expenses" class="form-control" value="{{ $patient->other_expenses }}">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-6">
                              <div class="input-group">
                                <span class="input-group-addon"><input type="checkbox" class="wdcheck" name="water" value="{{ $patient->water }}" @if ($water[0] == "water_distric") checked @endif> Water District : </span>
                                <input type="text" name="" class="form-control wdtext" @if($water[0] == 'water_distric') value="{{ $water[1] }}"  @endif>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="4">IV. ASSESSMENT</th>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="col-md-12">
                              <b>Problem Presented</b>
                            </div>
                             @php  
                                $problem = explode(",", $patient->mlkstproblem);
                              @endphp
                            <div class="col-md-5 col-md-offset-1">
                                @if (in_array(1, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="1 " checked> Health Condition of Patient (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="1"> Health Condition of Patient (specify)
                                @endif
                            </div>
                            <div class="col-md-6">
                              @if (in_array(4, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="4" checked> Economic resources (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="4"> Economic resources (specify)
                                @endif
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                              @if (in_array(2, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="2" checked> Food/Nutrition (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="2"> Food/Nutrition (specify)
                                @endif
                            </div>
                            <div class="col-md-6">
                              @if (in_array(5, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="5" checked> Housing (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="5"> Housing (specify)
                                @endif
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                              @if (in_array(3, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="3" checked> Employment (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="3"> Employment (specify)
                                @endif
                            </div>
                            <div class="col-md-6">
                              @if (in_array(6, $problem))
                              <input type="checkbox" name="mlkstproblem[]" value="6" checked> Others (specify)
                                @else
                              <input type="checkbox" name="mlkstproblem[]" value="6"> Others (specify)
                                @endif
                            </div>
                            <div class="col-md-12">
                              <b>Social Worker's Assesment: </b>
                              <textarea class="form-control" name="mlkstassesment">{{ $patient->mlkstassesment }}</textarea>
                            </div>
                          </td>
                        </tr>

                    </table>
                    <div class="col-md-12">
                      <div class="btn-group submit_classification">
                          <button type="submit" class="btn btn-success btn-fab" id="submit_classification"><i class="fa fa-check"></i></button>
                      </div>
                    </div>
                  
                </div>          
              </form>
              </div>
            </div>
           </div>
    </div>
  @endsection

  @section('pagescript')
    @include('message/toaster')
    <script src="{{ asset('public/js/mss/malasakit.js') }}"></script>

  @endsection

@endcomponent

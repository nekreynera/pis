@component('partials/header')



  @slot('title')
    PIS | classification
  @endslot



  @section('pagestyle')
    <link href="{{ asset('public/css/mss/view.css') }}" rel="stylesheet" />
  @endsection



  @section('header')
    @include('mss/navigation')
  @endsection



  @section('content')
  <div class="container mainWrapper">
  	<div class="panel" id="classification_panel">
  		<div class="panel-default">
  			<div class="panel-heading">
  				<h3>PATIENT CLASSIFICATION</h3>
  			</div>
  			<div class="panel-body table-responsive">
           <div class="col-sm-3 n nameofinterviewed" style="padding: 0px;margin-bottom: 5px;margin-top: -15px;">
               <p>NAME OF INTERVIEWEE: {{ $view->interviewed }}</p>
           </div>
  				<table class="table table-bordered PgovStatus" id="PgovStatus" style="margin-bottom: 0px;border-bottom: 0px;">
  					<tr style="text-align: center;">
  						<td width="25%" >DATE OF INTERVIEW: <br>{{ $view->created_at }}</td>
  						<td width="25%">DATE OF ADMISSION/CONSULTATION:  <br> {{ $view->date_admission }}</td>
  						<td width="17%" align="center">WARD: <br> OPD</td>
  						<td width="17%">HOSP NO: <br> {{ $view->hospital_no }}</td>
  						<td width="16%">MSWD NO: <br> {{ $view->mswd }}</td>
  					</tr>
  					<tr>
  						<td colspan="2">SOURCE OF REFERRAL: {{ $view->referral }}</td>
  						<td colspan="2">ADDRESS: {{ $view->referral_addrress }}</td>
  						<td>TEL. NO: {{ $view->referral_telno }}</td>
  					</tr>
  					<tr>
  						<th colspan="5">&nbsp;I. DEMOGRAPHIC DATA: </th>

  					</tr>
  					<tr>
  						<td colspan="2">RELIGION: {{ $view->religion }}</td>
  						<td colspan="3">COMPANION UPON ADMISSION: {{ $view->companion }}</td>
  					</tr>
  					<tr align="center">
  						<td>PATIENTS NAME</td>
  						<td>AGE</td>
  						<td>SEX</td>
  						<td>GENDER</td>
  						<td>CIVIL STATUS</td>
  					</tr>
  					<tr align="center">
  						<td>{{ $view->last_name.', '.$view->first_name.' '.$view->middle_name }}</td>
  						<td>{{ $view->age}}</td>
                        <td>{{ ($view->sex == 'M')?"MALE":"FEMALE" }}</td>
  						<td>{{ ($view->gender == 'M')?"MASCULANE":"FEMININE" }}</td>
  						<td>{{ $view->civil_status }}</td>
  					</tr>
  					<tr>
  						<td colspan="2" style="padding: 3px!important;">PERMANET ADDRESSS: <br><br>{{ $view->address }}</td>
  						<td colspan="2" style="padding: 3px!important;">TEMPORARY ADDRESS: <br><br>{{ $view->temp_address }}
  						</td>
  						<td style="padding: 3px!important;text-align:center">DATE/PLACE OF BIRTH: <br>{{ $view->birthday }}<br>
  						{{ $view->pob }}
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">
  							<div class="col-sm-6" style="padding: 0px;">
  								&nbsp;KIND OF LIVING ARRANGEMENT: &nbsp;
  							</div>
  							<div class="col-sm-6" style="padding: 0px;">
                                    @if($view->living_arrangement == "O")
                                        {{ "Owned" }}
                                    @elseif($view->living_arrangement == "R")
                                        {{ "Rented" }}
                                    @elseif($view->living_arrangement == "S")
                                        {{ "Shared" }}
                                    @elseif($view->living_arrangement == "I")
                                        {{ "Institution" }}
                                    @elseif($view->living_arrangement == "H")
                                        {{ "Homeless" }}
                                    @endif
                            </div>
  						</td>
  						<td colspan="3"></td>
  					</tr>
  					<tr>
  						<td colspan="2">{{ $view->education }}</td>
  						<td rowspan="2">EMPLOYER: <br>{{ $view->employer }}</td>
  						<td rowspan="2">INCOME: <br>{{ $view->income }}</td>
  						<td rowspan="2">PER CAPITA INCOME: <br>{{ $view->capita_income }}</td>
  					</tr>
  					<tr>
  						<td colspan="2">{{ $view->occupation }}</td>
  					</tr>
  					<tr>
  						<td>PHILHEALTH: {{ ($view->philhealth == 'M')?"MEMBER":"DEPENDENT" }}</td>
  						<td align="center">CATEGORY</td>
  						<td align="center">4P's</td>
  						<td colspan="2" align="center">CLASSIFICATION </td>
  					</tr>
  					<tr>
  						<td>TYPE: {{ $view->membership }}</td>
  						<td align="center">
                            @if($view->category == "O")
                                {{ "Old Pt" }}
                            @elseif($view->category == "N")
                                {{ "New Pt" }}
                            @else
                                {{ "Case Forward" }}
                            @endif
                        
                        </td>
  						<td align="center">{{ $view->fourpis }}</td>
  						<td  colspan="2" align="center">
  							{{ $view->label."-".$view->description }}
  						</td>
  					</tr>
  					<tr>
  						<td colspan="2">SECTORIAL MEMBERSHIP: {{ $view->sectorial }}</td>
  						<td colspan="3"></td>
  					</tr>
  				</table>
  				<table class="table table-bordered" id="PgovStatus">
  					<tr align="center">
  						<td colspan="7">FAMILY COMPOSITION</td>
  					</tr>
  					<tr align="center">
  						<td width="30%">NAME</td>
  						<td width="10%">AGE</td>
  						<td>CIVIL STATUS</td>
  						<td>RELATION TO PATIENT</td>
  						<td>EDUC'L ATTAINMENT</td>
  						<td>OCCUPATION</td>
  						<td>MONTHLY INCOME</td>
  					</tr>
            <?php $count = 1; ?> 
            @foreach($family as $list)
                    <tr>
                        <td>{{ $count.". ".$list->name }}</td>
                        <td>{{ $list->age }}</td>
                        <td>{{ $list->status }}</td>
                        <td>{{ $list->relationship }}</td>
                        <td>{{ $list->feducation }}</td>
                        <td>{{ $list->foccupation }}</td>
                        <td>{{ $list->fincome }}</td>
                    </tr>
            <?php $count++; ?>
            @endforeach

            @for($i = $count; $i<=8;$i++)
  					<tr>
  						<td>{{ $i }}</td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  						<td></td>
  					</tr>
            @endfor

  					<tr>
  						<td colspan="3">OTHER SOURCES OF INCOME: {{ $view->source_income }}</td>
  						<td colspan="4">HOUSEHOLD SIZE: {{ $view->household }}</td>
  					</tr>
  					<tr>
  						<td colspan="3">MONHTLY EXPENSES: {{ $view->monthly_expenses }}</td>
  						<td colspan="4">TOTAL MONTHLY EXPENDITURES: {{ $view->monthly_expenditures }}</td>
  					</tr>
  					<tr>
  						<td>HOUSE AND LOT: {{ $view->houselot }} </td>
  						<td colspan="2">LIGHT SOURCE: {{ $view->light }} </td>
  						<td colspan="2">WATER SOURCE: {{ $view->water }} </td>
  						<td colspan="2">FUEL SOURCE: {{ $view->fuel }} </td>
  					</tr>
  					<tr>
  						<td>FOOD: Php {{ $view->food }}</td>
  						<td colspan="2">EDUCATION: Php {{ $view->educationphp }} </td>
  						<td colspan="2">CLOTHING: Php {{ $view->clothing }}</td>
  						<td colspan="2">TRANSPORATION: Php {{ $view->transportation }}</td>
  					</tr>
  					<tr>
  						<td>HOUSE HELP: Php {{ $view->house_help }}</td>
  						<td colspan="2">MEDICAL EXPENDITURES: Php {{ $view->expinditures }}</td>
  						<td colspan="2">INSURANCE PREMIUM: Php {{ $view->insurance }}</td>
  						<td colspan="2">OTHERS: {{ $view->other_expenses }}</td>
  					</tr>
  					<tr>
  						<td colspan="3">INTERNET CONNECTION: Php {{ $view->internet }}</td>
  						<td colspan="4">CABLE: Php {{ $view->cable }}</td>
  					</tr>
  					<tr>
  						<th colspan="7">II. MEDICAL RECORD</th>
  					</tr>
  					<tr>
  						<td>MEDICAL DATA: <br>{{ $view->medical }}</td>
  						<td colspan="3">ADMITTING DIAGNOSIS: <br> {{ $view->admitting }}</td>
  						<td colspan="3">FINAL DIAGNOSIS:    <br> {{ $view->final }}</td>
  					</tr>
  					<tr>
  						<td colspan="7">DURATION OF PROBLEM/ SYMPTOMS: {{ $view->duration }}</td>
  					</tr>
  					<tr>
  						<td colspan="7">PREVIOUS TREATMENT DURATION: {{ $view->previus }} </td>
  					</tr>
  					<tr>
  						<td colspan="7">PRESENT TREATMENT PLAN: {{ $view->present }}</td>
  					</tr><tr>
  						<td colspan="7">HEALTH ACCESSIBILITY PROBLEM: {{ $view->health }}</td>
  					</tr>
  					<tr>
  						<td colspan="3">ASSESSMENT FINDINGS: {{ $view->findings }}</td>
  						<td colspan="4">RECOMMENDED INTERVENTIONS: {{ $view->interventions }}</td>
  					</tr>
  					<tr>
  						<td colspan="3">PRE-ADMISSION PLANNING: {{ $view->admision }}
  						</td>
  						<td colspan="4">DISCHARGE PLANNING: {{ $view->planning }}</td>
  					</tr>
  					<tr>
  						<td colspan="7">COUNSELING: {{ $view->counseling }}</td>
  					</tr>
  				</table>
  			</div>
  		</div>
  	</div>
  </div>

  @endsection
@endcomponent

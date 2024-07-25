<thead>
<tr>
    <th hidden></th>
    <th>#</th>
    <th>PATIENTS NAME</th>
    <th>AGE</th>
    <th>ASSIGNED TO</th>
    <th width="64px" data-placement="top" data-toggle="tooltip" title="Patient Information">INFO</th>

    <?php if(in_array(Auth::user()->clinic, $noDoctorsClinic)): ?>
    <th>ACTION</th>
    <?php endif; ?>
    
    <th data-placement="top" data-toggle="tooltip" title="Medical Records">RECORDS</th>

    

    <th data-placement="top" data-toggle="tooltip" title="Proceed to Charging">DATE/TIME</th>

    <?php if(in_array(Auth::user()->clinic, $chrgingClinics)): ?>
        <th data-placement="top" data-toggle="tooltip" title="Time Scanned">CHARGING</th>
    <?php endif; ?>
    
</tr>
</thead>
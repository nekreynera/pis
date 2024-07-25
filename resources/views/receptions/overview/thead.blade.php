<thead>
<tr>
    <th hidden></th>
    <th>#</th>
    <th>Patient</th>
    <th>Age</th>

    @if(Auth::user()->clinic != 31)
        <th>Doctor</th>
    @endif

    <th width="64px" data-placement="top" data-toggle="tooltip" title="Patient Information">Info</th>

    @if(Auth::user()->clinic != 31)
        <th data-placement="top" data-toggle="tooltip" title="Medical Records">Record</th>
    @endif
    @if(!in_array(Auth::user()->clinic, $noDoctorsClinic))
        <th data-placement="top" data-toggle="tooltip" title="Assign to Doctor">Assign</th>
        <th data-placement="top" data-toggle="tooltip" title="Re-Assign Patient">ReAssign</th>
    @endif

    <th data-placement="top" data-toggle="tooltip" title="Cancel Patient">Remove</th>
    <th>Notes</th>
    <th data-placement="top" data-toggle="tooltip" title="Time Scanned">Timestamp</th>

    @if(in_array(Auth::user()->clinic, $noDoctorsClinic))
        <th data-placement="top" data-toggle="tooltip" title="Mark as Done">Action</th>
    @endif

    @if(in_array(Auth::user()->clinic, $chrgingClinics))
        <th data-placement="top" data-toggle="tooltip" title="Click to enable charging" class="text-center">Charging</th>
    @endif
</tr>
</thead>
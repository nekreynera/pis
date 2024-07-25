<div id="home" class="tab-pane fade in active">


    <div class="col-md-6">


        <br>
        <br>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th>Name :</th>
                    <td>{{ $patient->last_name.', '.$patient->first_name }}</td>
                </tr>
                <tr>
                    <th>Hospital No. :</th>
                    <td>{{ $patient->hospital_no }}</td>
                </tr>
                <tr>
                    <th>QRCODE :</th>
                    <td>{{ $patient->barcode }}</td>
                </tr>
                <tr>
                    <th>Birthday :</th>
                    <td>{{ Carbon::parse($patient->birthday)->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th>Age :</th>
                    <td>{{ App\Patient::age($patient->birthday) }}</td>
                </tr>
                <tr>
                    <th>Address :</th>
                    <td>{{ $patient->address }}</td>
                </tr>
                <tr>
                    <th>Civil Status :</th>
                    <td>{{ $patient->civil_status }}</td>
                </tr>
                <tr>
                    <th>Sex :</th>
                    <td>{{ $patient->sex }}</td>
                </tr>
                <tr>
                    <th>Contact No. :</th>
                    <td>{{ $patient->contact_no }}</td>
                </tr>
                <tr>
                    <th>Date Registered :</th>
                    <td>{{ Carbon::parse($patient->created_at)->toFormattedDateString() }}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>
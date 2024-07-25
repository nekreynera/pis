<table class="table table-bordered" style="border-collapse:collapse; width:100%;height:1200px;" border="1">
    <thead>
        <tr style="background-color: #ccc;width: 400px">
            <th style="padding:5px;width:90px;text-align:center">DATE/TIME</th>
            <th style="padding:5px;width:330px;text-align:center">DOCTOR\'S CONSULTATION</th>
            <th style="padding:5px;width:130px;text-align:center">NURSE\'S NOTES</th>
        </tr>
    </thead>
    <tbody>
        <tr style="width: 300px;">
            <td valign="top" style="width:90px;" id="dateAndTime">{!! $row->date_created !!}</td>
            <td valign="top" style="width:330px;" id="dateAndTime">
                <p>{!! $row->diagnose_description !!}</p>
            </td>
            <td valign="top" style="width:130px;" id="dateAndTime"></td>
        </tr>
    </tbody>
</table>
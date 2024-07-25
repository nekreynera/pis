<table style="width: 265px;padding-bottom: 45px;">
    <tbody>
        @foreach($requisitions as $requisition)
            <tr>
                <td width="150px">{{ $requisition->item_description }}</td>
                <td>QTY: {{ $requisition->qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table style="width: 265px;padding-bottom: 30px;">
    <tbody>
        @foreach($print as $list)
            <tr>
                <td width="130px">{{ $list->item_description.'('.$list->brand.')' }}</td>
                <td width="70px">{{ $list->unitofmeasure }}</td>
                <td width="70px">QTY: {{ $list->qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
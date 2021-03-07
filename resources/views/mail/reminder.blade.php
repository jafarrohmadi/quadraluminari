<h3>Halo, {{ $name }} !</h3>

<p>Berikut reminder hari ini : </p>

<table border="0">
    <tr>
        <th>Company Name</th>
        <th>Product Name</th>
        <th>Act</th>
        <th>Order</th>
        <th>Notes</th>
    </tr>
    @foreach($data as $datas)
        <tr>
            <td>{{ $datas->activeOpportunityData->activeClientData->name }}</td>
            <td>{{ $datas->activeOpportunityData->product_name }}</td>
            <td>
                {{ $datas->act_history_reminder != \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($datas->act_history_reminder) : $datas->act_history_other_name_reminder}}
            </td>
            <td>{{ $datas->act_history_order_reminder }}</td>
            <td>{{ $datas->act_history_notes_reminder }}</td>
        </tr>
    @endforeach
</table>

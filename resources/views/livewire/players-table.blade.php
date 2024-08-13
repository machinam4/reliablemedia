<div>
    {{-- Stop trying to control. --}}
    <table class="table" id="players_table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Names</th>
                <th>Phone</th>
                <th>Amount</th>
                <th>Trans Code</th>
                <th>Radio Name</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
                <tr>
                    <td>{{ $player->TransTime }}</td>
                    <td>{{ $player->FirstName . ' ' . $player->LastName }}</td>
                    <td>{{ $player->MSISDN }}</td>
                    <td>{{ $player->TransAmount }}</td>
                    <td>{{ $player->TransID }}</td>
                    <td>{{ $player->BillRefNumber }}</td>
                    {{-- <td>
                    <span class="badge bg-success">Active</span>
                </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

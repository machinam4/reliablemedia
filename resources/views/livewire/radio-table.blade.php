<div>
    <div>
        {{-- The Master doesn't talk, he acts. --}}
        <table class="table" id="players_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Paybill No.</th>
                    <th>Account No/Name</th>
                    <th>Created By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($radios as $radio)
                    <tr>
                        <td>{{ $radio->name }}</td>
                        <td>{{ $radio->store }}</td>
                        <td>{{ $radio->shortcode }}</td>
                        <td>{{ $radio->created_by }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

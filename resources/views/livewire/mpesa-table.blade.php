<div>
    {{-- The Master doesn't talk, he acts. --}}
    <table class="table" id="players_table">
        <thead>
            <tr>
                <th>MPESA Short Code</th>
                <th>Organization Name</th>
                <th>M-PESA Username</th>
                <th>Date Added</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($codes as $code)
                <tr>
                    <td>{{ $code->shortcode }}</td>
                    <td>{{ $code->name }}</td>
                    <td>{{ $code->username }}</td>
                    <td>{{ $code->created_at }}</td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="registerurl({{ $code->id }})">
                            <span class="badge bg-success">Register Url</span></button>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

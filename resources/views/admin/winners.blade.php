@extends('layouts.base')
@section('page_name', 'Players')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }
    </style>
@endsection
@section('contents')
    <div class="page-heading">
        <h3>PLAYERS STATISTICS</h3>
    </div>
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Players</h6>
                                    <h6 class="font-extrabold mb-0" id="totalPlayers">{{ $players->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Amount</h6>
                                    <h6 class="font-extrabold mb-0" id="totalAmount">
                                        {{ $players->sum('total_trans_amount') }}</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                {{-- live wire table --}}
                {{-- @livewire('players-table') --}}
                <table class="table" id="winners_table">
                    <thead>
                        <tr>
                            <th>Names</th>
                            <th>Phone</th>
                            <th>Total Transactions</th>
                            <th>Total Amount</th>
                            <th>Average</th>
                            <th>Min Trans Amount</th>
                            <th>Max Trans Amount</th>
                            <th>First Transaction</th>
                            <th>Last Transaction</th>
                            {{-- <th>Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $player->FirstName }}</td>
                                <td>{{ $player->MSISDN }}</td>
                                <td>{{ $player->transactions_count }}</td>
                                <td>{{ $player->total_trans_amount }}</td>
                                <td>{{ number_format($player->average_trans_amount, 2) }}</td>
                                <td>{{ $player->min_trans_amount }}</td>
                                <td>{{ $player->max_trans_amount }}</td>

                                <td>{{ Carbon\Carbon::parse($player->first_transaction)->format('H:i:s') }}</td>
                                <td>{{ Carbon\Carbon::parse($player->last_transaction)->format('H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
@endsection

@section('pageJs')
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#winners_table").DataTable({
            "order": [
                [3, "desc"]
            ],
            "pageLength": 100,
        })
    </script>
    <script>
        // Add event listener to "From Date" input
        document.getElementById('radio-vertical').addEventListener('change', function() {
            // Get the selected "From Date" value
            var fromDateValue = this.value;

            // Set the "To Date" input's min attribute to the selected "From Date" value
            document.getElementById('paybill-vertical').min = fromDateValue;
        });
    </script>
@endsection

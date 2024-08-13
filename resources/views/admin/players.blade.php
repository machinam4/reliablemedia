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
        <h3>PLAYERS</h3>
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
                                    <h6 class="font-extrabold mb-0" id="totalPlayers">{{ $totalplayers }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @isset($totalAmount)
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
                                            {{ $totalAmount }}</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon green">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">New Players</h6>
                                <h6 class="font-extrabold mb-0">80.000</h6>
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
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Total sent SMS</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
                </div>
            </div>
        </section>

        <button type="button" class="btn btn-outline-primary block mb-5" data-bs-toggle="modal" data-bs-target="#addCodeModal">
            FILTER RECORDS
        </button>
        <!-- Vertically Centered modal Modal -->
        <div class="modal fade" id="addCodeModal" tabindex="-1" role="dialog" aria-labelledby="addCodeModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCodeModalTitle">SELECT DATES
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ Route('filter') }}" method="post" id="radioForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer')
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="radio-vertical">Radio</label>
                                            <select class="form-select" id="basicSelect" name="radio">
                                                @foreach ($radios as $radio)
                                                    <option value="{{ $radio->name }}">{{ $radio->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="radio-vertical">From Date*</label>
                                        <input type="datetime-local" id="radio-vertical" class="form-control" name="from_date"
                                            placeholder="From Date*" max="{{ now()->format('Y-m-d\TH:i:s') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="paybill-vertical">To Date*</label>
                                        <input type="datetime-local" id="paybill-vertical" class="form-control" name="to_date"
                                            placeholder="To Date*" min="{{ now()->format('Y-m-d\TH:i:s') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Cancel</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Filter</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    {{-- live wire table --}}
                    {{-- @livewire('players-table') --}}
                    <table class="table" id="players_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Time</th>
                                <th>Names</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Trans Code</th>
                                <th>Account Name</th>
                                <th>Shortcode</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $player)
                                <tr>
                                    <td>{{ $player->id }}</td>
                                    <td>{{ $player->TransTime }}</td>
                                    <td>{{ $player->FirstName }}</td>
                                    <td>{{ $player->MSISDN }}</td>
                                    <td>{{ $player->TransAmount }}</td>
                                    <td>{{ $player->TransID }}</td>
                                    <td>{{ $player->BillRefNumber }}</td>
                                    <td>{{ $player->BusinessShortCode }}</td>
                                    {{-- <td>
                                    <span class="badge bg-success">Active</span>
                                </td> --}}
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
        let jquery_datatable = $("#players_table").DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "columnDefs": [{
                "targets": 0, // Targeting the first column (ID column)
                "visible": false, // Making the ID column invisible
                "searchable": false // Making the ID column unsearchable
            }]
        })
        var intervalId = window.setInterval(function() {
            /// call your function here
            // Livewire.emit('getPlayers')
            // console.log(123)
            // Retrieve the last row's data
            var lastRowData = jquery_datatable.row(':first').data();
            var lastDataId = lastRowData ? lastRowData[0] : '';
            // console.log(lastDataId);
            $.get('online/' + lastDataId, function(data) {
                    $("#totalAmount").html(data.totalAmount)
                    $("#totalPlayers").html(data.totalplayers)
                    console.log(data);
                    data.new_players.forEach(player => {
                        jquery_datatable.row.add([
                            player.id,
                            player.TransTime,
                            player.FirstName,
                            player.MSISDN,
                            player.TransAmount,
                            player.TransID,
                            player.BillRefNumber,
                            player.BusinessShortCode,
                            // data
                        ]).draw().order([0, 'desc']).draw();
                    });

                })
                .catch(error => console.error('Error fetching data:', error));
        }, 10000);
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

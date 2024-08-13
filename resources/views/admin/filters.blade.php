@extends('layouts.base')
@section('page_name', 'Dashboard')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
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
        <h3>{{ $radio }} Records</h3>
        <a href="{{ Route('players') }}" class="btn btn-primary block mb-5">
            BACK
        </a>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">

                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        {{-- <h6 class="text-muted font-semibold">Duration</h6> --}}
                                        <h6 class="">{{ 'From ' . $fromDate }}</h6>
                                        <h6 class="">{{ 'To ' . $toDate }}</h6>
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
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Amount</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalAmount }}</h6>
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
                                        <h6 class="text-muted font-semibold">Total Players</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalPlayers }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page-heading">
        <h3>FILTERED RECORDS</h3>
    </div>
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            {{-- <div class="card-header">
                Players
            </div> --}}
            <div class="card-body">
                <table class="table" id="players_table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Names</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Trans Code</th>
                            <th>Mpesa Bill No</th>
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
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#players_table").DataTable({
            "order": [
                [0, "desc"]
            ]
        })
    </script>
@endsection

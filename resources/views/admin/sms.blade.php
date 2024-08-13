@extends('layouts.base')
@section('page_name', 'SMS')
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
        <h3>SMS Stats</h3>
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
                                    <h6 class="text-muted font-semibold">SMS Name</h6>
                                    <h6 class="font-extrabold mb-0" id="show_sms_name">show</h6>
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
                                    <h6 class="text-muted font-semibold">SMS Credit</h6>
                                    <h6 class="font-extrabold mb-0" id="show_sms_balance">0.00</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table" id="players_table">
                    <thead>
                        <tr>
                            <th>Mobile Number</th>
                            <th>Date Sent</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($smss == '')
                            <tr>
                                <td>No sms for the last 30 days</td>
                            </tr>
                        @else
                            @foreach ($smss as $sms)
                                <tr>
                                    <td>{{ $sms->MobileNumber }}</td>
                                    <td>{{ $sms->DoneDate }}</td>
                                    <td>{{ $sms->Message }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $sms->Status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
    {{-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> --}}
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#players_table").DataTable();
    </script>
    <script>
        console.log(123);
        $(document).ready(function() {

            console.log(123);
            var settings = {
                "url": "/api/sms/sms_stats",
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function(response) {
                results = JSON.parse(response)
                credit = JSON.parse(results.credit)
                sender = JSON.parse(results.sender)
                $('#show_sms_balance').text(credit.Data[0].Credits)
                $('#show_sms_name').text(sender.Data[0].SenderId)
                // console.log(sender.Data[0]);
            });
        })
    </script>
@endsection

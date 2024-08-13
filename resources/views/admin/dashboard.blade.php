@extends('layouts.base')
@section('page_name', 'Dashboard')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
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

        <h6>{{ Auth::user()->name }}</h6>
        @isset($radio_select)
            <h3>{{ $radio_select }} Statistics</h3>
        @endisset
    </div>
    <div class="page-content">
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
                                        <h6 class="text-muted font-semibold">Total Today</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalToday }}</h6>
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
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Days</h6>
                                        <h6 class="font-extrabold mb-0">{{ count($players) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer')
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="iconly-boldAdd-User"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Total Overall</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalAmount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                    {{-- <div class="col-6 col-lg-3 col-md-6">
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
                                        <h6 class="font-extrabold mb-0">1102</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Developer')
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card p-3">
                                <h6>Select Radio</h6>
                                <div class="form-group">
                                    <select class="choices form-select" id="radioSelect">
                                        <option value="all">All </option>
                                        @foreach ($radios as $radio)
                                            @if (isset($radio_select))
                                                <option value="{{ $radio->name }}"
                                                    {{ $radio->name == $radio_select ? 'selected' : '' }}>
                                                    {{ $radio->name }}
                                                </option>
                                            @else
                                                <option value="{{ $radio->name }}">{{ $radio->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    </div>
    <div class="page-heading">
        <h3>Daily Totals</h3>
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
                            <th>Date</th>
                            <th>Amount</th>
                            {{-- <th>Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $player->TransTime }}</td>
                                <td>{{ $player->TransAmount }}</td>
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
    <script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
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
        $('#radioSelect').on('change', function() {
            if (this.value == 'all') {
                window.location.assign('/');
            } else {
                window.location.assign('/radios/' + this.value);
            }
        });
    </script>
@endsection

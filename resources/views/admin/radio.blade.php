@extends('layouts.base')
@section('page_name', 'RADIO')
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
        <h3>RADIO STATIONS</h3>
    </div>
    <button type="button" class="btn btn-outline-primary block mb-5" data-bs-toggle="modal" data-bs-target="#addCodeModal">
        ADD RADIO STATIONS
    </button>
    <!-- Vertically Centered modal Modal -->
    <div class="modal fade" id="addCodeModal" tabindex="-1" role="dialog" aria-labelledby="addCodeModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCodeModalTitle">NEW RADIO STATION
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ Route('addRadio') }}" method="post" id="radioForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="radio-vertical">Radio Station*</label>
                                    <input type="text" id="radio-vertical" class="form-control" name="name"
                                        placeholder="Radio Station*" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="payblii-vertical">Mpesa Paybill No*</label>
                                    <input type="text" id="payblii-vertical" class="form-control" name="paybill"
                                        placeholder="Mpesa Paybill No*" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="store-vertical">Radio Account No/Name.*</label>
                                    <input type="text" id="store-vertical" class="form-control" name="account_no"
                                        placeholder="Radio Account No/Name.*" style="text-transform:uppercase" required>
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
                            <span class="d-none d-sm-block">Save</span>
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
                {{-- <livewire:pesaTable /> --}}
                @livewire('radio-table', ['radios' => $radios])
                {{-- @livewire('mpesaTable', ['mpesas' => $mpesas]) --}}
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
        $("#radioForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#addCodeModal').modal('toggle');
            // $('.modal-backdrop').remove();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    console.log(data.message)
                    Swal.fire({
                        icon: data['type'],
                        title: data['message']
                    })
                    Livewire.emit('radioAdded')
                }
            });
        });
    </script>
@endsection

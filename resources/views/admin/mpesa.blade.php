@extends('layouts.base')
@section('page_name', 'MPESA')
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
        <h3>MPESA CODES</h3>
    </div>
    <button type="button" class="btn btn-outline-primary block mb-5" data-bs-toggle="modal" data-bs-target="#addCodeModal">
        ADD MPESA CODES
    </button>
    <!-- Vertically Centered modal Modal -->
    <div class="modal fade" id="addCodeModal" tabindex="-1" role="dialog" aria-labelledby="addCodeModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCodeModalTitle">New MPESA Payment Code
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ Route('addCode') }}" method="post" id="codeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="code-vertical">MPESA Short Code*</label>
                                    <input type="number" id="code-vertical" class="form-control" name="shortcode"
                                        placeholder="MPESA Short Code*">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name-vertical">Organization Name*</label>
                                    <input type="text" id="name-vertical" class="form-control" name="name"
                                        placeholder="Organization Name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="username-vertical">M-PESA Username*</label>
                                    <input type="text" id="username-vertical" class="form-control" name="username"
                                        placeholder="M-PESA Username">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="key-vertical">Consumer Key*</label>
                                    <input type="password" id="key-vertical" class="form-control" name="key"
                                        placeholder="Consumer Key">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="secret-vertical">Consumer Secret*</label>
                                    <input type="password" id="secret-vertical" class="form-control" name="secret"
                                        placeholder="Consumer Secret">
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
                {{-- live wire table --}}
                @livewire('mpesa-table')
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
        $("#codeForm").submit(function(e) {
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
                    Livewire.emit('codeAdded')
                }
            });
        });

        function registerurl(id) {
            $.get('/registerurl/' + id, function(data) {
                console.log(data)
                Swal.fire({
                    icon: data['type'],
                    title: data.errorMessage
                })
                Livewire.emit('codeAdded')
            })
        }
        // $("#register_button").click(function(e) {
        //     e.preventDefault(); // avoid to execute the actual submit of the form.
        //     var link = $(this);
        //     var url = link.attr('href');
        //     console.log(url)
        //     $.get(url, function(data) {
        //         console.log(data.errorMessage)
        //         Swal.fire({
        //             icon: data['type'],
        //             title: data.errorMessage
        //         })
        //         Livewire.emit('codeAdded')
        //     })
        // });
    </script>
@endsection

@extends('layouts.app')
@section('style')
@endsection

@section('title')
    Ripoti
@endsection

@section('breadcrumb')
    <h2><i class="fa fa-th-large pr-2 text-info"></i>Ripoti</h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3 class="text-uppercase"><i class="fa fa-list pr-2 text-info"></i>
                        Partners Transaction
                    </h3>
                    <div class="ibox-tools">


                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            href="{{ route('ripoti_partnership.download') }}"
                            onclick="event.preventDefault(); document.getElementById('download-form').submit();">
                            <i class="fa fa-file-import"></i> Export Data
                        </button>

                        <form id="download-form" action="{{ route('ripoti_partnership.download') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>

                    </div>
                </div>
                <div class="ibox-content">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {!! session('error') !!}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="ripotiTable">
                            <thead>
                                <tr>
                                    <th width="2%">S/N</th>
                                    <th>Institutionf</th>
                                    <th>Transaction Ref</th>
                                    <th>Account</th>
                                    <th>Amout</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="processModal" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="ibox d-none ibox-loading">
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                            <div class="sk-rect6"></div>
                        </div>
                        <div style="height: 100px !important;"></div>
                    </div>
                </div>
                <div class="modal-content-div"></div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#ripotiTable').dataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 10,
                ajax: "{{ route('ripoti_partnership.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'institution',
                        name: 'institution'
                    },
                    {
                        data: 'transaction_ref',
                        name: 'transaction_ref'
                    },
                    {
                        data: 'account',
                        name: 'account'
                    }, {
                        data: 'amount',
                        name: 'amount'
                    },

                ]
            });
        });

        $('#processModal').on('show.bs.modal', function(event) {
            let modal = $(this).appendTo('body');
            let button = $(event.relatedTarget)
            let id = button.data('id')
            let action = button.data('action')
            let url = "{{ route('ripoti_partnership.show', ':action') }}";
            url = url.replace(':action', action)
            let loading = $('.ibox-loading');
            modal.find('.modal-content-div').html('');
            loading.removeClass('d-none').addClass('d-block');
            loading.children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    id: id
                },
                cache: false,
                success: function(data) {
                    modal.find('.modal-content-div').html(data)
                    loading.children('.ibox-content').toggleClass('sk-loading');
                    loading.addClass('d-none').removeClass('d-block');
                },
                error: function(error) {
                    $('#processModal').modal('toggle');
                }
            });
        })
    </script>

    <script type="text/javascript">
        function savingData(e, modalName, tableName, errorDiv) {
            let button = $(e);
            button.prop('disabled', true);

            let url = $(e).data("url");
            let action = $(e).data("action");
            let formElement = $(e).closest("form");
            const csrftoken = $('meta[name="csrf-token"]').attr("content");

            let method = "POST";
            $.ajax({
                url: url,
                type: method,
                headers: {
                    "X-CSRF-TOKEN": csrftoken,
                },
                dataType: "json",
                contentType: "application/json",
                beforeSend: function() {
                    button.text('Syncing...');
                },
                success: function(res) {
                    $(modalName).modal("toggle");
                    let oTable = $(tableName).dataTable();
                    oTable.fnDraw(false);
                    Swal.fire({
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1000,
                    });

                },
                error: function(error) {
                    button.prop('disabled', false);
                    button.text('Fetch');
                    ajaxCustomError(error, $(errorDiv));
                }
            });

        }

        function ajaxCustomError(error, errorDiv) {
            if (error.status === 422) {
                let errorsJson = error.responseJSON.errors;
                let errorString = "";

                Object.values(errorsJson).forEach((e) => {
                    errorString += e + "<br>";
                });

                errorDiv.removeClass("d-none").addClass("d-block").html(errorString);
            } else if (error.status === 400) {
                let errorsJson = error.responseJSON.errors;
                let errorString = "";
                Object.values(errorsJson).forEach((e) => {
                    errorString += e + "<br>";
                });

                errorDiv.removeClass("d-none").addClass("d-block").html(errorString);
            } else if (
                error.status === 401 ||
                error.status === 403 ||
                error.status === 423
            ) {
                let errorsJson = error.responseJSON.errors;
                let errorString = "";
                Object.values(errorsJson).forEach((e) => {
                    errorString += e + "<br>";
                });
                errorDiv.removeClass("d-none").addClass("d-block").html(errorString);
            } else {
                let errorString = "Something went wrong!";
                errorDiv.removeClass("d-none").addClass("d-block").html(errorString);
            }
        }
    </script>

    @stack('ripoti_script')
@endsection

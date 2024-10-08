@extends('layout')
@section('title', 'Pegawai')
@section('subtitle', 'Pegawai')
@section('content')
    <div class="modal fade text-left" id="AlterModal" tabindex="-1" role="dialog" aria-labelledby="AlterLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="AlterLabel">Tambah Pegawai</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="AlterForm" class="needs-validation">
                        <input type="hidden" name="id" id="alter-id">@csrf
                        <label for="alter-name">Nama Pegawai</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="alter-name" required />
                            <div class="invalid-feedback" id="alter-error">
                                Masukkan Nama Pegawai
                            </div>
                        </div>
                        <label for="alter-desc">Keterangan</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="desc" id="alter-desc" />
                            <div class="invalid-feedback" id="desc-error"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="spinner-grow text-primary d-none" role="status">
                        <span class="visually-hidden">Menyimpan...</span>
                    </div>
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-inline-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1 data-submit" form="AlterForm">
                        <i class="bi bi-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Jumlah</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2"><span id="total-counter">-</span></h3>
                            </div>
                        </div>
                        <span class="badge bg-primary rounded p-2">
                            <i class="fas fa-file-alt"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
                        title="Klik kolom Nama Alternatif untuk mencari Alternatif duplikat">
                        <div class="content-left">
                            <span>Duplikat</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2"><span id="total-duplicate">-</span></h3>
                            </div>
                        </div>
                        <span class="badge bg-warning rounded p-2">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="card">
        <div class="card-header">Daftar Alternatif</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AlterModal">
                <i class="bi bi-plus-lg"></i> Tambah Alternatif
            </button>
            <table class="table table-hover table-striped" id="table-alter" style="width: 100%">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Alternatif</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        let dt_alternatif = $("#table-alter"),
            errmsg;
        $(document).ready(function() {
            try {
                $.fn.dataTable.ext.errMode = "none";
                dt_alternatif = dt_alternatif.DataTable({
                    stateSave: true,
                    lengthChange: false,
                    searching: false,
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: "{{ route('alternatif.data') }}"
                    },
                    columns: [{
                        data: "id"
                    }, {
                        data: "name"
                    }, {
                        data: "desc"
                    }, {
                        data: "id"
                    }],
                    columnDefs: [{
                            targets: 0,
                            render: function(data) {
                                return 'A' + data;
                            }
                        },
                        {
                            targets: 2,
                            render: function(data) {
                                if (data === null) return "-";
                                return data;
                            }
                        }, { //Aksi
                            orderable: false,
                            targets: -1,
                            render: function(data, type, full) {
                                return ('<div class="btn-group" role="group">' +
                                    `<button class="btn btn-sm btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#AlterModal" title="Edit">` +
                                    '<i class="bi bi-pencil-square"></i>' +
                                    '</button>' +
                                    `<button class="btn btn-sm btn-danger delete-record" data-id="${data}" data-name="${full["name"]}" title="Hapus">` +
                                    '<i class="bi bi-trash3-fill"></i>' +
                                    '</button>' +
                                    "</div>");
                            }
                        }
                    ],
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
                    }
                }).on("dt-error", function(e, settings, techNote, message) {
                    errorDT(message, techNote);
                }).on("preXhr", function() {
                    $.get("{{ route('alternatif.count') }}", function(data) {
                        $("#total-duplicate").text(data.duplicates);
                        $("#total-counter").text(data.total);
                    }).fail(function(xhr, st) {
                        console.warn(xhr.responseJSON.message ?? st);
                        swal.fire({
                            icon: 'error',
                            titleText: 'Gagal memuat jumlah',
                            text: `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
                        });
                    });
                }).on("draw", setTableColor);
            } catch (dterr) {
                initError(dterr.message);
            }
        }).on("click", ".delete-record", function() {
            let alt_id = $(this).data("id"),
                alt_name = $(this).data("name");
            confirm.fire({
                titleText: "Hapus alternatif?",
                text: `Anda akan menghapus alternatif ${alt_name}.\n` +
                    "Jika sudah dilakukan penilaian, penilaian terkait akan dihapus!",
                preConfirm: async () => {
                    try {
                        await $.ajax({
                            type: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            url: "/alternatif/" + alt_id,
                            success: function() {
                                dt_alternatif.draw();
                                return "Dihapus";
                            },
                            error: function(xhr, st) {
                                if (xhr.status === 404) {
                                    dt_alternatif.draw();
                                    errmsg = `Alternatif ${alt_name} tidak ditemukan`;
                                } else {
                                    console.warn(xhr.responseJSON.message ?? st);
                                    errmsg =
                                        `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
                                }
                                return Swal.showValidationMessage("Gagal hapus: " + errmsg);
                            },
                        });
                    } catch (error) {
                        console.error(error);
                    }
                }
            }).then(function(result) {
                if (result.isConfirmed)
                    swal.fire({
                        icon: "success",
                        titleText: "Berhasil dihapus"
                    });
            });
        }).on("click", ".edit-record", function() {
            let alt_id = $(this).data("id");
            $("#AlterLabel").html("Edit Alternatif");
            formloading('#AlterForm :input', true);
            $.get(`/alternatif/${alt_id}/edit`, function(data) {
                $("#alter-id").val(data.id);
                $("#alter-name").val(data.name);
            }).fail(function(xhr, st) {
                if (xhr.status === 404) {
                    $("#AlterModal").modal("hide");
                    dt_alternatif.draw();
                    errmsg = "Alternatif tidak ditemukan";
                } else {
                    console.warn(xhr.responseJSON.message ?? st);
                    errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
                }
                swal.fire({
                    icon: "error",
                    titleText: "Gagal memuat data",
                    text: errmsg
                });
            }).always(function() {
                formloading('#AlterForm :input', false);
            });
        });

        function submitform(event) {
            event.preventDefault();
            $.ajax({
                data: $("#AlterForm").serialize(),
                url: "{{ route('alternatif.store') }}",
                type: "POST",
                beforeSend: function() {
                    $("#AlterForm :input").removeClass("is-invalid");
                    $("#AlterModal :button").prop("disabled", true);
                    formloading('#AlterForm :input', true);
                },
                complete: function() {
                    $("#AlterModal :button").prop("disabled", false);
                    formloading('#AlterForm :input', false);
                },
                success: function(status) {
                    if ($.fn.DataTable.isDataTable("#table-alter")) dt_alternatif.draw();
                    $("#AlterModal").modal("hide");
                    swal.fire({
                        icon: "success",
                        titleText: status.message
                    });
                },
                error: function(xhr, st) {
                    if (xhr.status === 422) {
                        resetvalidation();
                        if (typeof xhr.responseJSON.errors.name !== "undefined") {
                            $("#alter-name").addClass("is-invalid");
                            $("#alter-error").text(xhr.responseJSON.errors.name);
                        }
                        if (typeof xhr.responseJSON.errors.desc !== "undefined") {
                            $("#alter-desc").addClass("is-invalid");
                            $("#desc-error").text(xhr.responseJSON.errors.desc);
                        }
                        errmsg = xhr.responseJSON.message;
                    } else {
                        console.warn(xhr.responseJSON.message ?? st);
                        errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
                    }
                    swal.fire({
                        titleText: "Gagal",
                        text: errmsg,
                        icon: "error"
                    });
                }
            });
        }
        $("#AlterModal").on("hidden.bs.modal", function() {
            resetvalidation();
            $("#AlterLabel").html("Tambah Alternatif");
            $("#AlterForm")[0].reset();
            $("#alter-id").val("");
        });
    </script>
@endsection

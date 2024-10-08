@extends('layout')
@section('title', 'Sub Kriteria')
@section('subtitle', 'Sub Kriteria')
@section('content')
<div class="modal fade text-left" id="SubCritModal" tabindex="-1" role="dialog" aria-labelledby="SubCritLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="SubCritLabel">Tambah Sub Kriteria</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('subkriteria.store') }}" method="post" enctype="multipart/form-data" id="SubCritForm" class="needs-validation">@csrf
					<input type="hidden" name="id" id="subkriteria-id">
					<label for="nama-sub">Nama Sub Kriteria</label>
					<div class="form-group">
						<input type="text" class="form-control" name="name" id="nama-sub" required />
						<div class="invalid-feedback" id="nama-error">
							Masukkan Nama Sub Kriteria
						</div>
					</div>
					<div class="input-group has-validation mb-3">
						<label class="input-group-text" for="kriteria-select">Kriteria</label>
						<select class="form-select" id="kriteria-select" name="kriteria_id" required>
							<option value="">Pilih</option>
							@foreach ($kriteria as $kr)
							<option value="{{ $kr->id }}" @if($kr->desc) title="{{$kr->desc}}" @endif >
								{{ $kr->name }}
							</option>
							@endforeach
						</select>
						<div class="invalid-feedback" id="kriteria-error">
							Pilih Kriteria
						</div>
					</div>
					<small class="form-text d-none" id="kriteria-alert">
						Mengganti kriteria akan mereset penilaian alternatif terkait.
					</small>
				</form>
			</div>
			<div class="modal-footer">
				<div class="spinner-grow text-primary d-none" role="status">
					<span class="visually-hidden">Menyimpan...</span>
				</div>
				<button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
					<i class="bi bi-x d-block d-sm-none"></i>
					<span class="d-none d-sm-block">Batal</span>
				</button>
				<button type="submit" class="btn btn-primary ml-1 data-submit" form="SubCritForm">
					<i class="bi bi-check d-block d-sm-none"></i>
					<span class="d-none d-sm-block">Simpan</span>
				</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
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
						<i class="bi bi-list-nested"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip" title="Sub Kriteria Terbanyak per Kriteria">
					<div class="content-left">
						<span>Terbanyak</span>
						<div class="d-flex align-items-end mt-2">
							<h3 class="mb-0 me-2"><span id="total-max">-</span></h3>
						</div>
					</div>
					<span class="badge bg-success rounded p-2">
						<i class="bi bi-list-ol"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip" title="Sub Kriteria duplikat per kriteria">
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
	</div>
</div>
<div class="card">
	<div class="card-header">Daftar Sub Kriteria</div>
	<div class="card-body">
		<button type="button" class="btn btn-primary" id="addBtn" data-bs-toggle="modal" data-bs-target="#SubCritModal">
			<i class="bi bi-plus-lg"></i> Tambah Sub Kriteria
		</button>
		<table class="table table-hover table-striped" id="table-subcrit" style="width: 100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama Sub Kriteria</th>
					<th>Kriteria</th>
					<th data-bs-toggle="tooltip" title="Bobot didapat melalui pembobotan Sub Kriteria secara konsisten">
						Bobot
					</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_subkriteria = $('#table-subcrit'), errmsg;
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = 'none';
			dt_subkriteria = dt_subkriteria.DataTable({
				stateSave: true,
				lengthChange: false,
				searching: false,
				serverSide: true,
				processing: true,
				responsive: true,
				ajax: {	url: "{{ route('subkriteria.data') }}"},
				order: [[2, 'asc']],
				columns: [
					{ data: 'id' },
					{ data: 'name' },
					{ data: 'kriteria.name' },
					{ data: 'bobot' },
					{ data: 'id' }
				],
				columnDefs: [{
					targets: 0,
					orderable: false,
					render: function (data, type, full, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				}, {
					targets: 2,
					render: function (data, type, full) {
						return `<span title="${full['desc_kr']}">${data}</span>`;
					}
				}, { //Aksi
					orderable: false,
					targets: -1,
					render: function (data, type, full) {
						return ('<div class="btn-group" role="group">' +
							`<button class="btn btn-sm btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#SubCritModal" title="Edit">` +
							'<i class="bi bi-pencil-square"></i>' +
							'</button>' +
							`<button class="btn btn-sm btn-danger delete-record" data-id="${data}" data-name="${full['name']}" data-kr="${full['kr_name']}" title="Hapus">` +
							'<i class="bi bi-trash3-fill"></i>' +
							'</button>' +
							'</div>');
					}
				}],
				language: {url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"},
				drawCallback: function() {
					let api = this.api(), num_rows = api.page.info().recordsTotal;
					if (num_rows >= 20 * {{ count($kriteria) }}) 
						$('#addBtn').prop('disabled', true);
					else $('#addBtn').prop('disabled', false);
					setTableColor();
				}
			}).on('dt-error', function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('preXhr', function () {
				$.get("{{ route('subkriteria.count') }}", function (data) {
					$('#total-max').text(data.max);
					$("#total-counter").text(data.total);
					$('#total-duplicate').text(data.duplicate);
				}).fail(function (xhr, st) {
					console.warn(xhr.responseJSON.message ?? st);
					swal.fire({
						icon: 'error',
						titleText: 'Gagal memuat jumlah',
						text: `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
					});
				});
			}).on('draw', setTableColor);
		} catch (dterr) {	initError(dterr.message);}
	}).on('click', '.delete-record', function () {
		let sub_id = $(this).data('id'),
			sub_name = $(this).data('name'),
			sub_kr = $(this).data('kr');
		confirm.fire({
			titleText: 'Hapus sub kriteria?',
			text: `Anda akan menghapus sub kriteria ${sub_name} (${sub_kr}).`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: 'DELETE',
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: '/subkriteria/' + sub_id,
						success: function () {
							dt_subkriteria.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 404) {
								dt_subkriteria.draw();
								errmsg = `Sub Kriteria ${sub_name} (${sub_kr}) tidak ditemukan`;
							} else {
								console.warn(xhr.responseJSON.message ?? st);
								errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
							}
							return Swal.showValidationMessage("Gagal hapus: " + errmsg);
						}
					});
				} catch (error) {	console.error(error);	}
			}
		}).then(function (result) {
			if (result.isConfirmed) 
				swal.fire({icon: "success",titleText: "Berhasil dihapus"});
		});
	}).on('click', '.edit-record', function () {
		let sub_id = $(this).data('id');
		$('#SubCritLabel').html('Edit Sub Kriteria');
		$('#kriteria-alert').removeClass('d-none');
		formloading('#SubCritForm :input',true);
		$.get(`/subkriteria/${sub_id}/edit`, function (data) {
			$('#subkriteria-id').val(data.id);
			$('#nama-sub').val(data.name);
			$('#kriteria-select').val(data.kriteria_id);
		}).fail(function (xhr, st) {
			if (xhr.status === 404) {
				$('#SubCritModal').modal('hide');
				dt_subkriteria.draw();
				errmsg = "Sub Kriteria tidak ditemukan";
			} else {
				console.warn(xhr.responseJSON.message ?? st);
				errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
			}
			swal.fire({icon: "error",titleText: "Gagal memuat data",text: errmsg});
		}).always(function () {	formloading('#SubCritForm :input',false);	});
	});
	function submitform(event) {
		event.preventDefault();
		$.ajax({
			data: $('#SubCritForm').serialize(),
			url: "{{ route('subkriteria.store') }}",
			type: 'POST',
			beforeSend: function () {
				$('#SubCritForm :input').removeClass('is-invalid');
				$('#SubCritModal :button').prop('disabled', true);
				formloading('#SubCritForm :input',true);
			},
			complete: function () {
				$('#SubCritModal :button').prop('disabled', false);
				formloading('#SubCritForm :input',false);
			},
			success: function (status) {
				if ($.fn.DataTable.isDataTable("#table-subcrit")) dt_subkriteria.draw();
				$('#SubCritModal').modal('hide');
				swal.fire({icon: "success",	titleText: status.message});
			},
			error: function (xhr, st) {
				if (xhr.status === 422) {
					resetvalidation();
					if (typeof xhr.responseJSON.errors.name !== "undefined") {
						$('#nama-sub').addClass('is-invalid');
						$('#nama-error').text(xhr.responseJSON.errors.name);
					}
					if (typeof xhr.responseJSON.errors.kriteria_id !== "undefined") {
						$('#kriteria-select').addClass('is-invalid');
						$('#kriteria-error').text(xhr.responseJSON.errors.kriteria_id);
					}
					errmsg = xhr.responseJSON.message;
				} else if (xhr.status === 400) errmsg = xhr.responseJSON.message;
				else {
					console.warn(xhr.responseJSON.message ?? st);
					errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
				}
				swal.fire({	titleText: 'Gagal',	text: errmsg,	icon: 'error'});
			}
		});
	};
	$('#SubCritModal').on('hidden.bs.modal', function () {
		resetvalidation();
		$('#SubCritLabel').html('Tambah Sub Kriteria');
		$('#kriteria-alert').addClass('d-none');
		$('#SubCritForm')[0].reset();
		$('#subkriteria-id').val("");
	});
</script>
@endsection
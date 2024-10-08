@extends('layout')
@section('title', 'Perbandingan Sub Kriteria')
@section('subtitle', 'Perbandingan Sub Kriteria')
@section('content')
<div class="card">
	<div class="card-header">Daftar Perbandingan Sub Kriteria</div>
	<div class="card-body">
		<table class="table table-hover table-striped" id="table-subcritcomp" style="width: 100%">
			<thead>
				<tr><th>No</th><th>Kriteria</th><th>Status</th><th>Aksi</th></tr>
			</thead>
		</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	let dt_subkriteriacomp = $('#table-subcritcomp');
	$(document).ready(function () {
		try {
			$.fn.dataTable.ext.errMode = 'none';
			dt_subkriteriacomp = dt_subkriteriacomp.DataTable({
				stateSave: true,
				lengthChange: false,
				searching: false,
				serverSide: true,
				processing: true,
				responsive: true,
				ajax: {	url: "{{ route('bobotsubkriteria.data') }}"	},
				columns: [
					{ data: 'id' },	{ data: 'name' },	{ data: 'result' },	{ data: 'id' }
				],
				columnDefs: [{
					targets: 0,
					orderable: false,
					render: function (data, type, full, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				}, {
					targets: 2,
					render: function (data) {
						if (data) {
							return ('<small>' +
								'<span class="badge bg-success">Perbandingan sudah dilakukan</span>' +
								'</small>');
						}
						return ('<small>' +
							'<span class="badge bg-danger">Perbandingan belum dilakukan atau tidak lengkap</span>' +
							'</small>');
					}
				}, { //Aksi
					orderable: false,
					targets: -1,
					render: function (data, type, full) {
						if (full['result']) {
							return ('<div class="btn-group" role="group">' +
								`<a class="btn btn-sm btn-primary" href="/bobot/sub/${data}" title="Edit">` +
								'<i class="bi bi-pencil-square"></i>' +
								'</a>' +
								`<a class="btn btn-sm btn-success" href="/bobot/sub/${data}/hasil" title="Lihat hasil">` +
								'<i class="bi bi-eye-fill"></i>' +
								'</a>' +
								`<button class="btn btn-sm btn-danger delete-comp" data-id="${data}" data-name="${full['name']}" title="Reset perbandingan">` +
								'<i class="bi bi-arrow-counterclockwise"></i>' +
								'</button>' +
								'</div>');
						}
						return (
							`<a class="btn btn-sm btn-primary" href="/bobot/sub/${data}" title="Input perbandingan">` +
							'<i class="bi bi-plus-lg"></i>' +
							'</a>');
					}
				}],
				language: {url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"}
			}).on('error.dt', function (e, settings, techNote, message) {
				errorDT(message, techNote);
			}).on('draw', setTableColor);
		} catch (dterr) {initError(dterr.message);}
	}).on('click', '.delete-comp', function () {
		let kriteria = $(this).data('name'), id = $(this).data('id');
		confirm.fire({
			titleText: 'Reset perbandingan?',
			text: `Anda akan mereset perbandingan Sub Kriteria ${kriteria}.\n` +
				`Bobot Sub Kriteria ${kriteria} akan direset!`,
			preConfirm: async () => {
				try {
					await $.ajax({
						type: 'DELETE',
						headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
						url: `/bobot/sub/${id}/del`,
						success: function () {
							dt_subkriteriacomp.draw();
							return "Dihapus";
						},
						error: function (xhr, st) {
							if (xhr.status === 404) dt_subkriteriacomp.draw();
							console.warn(xhr.responseJSON.message ?? st);
							return Swal.showValidationMessage(
								`Gagal reset: Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`
							);
						}
					});
				} catch (error) {console.error(error);}
			}
		}).then(function (result) {
			if (result.isConfirmed) 
				swal.fire({icon: "success",titleText: "Berhasil direset"});
		});
	});
</script>
@endsection
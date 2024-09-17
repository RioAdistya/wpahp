@extends('layout')

@section('content')
<div class="card">
	<div class="card-header">Daftar Karyawan</div>
	<div class="card-body">
        <a href="{{ route('employees.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Karyawan</a>
		<table class="table table-hover table-striped" id="table-crit" style="width: 100%">
			<thead>
				<tr>
					<th>Nama</th>
					<th>Email</th>
					<th>Aksi</th>
				</tr>
			</thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-primary edit-record"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-sm btn-danger delete-record" type="submit"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
		</table>
	</div>
</div>
@endsection
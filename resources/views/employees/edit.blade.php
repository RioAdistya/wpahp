<!-- resources/views/employees/edit.blade.php -->
@extends('layout')
@section('title', 'Daftar')
@section('auth-title', 'Daftar')
@section('content')
<h3>Edit Employee</h3>
<form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation">
	@csrf
    @method('PUT')
	<div class="form-group position-relative has-icon-left mb-4">
		<input type="text" name="email" placeholder="Email" class="form-control form-control-xl @error('email') is-invalid @enderror " required value="{{ $employee->email }}"/>
		<div class="form-control-icon"><i class="bi bi-envelope"></i></div>
		<div class="invalid-feedback">
			@error('email') {{ $message }} @else Masukkan Email Anda @enderror
		</div>
	</div>
	<div class="form-group position-relative has-icon-left mb-4">
		<input type="text" name="name" maxlength="99" placeholder="Nama lengkap" maxlength="99" class="form-control form-control-xl @error('name') is-invalid @enderror " pattern="[A-z.,' ]{5,99}" required value="{{ $employee->name }}"/>
		<div class="form-control-icon"><i class="bi bi-person"></i></div>
		<div class="invalid-feedback">
			@error('name') {{ $message }}
			@else Masukkan Nama Anda (Tanpa simbol dan angka)
			@enderror
		</div>
	</div>
	<div class="form-group position-relative has-icon-left mb-4">
		<input type="password" placeholder="Set New Password" name="password" minlength="8" maxlength="20" id="password" class="form-control form-control-xl @error('password') is-invalid @enderror " oninput="checkpassword()" data-bs-toggle="tooltip" data-bs-placement="top" title="8-20 karakter (Saran: terdiri dari huruf besar, huruf kecil, angka, dan simbol)" required/>
		<div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
		<div class="invalid-feedback">
			@error('password') {{ $message }}
			@else Masukkan Password (8-20 karakter)
			@enderror
		</div>
	</div>
	<div class="form-group position-relative has-icon-left mb-4">
		<input type="password" placeholder="Konfirmasi Password" maxlength="20" id="confirm-password" name="password_confirmation" minlength="8" oninput="checkpassword()" class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror " required/>
		<div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
		<div class="invalid-feedback">
			@error('password_confirmation') {{ $message }}
			@else Password Konfirmasi salah
			@enderror
		</div>
	</div>
    <input type="text" name="role" id="role" value="employee" hidden>
	<button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
		Save
	</button>
</form>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/password.js') }}"></script>
@endsection
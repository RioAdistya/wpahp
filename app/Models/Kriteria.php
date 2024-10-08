<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
	use HasFactory;
	protected $table = 'kriteria', $fillable = ['name', 'type', 'desc'];
	public static array $rules = [
		'name' => 'required', 'type' => ['bail', 'required', 'in:cost,benefit']
	], $message = [
		'name.required' => 'Nama kriteria harus diisi',
		'type.required' => 'Tipe Kriteria harus dipilih',
		'type.in' => 'Tipe Kriteria harus berupa Cost atau Benefit sesuai teori SAW'
	], $ratio_index = [
		1 => 0,
		2 => 0,
		3 => 0.58,
		4 => 0.9,
		5 => 1.12,
		6 => 1.24,
		7 => 1.32,
		8 => 1.41,
		9 => 1.45,
		10 => 1.49,
		11 => 1.51,
		12 => 1.48,
		13 => 1.56,
		14 => 1.57,
		15 => 1.59,
		16 => 1.605,
		17 => 1.61,
		18 => 1.615,
		19 => 1.62,
		20 => 1.625
	];
	public function subkriteria()
	{	return $this->hasOne(SubKriteria::class, 'kriteria_id');}
	public function nilai()
	{	return $this->hasOne(Nilai::class, 'kriteria_id');}
	public function kriteriacomp()
	{	return $this->hasMany(KriteriaComp::class);}
}

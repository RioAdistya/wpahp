<?php

namespace App\Http\Controllers;

use App\Models\Alternatif,
	App\Models\Hasil,
	App\Models\Kriteria,
	App\Models\Nilai,
	App\Models\SubKriteria,
	Illuminate\Database\QueryException,
	Illuminate\Http\Request,
	Illuminate\Support\Facades\Log,
	Illuminate\Support\Str,
	Yajra\DataTables\Facades\DataTables;

class NilaiController extends Controller
{
	public function pangkatBobot($arr, $type)
	{
		if ($type === 'cost')	$hasil = ((-1) * $arr);
		else $hasil = ((1) * $arr); //jika atribut benefit atau tidak dikenali
		return round($hasil, 2);
	}
	public function vektorS($arr, $type, $skor)
	{
		if ($type === 'cost')	$hasil = $skor ** ((-1) * $arr);
		else $hasil = $skor ** ((1) * $arr); //jika atribut benefit atau tidak dikenali
		return round($hasil, 2);
	}
	public function multiplyVectorS($arr)
	{
		$result = 1;
		foreach ($arr as $num) {
			$result *= $num;
		}
		return round($result, 5);
	}
	public function simpanHasil($alt_id, $jumlah): void
	{
		try {
			Hasil::updateOrCreate(['alternatif_id' => $alt_id], ['skor' => $jumlah]);
		} catch (QueryException $e) {
			Log::error($e);
		}
	}
	public function datatables()
	{
		return DataTables::of(Alternatif::query())
			->addColumn('subkriteria', function (Alternatif $alt) {
				$kriteria = Kriteria::get();
				foreach ($kriteria as $kr)	$subkriteria[Str::slug($kr->name, '_')] = '';
				$nilaialt = Nilai::select(
					'nilai.*',
					'alternatif.name',
					'kriteria.name',
					'subkriteria.name'
				)->leftJoin('alternatif', 'alternatif.id', 'nilai.alternatif_id')
					->leftJoin('kriteria', 'kriteria.id', 'nilai.kriteria_id')
					->leftJoin('subkriteria', 'subkriteria.id', 'nilai.subkriteria_id')
					->where('alternatif_id', $alt->id)->get();
				if (count($nilaialt) > 0) {
					foreach ($nilaialt as $skor) {
						$subkriteria[Str::slug($skor->kriteria->name, '_')] =
							$skor->subkriteria->name;
					}
					return $subkriteria;
				}
			})->make();
	}
	public function getCount()
	{
		$alternatives = Alternatif::count();
		$dinilai = Nilai::join('alternatif', 'nilai.alternatif_id', 'alternatif.id')
			->select('nilai.alternatif_id as idalt', 'alternatif.name')
			->groupBy('idalt', 'name')->get()->count();
		return response()->json([
			'unused' => $alternatives - $dinilai,	'alternatif' => $alternatives
		]);
	}
	public function index()
	{
		$kriteria = Kriteria::get();
		if ($kriteria->isEmpty()) {
			return to_route('kriteria.index')->withWarning(
				'Tambahkan kriteria dan sub kriteria dulu sebelum melakukan penilaian.'
			);
		}
		$subkriteria = SubKriteria::get();
		if ($subkriteria->isEmpty()) {
			return to_route('subkriteria.index')
				->withWarning('Tambahkan sub kriteria dulu sebelum melakukan penilaian.');
		}
		$alternatif = Alternatif::get();
		if ($alternatif->isEmpty()) {
			return to_route('alternatif.index')
				->withWarning('Tambahkan alternatif dulu sebelum melakukan penilaian.');
		}
		$data = [
			'kriteria' => $kriteria,
			'subkriteria' => $subkriteria,
			'alternatif' => $alternatif
		];
		return view('main.alternatif.nilai', compact('data'));
	}
	public function store(Request $request)
	{
		$request->validate(Nilai::$rules, Nilai::$message);
		$scores = $request->all();
		try {
			for ($a = 0; $a < count($scores['kriteria_id']); $a++) {
				Nilai::updateOrCreate([
					'alternatif_id' => $scores['alternatif_id'],
					'kriteria_id' => $scores['kriteria_id'][$a]
				], ['subkriteria_id' => $scores['subkriteria_id'][$a]]);
			}
			return response()->json(['message' => 'Berhasil dinilai']);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	public function lihat()
	{
		try {
			$alt = Alternatif::get();
			$kr = Kriteria::get();
			$skr = SubKriteria::get();
			$hasil = Nilai::leftJoin(
				'alternatif',
				'alternatif.id',
				'nilai.alternatif_id'
			)->leftJoin('kriteria', 'kriteria.id', 'nilai.kriteria_id')
				->leftJoin('subkriteria', 'subkriteria.id', 'nilai.subkriteria_id')
				->get();
			$cekbobotkr = Kriteria::where('bobot', 0.00000)->count();
			$cekbobotskr = SubKriteria::where('bobot', 0.00000)->count();
			if ($cekbobotkr > 0) {
				return to_route('bobotkriteria.index')->withWarning(
					'Lakukan perbandingan kriteria dulu sebelum melihat hasil penilaian. ' .
						'Jika sudah dilakukan, pastikan hasil perbandingannya konsisten.'
				);
			}
			if ($cekbobotskr > 0) {
				return to_route('bobotsubkriteria.pick')->withWarning(
					'Satu atau lebih perbandingan sub kriteria belum dilakukan. ' .
						'Jika sudah dilakukan, pastikan semua hasil perbandingannya konsisten.'
				);
			}
			if ($hasil->isEmpty()) {
				return to_route('nilai.index')
					->withWarning('Masukkan data penilaian alternatif dulu');
			}
			$data = ['alternatif' => $alt, 'kriteria' => $kr, 'subkriteria' => $skr];
			return view('main.alternatif.hasil', compact('hasil', 'data'));
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal memuat hasil penilaian:')
				->withErrors("Kesalahan SQLState #{$e->errorInfo[1]}")
				->withErrors($e->errorInfo[2]);
		}
	}
	public function edit($nilai)
	{
		try {
			$scr = Nilai::where('alternatif_id', $nilai)->get();
			if ($scr->isEmpty()) {
				return response()->json([
					'message' => 'Nilai Alternatif tidak ditemukan atau belum diisi'
				], 404);
			}
			$data['alternatif_id'] = $nilai;
			foreach ($scr as $skor) {
				$data['subkriteria'][Str::slug($skor->kriteria->name, '_')] =
					$skor->subkriteria_id;
			}
			return response()->json($data);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(["message" => $e->errorInfo[2]], 500);
		}
	}
	public function destroy($nilai)
	{
		try {
			$cek = Nilai::where('alternatif_id', $nilai);
			if (!$cek->exists()) {
				return response()->json([
					'message' => 'Nilai Alternatif tidak ditemukan'
				], 404);
			}
			if (Nilai::where('alternatif_id', '<>', $nilai)->count() === 0)
				Nilai::truncate();
			else $cek->delete();
			if (Hasil::where('alternatif_id', '<>', $nilai)->count() === 0)
				Hasil::truncate();
			else Hasil::where('alternatif_id', $nilai)->delete();
			return response()->json(['message' => 'Dihapus']);
		} catch (QueryException $err) {
			Log::error($err);
			return response()->json(['message' => $err->errorInfo[2]], 500);
		}
	}
	public function hasil()
	{
		try {
			$result = Hasil::get();
			if ($result->isEmpty())
				return response()->json(['message' => 'Ranking penilaian kosong'], 400);
			foreach ($result as $index => $hasil) {
				$data['alternatif'][$index] = $hasil->alternatif_id;
				$data['skor'][$index] = $hasil->skor;
			}
			$highest = Hasil::orderBy('skor', 'desc')->first();
			return response()->json([
				'result' => $data,
				'score' => $highest->skor,
				'nama' => $highest->alternatif->name,
				'alt_id' => $highest->alternatif_id
			]);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(["message" => $e->errorInfo[2]], 500);
		}
	}
}

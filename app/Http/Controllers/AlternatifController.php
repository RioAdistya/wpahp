<?php

namespace App\Http\Controllers;

use App\Models\Alternatif,
	Illuminate\Database\QueryException,
	Illuminate\Http\Request,
	Illuminate\Support\Facades\Log,
	Yajra\DataTables\Facades\DataTables;

class AlternatifController extends Controller
{
	public function getCount()
	{
		$alternatives = Alternatif::get();
		$altUnique = $alternatives->unique(['name']);
		return response()->json([
			'total' => $alternatives->count(),
			'duplicates' => $alternatives->diff($altUnique)->count()
		]);
	}
	public function index(){return view('main.alternatif.index');}
	public function datatables(){	return DataTables::of(Alternatif::query())->make();	}
	public function store(Request $request)
	{
		$request->validate(Alternatif::$rules, Alternatif::$message);
		try {
			if ($request->id) {
				Alternatif::updateOrCreate(['id' => $request->id], [
					'name' => $request->name, 'desc' => $request->desc
				]);
				$msg = 'Berhasil diupdate';
			} else {
				Alternatif::create($request->all());
				$msg = 'Berhasil diinput';
			}
			return response()->json(['message' => $msg]);
		} catch (QueryException $e) {
			Log::error($e);
			return response()->json(['message' => $e->errorInfo[2]], 500);
		}
	}
	public function edit(Alternatif $alternatif)
	{	return response()->json($alternatif);	}
	public function destroy(Alternatif $alternatif)
	{
		$alternatif->delete();
		$model = new Alternatif;
		HomeController::refreshDB($model);
		return response()->json(['message' => 'Dihapus']);
	}
}

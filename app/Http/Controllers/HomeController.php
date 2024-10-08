<?php

namespace App\Http\Controllers;

use App\Models\Alternatif,
	App\Models\Kriteria,
	App\Models\SubKriteria,
	App\Models\User,
	Illuminate\Database\Eloquent\ModelNotFoundException,
	Illuminate\Database\QueryException,
	Illuminate\Http\Request,
	Illuminate\Support\Facades\Auth,
	Illuminate\Support\Facades\DB,
	Illuminate\Support\Facades\Hash,
	Illuminate\Support\Facades\Log,
	Illuminate\Support\Facades\Session,
	Illuminate\Support\Str;

class HomeController extends Controller
{
	public static function refreshDB($model): void
	{ //Atur ulang id kriteria, sub kriteria, dan alternatif
		try {
			$max = $model->max('id') + 1;
			DB::statement("ALTER TABLE users AUTO_INCREMENT = $max");
		} catch (QueryException $e) {	Log::error($e);	}
	}
	public function index()
	{
		$jml = [];
		if (Auth::check()) {
			try {
				$jml = [
					'kriteria' => Kriteria::count(),
					'subkriteria' => SubKriteria::count(),
					'alternatif' => Alternatif::count()
				];
			} catch (QueryException $e) {
				Log::error($e);
				$jml['error'] = "Kesalahan SQLState #{$e->errorInfo[1]}/{$e->errorInfo[0]}. {$e->errorInfo[2]}";
			}
		}
		return view('main.index', compact('jml'));
	}
	public function profile()	{	return view('main.profil');}
	public function updateProfil(Request $request)
	{
		try {
			$req = $request->validate(User::$updrules, User::$message);
			$req['name'] = Str::title($req['name']);
			$req['email'] = Str::lower($req['email']);
			if (empty($req['password'])) {
				unset($req['password']);
				unset($req['password_confirmation']);
			} else $req['password'] = Hash::make($req['password']);
			User::findOrFail(Auth::id())->update($req);
			return response()->json(['message' => 'Akun sudah diupdate']);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Akun tidak ditemukan'], 404);
		} catch (QueryException $db) {
			if ($db->errorInfo[1] === 1062) {
				return response()->json([
					'message' => "Email \"$request->email\" sudah digunakan",
					'errors' => ['email' => 'Email sudah digunakan']
				], 422);
			}
			Log::error($db);
			return response()->json(['message' => $db->errorInfo[2]], 500);
		}
	}
	public function delAkun(Request $request)
	{
		try {
			$request->validate(User::$delakunrule);
			User::findOrFail(Auth::id())->delete();
			Auth::logout();
			Session::invalidate();
			Session::regenerateToken();
			return response()->json(['message' => 'Akun sudah dihapus']);
		} catch (ModelNotFoundException) {
			return response()->json(['message' => 'Akun tidak ditemukan'], 404);
		} catch (QueryException $db) {
			Log::error($db);
			return response()->json(['message' => $db->errorInfo[2]], 500);
		}
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kriteria_banding', function (Blueprint $table) {
			$table->id();
			$table->foreignId('kriteria1')->constrained('kriteria')->cascadeOnDelete();
			$table->foreignId('kriteria2')->constrained('kriteria')->cascadeOnDelete();
			$table->integer('nilai')->default(1);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('kriteria_banding');
	}
};

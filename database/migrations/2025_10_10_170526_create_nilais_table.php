<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('siswa_id');
            $table->string('kelas', 50);
            $table->string('mapel', 100);
            $table->integer('nilai')->unsigned();
            $table->timestamps();
        
            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
                ->onDelete('cascade');
        
            $table->index('siswa_id');
            $table->index('mapel');
        });
        DB::statement('ALTER TABLE nilai ADD CONSTRAINT check_nilai_range CHECK (nilai >= 0 AND nilai <= 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};

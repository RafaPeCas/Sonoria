<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->boolean('explicit')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('hidden')->default(false);
            $table->string('name', 255);
            $table->integer('reproductions')->default(0);
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE songs ADD file LONGBLOB");
        DB::statement("ALTER TABLE songs ADD image LONGBLOB");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};

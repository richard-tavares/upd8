<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('representatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf', 14)->unique();
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F']);
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('representatives', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });

        Schema::dropIfExists('representatives');
    }
};

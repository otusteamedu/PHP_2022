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
        Schema::table('reports', function (Blueprint $table) {
            $table->text('compiled_data')->nullable(true)->default(null);
        });

        Schema::dropColumns('reports', ['name']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('reports', ['compiled_data']);

        Schema::table('reports', function (Blueprint $table) {
            $table->string('name');
        });
    }
};

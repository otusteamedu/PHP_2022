<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('params');
            $table->string('status', 23);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('reports');
    }
};

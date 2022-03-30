<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $value = [
            'id' => 1,
            'title' => 'mega video chanel',
            'description' => 'lol , kek',
            'is_active' => true,
            'created_at' => '2022-03-30 23:54:36',
            'updated_at' => '2022-03-30 23:54:36',
        ];

        DB::table('video_chanels')->insert($value);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAVLDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_v_l_data', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->unsignedTinyInteger('priority');
            $table->json('gps_data');
            $table->json('io_data');
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
        Schema::dropIfExists('a_v_l_data');
    }
}

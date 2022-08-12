<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eqp_id')->constrained('equipment')->default("");
            $table->foreignId('cat_id')->constrained('categories')->default("");
            $table->string('clas_name');
            $table->longText('desc');
            $table->string('workout_level');
            $table->string('trainer_name');
            $table->string('clas_img');
            $table->string('video_thumb_img');
            $table->string('clas_qr_img');
            $table->string('clas_video_path');
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
        Schema::dropIfExists('clas');
    }
}

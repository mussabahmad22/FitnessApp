<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddMultipleEqpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_multiple_eqps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('clas')->nullable();
            $table->foreignId('eqp_id')->constrained('equipment')->nullable();
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
        Schema::dropIfExists('add_multiple_eqps');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('permutations', function (Blueprint $table) {
            $table->id();
            $table->string('stone', 100);
            $table->string('shape', 100);
            $table->string('size', 100);
            $table->string('color', 100);
            $table->string('quality', 100);
            $table->string('cut', 100);
            $table->string('polish', 100);
            $table->string('radiation', 100);
            $table->string('lab', 100);
            $table->integer('avg_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        Schema::dropIfExists('permutations');
    }
}

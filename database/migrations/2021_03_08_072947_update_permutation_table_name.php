<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdatePermutationTableName extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::rename('permutations', 'stone_permutations');
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down()
    {
        Schema::dropIfExists('stone_permutations');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StonePermutation extends Model
{
    /**
     * table
     *
     * @var string
     */
    protected $table = 'stone_permutations';
    /**
     * gaurded
     *
     * @var array
     */
    protected $guarded = ['id'];
}

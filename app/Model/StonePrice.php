<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StonePrice extends Model
{
    /**
     * table
     *
     * @var string
     */
    protected $table = 'stone_price_master';
    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'stone_id';
    /**
     * gaurded
     *
     * @var array
     */
    protected $gaurded = ['stone_id'];
}

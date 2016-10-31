<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Configuration extends Model
{
    protected $table = 'configurations';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

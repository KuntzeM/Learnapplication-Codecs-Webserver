<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{


    protected $table = 'log';
    protected $primaryKey = 'id';


    static public function getErrors()
    {
        return Log::where('level', 'error')->get();
    }

    static public function getWarnings()
    {
        return Log::where('level', 'warn')->get();
    }
}

<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Configuration
 * Model für Datenbanktabelle: Configuration
 * @package App
 */
class Configuration extends Model
{
    /**
     * @var string
     */
    protected $table = 'configurations';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $timestamps = false;
}

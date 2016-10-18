<?php
/**
 * Created by PhpStorm.
 * User: Mathias
 * Date: 18.10.2016
 * Time: 17:13
 */

namespace App;

use Illuminate\Support\Facades\Hash;

class ConfigData
{
    private static $instance;

    public $username;
    public $email;
    public $password;
    public $media_server;


    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
    {
        $user = User::find(1)->first();
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = $user->password;
        $user->save();
        $config = Configuration::where('name', 'media_server')->first();

        $this->media_server = $config->value;
    }

    public function update()
    {
        $user = User::find(1)->first();

        $user->username = $this->username;
        $user->email = $this->email;

        if (!empty($this->password)) {

            $user->password = Hash::make($this->password);
        }


        $user->save();

        $config = Configuration::where('name', 'media_server')->first();
        $config->value = $this->media_server;
        $config->save();

    }
}
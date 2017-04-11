<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;

use Illuminate\Support\Facades\Hash;
use LRedis;

/**
 * Class ConfigData
 * singleton Klasse als Wrapper des Models Configuration
 * @package App
 */
class ConfigData
{
    /**
     * @var ConfigData
     */
    private static $instance;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $media_server;
    /**
     * @var string
     */
    public $api_key;
    /**
     * @var int
     */
    public $api_expire;

    /**
     * @return ConfigData
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * ConfigData constructor.
     */
    public function __construct()
    {
        $user = User::find(1)->first();
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = $user->password;
        $user->save();

        $config = Configuration::where('name', 'media_server')->first();
        $this->media_server = $config->value;

        $config = Configuration::where('name', 'api_key')->first();
        $this->api_key = $config->value;

        $config = Configuration::where('name', 'api_expire')->first();
        $this->api_expire = intval($config->value);
    }

    /**
     * speichert Konfigurationen in Datenbank
     */
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

        $config = Configuration::where('name', 'api_key')->first();
        $config->value = $this->api_key;
        $config->save();

        $config = Configuration::where('name', 'api_expire')->first();
        $config->value = intval($this->api_expire);
        $config->save();
    }
}
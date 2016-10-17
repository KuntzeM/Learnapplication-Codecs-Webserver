<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */


namespace App\Libary;

use App\Exceptions\WrongEncoderException;
use Symfony\Component\Process\Process;

/**
 * Class FFMpeg
 * @package App\Libary
 */
class FFMpeg
{

    /**
     * @var string
     */
    private $codec = '';
    /**
     * @var string
     */
    private $parameters = '';
    /**
     * @var string
     */
    private $ffmpeg_path = '';
    /**
     * @var string
     */
    private $log_path = '';

    private $finished = false;
    /**
     * @param $codec string
     * @param $parameters string
     */
    public function __construct($codec, $parameters)
    {
        $system = (DIRECTORY_SEPARATOR == '\\') ? 'windows' : 'unix';


        $this->ffmpeg_path = join(DIRECTORY_SEPARATOR, [app_path(), 'Libary', 'ffmpeg', $system, 'bin', 'ffmpeg']);

        $this->codec = $codec;
        $this->parameters = $parameters;
        $this->log_path = join(DIRECTORY_SEPARATOR, [storage_path(), "logs", "ffmpeg"]);
    }

    /**
     * @return string
     */
    public function run()
    {
        $myfile = fopen(storage_path() . '/'.uniqid('text_', true), "w");

        $random_id = uniqid('process_', true);
        $command = $this->ffmpeg_path . " -i " . storage_path() . "/test.MOV -codec:v libtheora -b:v 1000k " . storage_path() . "/output.avi ";
        #dd($command);
        shell_exec($command);
        fclose($myfile);
        $this->finished = true;
        return $random_id;
    }

    public function isfinished(){
        return $this->finished;
    }


    /**
     * @return array
     */
    public function getPossibleEncoders()
    {
        return array();
    }

    /**
     * @param $codec
     * @return bool
     */
    public function existEncoder($codec)
    {
        return false;
    }

    /**
     * @return string
     */
    public function getCodec()
    {
        return $this->codec;
    }


    /**
     * @param $codec
     * @throws WrongEncoderException
     */
    public function setCodec($codec)
    {
        if (!$this->existEncoder($codec))
            throw new WrongEncoderException("ffmpeg don't support this encoder!");

        $this->codec = $codec;
    }

    /**
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }


}
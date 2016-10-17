<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class FFMpegProcess implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    private $id = 0;
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
        $this->id = uniqid('process_', true);

        $this->ffmpeg_path = join(DIRECTORY_SEPARATOR, [app_path(), 'Libary', 'ffmpeg', $system, 'bin', 'ffmpeg']);

        $this->codec = $codec;
        $this->parameters = $parameters;
        $this->log_path = join(DIRECTORY_SEPARATOR, [storage_path(), "logs", "ffmpeg", $this->id]);
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $command = $this->ffmpeg_path . " -y -i " . storage_path() . "/test.MOV -codec:v libtheora -b:v 1000k " . storage_path() . "/".$this->id.".ogg 2> " . $this->log_path;
        shell_exec($command);

    }
}

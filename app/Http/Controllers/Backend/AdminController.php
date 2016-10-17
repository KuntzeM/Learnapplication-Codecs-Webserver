<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Jobs\FFMpegProcess;
use App\Libary\FFMpeg;
use App\Libary\FFMpegQueue;

use Illuminate\Contracts\Queue\Queue;
use View;

class AdminController extends Controller
{

    public function __construct()
    {
        #$this->middleware('auth');
    }

    public function get_index()
    {

        #$this->dispatch((new FFMpegProcess(uniqid('queue_', true), '1')));
        #$s = '{"job":"Illuminate\\Queue\\CallQueuedHandler@call","data":{"commandName":"App\\Jobs\\FFMpegProcess","command":"O:22:\"App\\Jobs\\FFMpegProcess\":10:{s:26:\"\u0000App\\Jobs\\FFMpegProcess\u0000id\";s:31:\"process_57e37fac692554.07729210\";s:29:\"\u0000App\\Jobs\\FFMpegProcess\u0000codec\";s:29:\"queue_57e37fac6918c3.98142776\";s:34:\"\u0000App\\Jobs\\FFMpegProcess\u0000parameters\";s:1:\"1\";s:35:\"\u0000App\\Jobs\\FFMpegProcess\u0000ffmpeg_path\";s:66:\"C:\\xampp\\htdocs\\medienprojekt\\app\\Libary\\ffmpeg\\windows\\bin\\ffmpeg\";s:32:\"\u0000App\\Jobs\\FFMpegProcess\u0000log_path\";s:81:\"C:\\xampp\\htdocs\\medienprojekt\\storage\\logs\\ffmpeg\\process_57e37fac692554.07729210\";s:32:\"\u0000App\\Jobs\\FFMpegProcess\u0000finished\";b:0;s:6:\"\u0000*\u0000job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:5:\"delay\";N;}"}}'
        #dd(json_decode($s));

        return View::make('backend.index', array('pid' => "1"));
    }


}

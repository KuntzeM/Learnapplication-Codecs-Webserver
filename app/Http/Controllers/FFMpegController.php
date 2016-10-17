<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class FFMpegController extends Controller
{


    public function getProgress(Request $request)
    {

        $log_file = join(DIRECTORY_SEPARATOR, [storage_path(), 'logs', 'ffmpeg', $request->log_file]);


        $content = @file_get_contents($log_file);

        if ($content) {
            //get duration of source
            preg_match("/Duration: (.*?), start:/", $content, $matches);

            $rawDuration = $matches[1];

            //rawDuration is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawDuration));
            $duration = floatval($ar[0]);
            if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
            if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

            //get the time in the file that is already encoded
            preg_match_all("/time=(.*?) bitrate/", $content, $matches);

            $rawTime = array_pop($matches);

            //this is needed if there is more than one match
            if (is_array($rawTime)) {
                $rawTime = array_pop($rawTime);
            }

            //rawTime is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawTime));
            $time = floatval($ar[0]);
            if (!empty($ar[1])) $time += intval($ar[1]) * 60;
            if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

            //calculate the progress
            $progress = round(($time / $duration) * 100);

            echo "Duration: " . $duration . "<br>";
            echo "Current Time: " . $time . "<br>";
            echo "Progress: " . $progress . "%";
            return response()->json(array('duration' => $duration, 'current_time' => $time, 'progress' => $progress), 200);
        } else {
            return response()->json(array('log_path' => $log_file), 404);
        }


    }

}

<?php

namespace App\Http\Controllers;

use App\Libary\REST\FileNodeJS;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class StorageNodeJS extends Controller
{
    public function getMedia($media_type, $name)
    {


        try {
            $file = FileNodeJS::getFile($media_type, $name);
            $response = Response::make($file['file'], $file['statuscode']);
            $response->header('Content-Type', $file['mime']);
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'file not found',
            ], 404);
        }

    }


    public function postMedia(Request $request)
    {

        /**
         * TODO: check if file exists!
         */
        /*
        $rules = array(
            'file' => 'image',
        );
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails())
        {
            return Response::json('error', 400);
        }*/

        $file = $request->file;
        $media_type = $request->media_type;

        $media = new Media();
        $media->media_type = $media_type;

        if (empty(trim($request->name))) {
            $request->name = 'unnamed';
        }
        $media->name = $request->name;
        $media->save();

        $media->origin_file = $media->media_id . '_0_' . md5($media->name . microtime(false) . rand(1, 10)) . '.' . $file->getClientOriginalExtension();
        $media->save();

        $statuscode = FileNodeJS::postFile($file, $media->origin_file, $media_type);
        return Response::json('', $statuscode);

    }

    public function deleteMedia($media_type, $name)
    {

        try {
            $m = Media::where('origin_file', '=', $name)
                ->where('media_type', '=', $media_type)->first();
            $m->delete();
            return redirect('/admin/media')->withErrors('Datei wurde gelöscht!', 'success');
        } catch (\Exception $e) {
            return redirect('/admin/media')->withErrors('Datei konnte nicht gelöscht werden! ' . $e->getMessage(), 'error');
        }


    }

}




<?php

namespace App\Http\Controllers;

use App\Libary\REST\FileNodeJS;
use App\Media;
use App\MediaCodecConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class StorageMediaController extends Controller
{
    public function getMedia($media_type, $name, Request $request)
    {
        try {
            if (isset($request->size)) {
                $size = intval($request->size);
            } else {
                $size = null;
            }
            $file = FileNodeJS::getFile($media_type, $name, $size);
            $response = Response::make($file['file'], $file['statuscode']);
            $response->header('Content-Type', $file['mime']);

            try {
                $mmc = MediaCodecConfig::where('file_path', $name)->firstOrFail();
                $mmc->size = $file['size'][0];
                $mmc->save();
            } catch (ModelNotFoundException $ex) {

            }
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'file not found',
            ], 404);
        }

    }


    public function postMedia(Request $request)
    {
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




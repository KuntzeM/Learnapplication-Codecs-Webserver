<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers;

use App\Libary\REST\FileNodeJS;
use App\Media;
use App\MediaCodecConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/**
 * Class StorageMediaController
 * nutzt API zum Mediaserver um Bild bzw Video Ressourcen zu anzufordern
 * @package App\Http\Controllers
 */
class StorageMediaController extends Controller
{
    /**
     * gibt das binäre Bild oder Video zurück
     * @param $media_type string (image | video)
     * @param $name string eindeutiger Name der Datei
     * @param Request $request
     * @return mixed
     */
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

            $response->header('Content-Type', $file['mime'])->header('duration', $file['duration']);

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

    /**
     * sendet dem Mediaserver das Bild bzw. Video
     * @param Request $request
     * @return mixed
     */
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

    /**
     * löscht eine Media-Datei vom Mediaserver
     * @param $media_type string (image | video)
     * @param $name string eindeutiger Dateiname
     * @return $this
     */
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

    /**
     * fordert PSNR, SSIM und Dateigröße vom Mediaserver an.
     */
    public function getFileMetaData()
    {
        $lockfile = join('/', [storage_path(), 'metadata.lock']);

        if (!file_exists($lockfile)) {
            $f = fopen($lockfile, "w");
            fclose($f);
        }

        $media_config = MediaCodecConfig::where('size', 0)
            ->orWhere('psnr', '0')
            ->orWhere('ssim', '0')->get();

        foreach ($media_config as $mc) {

            $metadata = FileNodeJS::getMetadata($mc->media->media_type, $mc->media->origin_file, $mc->media->media_type, $mc->file_path);
            $mc->psnr = $metadata['psnr'];
            $mc->ssim = $metadata['ssim'];
            $mc->size = $metadata['size'];
            $mc->save();
        }

        if (file_exists($lockfile)) {
            unlink($lockfile);
        }
    }
}




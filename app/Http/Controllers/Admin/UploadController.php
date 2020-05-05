<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    protected $video_types = [
        "video/mp4", "video/mpeg4", "video/webm"
    ];

    protected $audio_types = [
        "audio/mpeg", "audio/mp3"
    ];

    protected $model_types = [
        "application/octet-stream"
    ];


    /**
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file
     * @param $types
     * @return array
     * @throws Exception
     */
    protected function storageFile($file, $types)
    {

        if (!$file->isValid() || !in_array($file->getMimeType(), $types)) {
            throw new Exception("No valid file, you uploaded " . $file->getMimeType());
        }

        $microTime = (string)microtime(true);
        $dateString = now()->format("His");
        $dirString = now()->format("/Y/m/d");


        $filename = $dateString . $microTime . "." . $file->getClientOriginalExtension();
        $result = $file->storePubliclyAs($dirString, $filename, "s3");

        if (!empty($result)) {
            return [
                "code" => 0,
                "message" => "success",
                "data" => [
                    "temporary" => Storage::disk("s3")->temporaryUrl($result, now()->addMinutes(10)),
                    "path" => $result
                ]
            ];
        } else {
            abort(500, "Unknown Error when upload files to qiniu cloud.");
        }

        return [
            "code" => 1,
            "message" => "failed",
            "data" => []
        ];

    }


    public function video(Request $req)
    {
        $file = $req->file("file");

        if ($file == null) {
            abort(500, "no file uploaded.");
        }

        try {
            return $this->storageFile($file, $this->video_types);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }


    public function audio(Request $req)
    {
        $file = $req->file("file");


        if ($file == null) {
            abort(500, "no file uploaded.");
        }

        try {
            return $this->storageFile($file, $this->audio_types);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }

    }

    public function model(Request $req)
    {
        $file = $req->file("file");

        if ($file == null) abort(500, "no file uploaded.");

        try {
            return $this->storageFile($file, $this->model_types);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }

}

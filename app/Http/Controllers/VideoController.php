<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /* Registe Video */
    public function registervideo(Request $request)
    {
        $response = ["status" => 1, "msg" => ""];

        $data = $request->getContent();
        $data = json_decode($data);

        if (isset($data)) {
            try {
                $video = new Video();

                $video->title = $data->title;
                $video->videolink = $data->videolink;

                if (isset($data->course_id))
                    $video->course_id = $data->course_id;

                if (isset($data->video_thumbnail))
                    $video->video_thumbnail = $data->video_thumbnail;
                else
                    $video->video_thumbnail = "videoThumbnail.png";

                $video->save();
                $response['msg'] = "Video guardado correctamente";
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema" . $e->getMessage();
                $response['status'] = 0;
            }
        }

        return response()->json($response);
    }
}

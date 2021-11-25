<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users_video;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Models\Users_course;
use Illuminate\Support\Facades\DB;

class UsersVideoController extends Controller
{
    /* Show Video */
    public function showvideo(Request $request, $user_id)
    {
        $response = ["status" => 1, "msg" => ""];
        try {
            $user_id = User::where('id', $user_id)->value('id');
            $user = User::find($user_id);

            $video_id = $request->input('video_id');
            $videos = Video::find($video_id);

            if (CourseController::checkUserCourse($user_id, $videos->course_id)) {
                $videos = Video::find($video_id)->get();

                $uservideo_videoid = Users_video::where('video_id', $video_id)->value('video_id');

                if ($uservideo_videoid != $video_id) {
                    $uservideo = new Users_video();
                    $uservideo->user_id = $user->id;
                    $uservideo->video_id = $video_id;
                    $uservideo->save();
                }

                $response['msg'] = $videos;
            } else {
                $response['msg'] = "No puede ver videos de un curso que no ha comprado";
            }
        } catch (\Exception $e) {
            $response['msg'] = "Ha ocurrido un error " . $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }
}

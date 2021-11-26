<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users_video;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;

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
                $videos = Video::where('id', $video_id)->get();

                $register = Users_video::where('user_id', $user_id)->where('video_id', $video_id)->value('id');

                if (!$register) {
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

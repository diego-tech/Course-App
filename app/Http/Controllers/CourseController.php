<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Users_video;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /* Register Course */
    public function registercourse(Request $request)
    {
        $response = ["status" => 1, "msg" => ""];

        $data = $request->getContent();
        $data = json_decode($data);

        if (isset($data)) {
            try {
                $course = new Course();

                $course->title = $data->title;
                $course->description = $data->description;

                if (isset($data->course_thumbnail))
                    $course->course_thumbnail = $data->course_thumbnail;
                else
                    $course->course_thumbnail = "thumbnail.png";

                $course->save();
                $response['msg'] = "Curso guardado correctamente";
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema" . $e->getMessage();
                $response['status'] = 0;
            }
        }

        return response()->json($response);
    }

    /* List all courses register and filter by name */
    public function listcourses(Request $request)
    {
        $response = ["status" => 1, "msg" => ""];

        try {
            $course = DB::table('courses')
                ->select(
                    'courses.title',
                    'courses.course_thumbnail',
                    DB::raw('(SELECT COUNT(videos.course_id) from videos WHERE videos.course_id = courses.id) as videos')
                )
                ->distinct();

            if ($request->has('title') && $request->input('title'))
                $course = $course->where('courses.title', 'like', '%' . $request->input('title') . '%');

            $response['msg'] = $course->get();
        } catch (\Exception $e) {
            $response['msg'] = "Ha ocurrido un error " . $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }

    /* List videos with user accquire course */
    public function listvideos(Request $request, $user_id)
    {
        $response = ["status" => 1, "msg" => ""];

        try {
            if ($request->has('course_id')) {
                if ($this->checkUserCourse($user_id, $request->input('course_id'))) {
                    $videos = Video::where('course_id', $request->input('course_id'))->get();

                    $query_response = ["Titulo Video" => "", "Foto Video" => "", "Visto" => ""];

                    $videos_users = Users_video::join('videos', 'video_id', 'videos.id')
                        ->where('user_id', $user_id)
                        ->where('videos.course_id', $request->input('course_id'))
                        ->get();

                    foreach ($videos as $video) {
                        $query_response["Titulo Video"] = $video->title;
                        $query_response["Foto Video"] = $video->video_thumbnail;
                        foreach ($videos_users as $video_user) {
                            if ($video->id == $video_user->video_id) {
                                $query_response["Visto"] = "true";
                                break;
                            } else {
                                $query_response["Visto"] = "NULL";
                            }
                        }

                        $result[] = $query_response;
                    }
                    $response["msg"] = $result;
                } else {
                    $response['msg'] = "No puede ver videos de un curso que no ha comprado";
                }
            } else {
                $response['msg'] = "ID Curso no introducido";
            }
        } catch (\Exception $e) {
            $response['msg'] = "Ha ocurrido un error " . $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }

    /* Check if user has this course */
    static public function checkUserCourse($user_id, $course_id)
    {
        $check = DB::table('users_courses')
            ->where('course_id', $course_id)
            ->where('user_id', $user_id)
            ->value('id');

        if ($check) {
            return true;
        }

        return false;
    }
}

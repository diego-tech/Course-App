<?php

namespace App\Http\Controllers;

use App\Models\Users_course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CourseController;

class UsersCourseController extends Controller
{
    /* Acquire a course */
    public function acquirecourse(Request $request)
    {
        $response = ["status" => 1, "msg" => ""];

        $data = $request->getContent();
        $data = json_decode($data);

        if (isset($data)) {
            try {
                $userCourse = new Users_course();
                if (CourseController::checkUserCourse($data->user_id, $data->course_id) == false) {
                    if (isset($data->user_id))
                        $userCourse->user_id = $data->user_id;

                    if (isset($data->course_id))
                        $userCourse->course_id = $data->course_id;

                    $userCourse->save();
                    $response['msg'] = "Curso adquirido";
                } else {
                    $response['msg'] = "Ya ha adquirido este curso";
                }
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema" . $e->getMessage();
                $response['status'] = 0;
            }
        }
        return response()->json($response);
    }

    /* List course acquire byt the user */
    public function listcourses($id)
    {
        $response = ["status" => 1, "msg" => ""];

        try {
            $courses = DB::table('users_courses')
                ->join('courses', 'course_id', '=', 'courses.id')
                ->select(
                    'courses.title',
                    'courses.description'
                )
                ->where('users_courses.user_id', $id);

            $response['msg'] = $courses->get();
        } catch (\Exception $e) {
            $response['msg'] = "Ha ocurrido un problema" . $e->getMessage();
            $response['status'] = 0;
        }

        return response()->json($response);
    }
}

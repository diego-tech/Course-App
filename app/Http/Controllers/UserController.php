<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /* Register User */
    public function register(Request $request)
    {
        $response = ["status" => 1, "msg" => ""];

        $data = $request->getContent();
        $data = json_decode($data);

        if (isset($data)) {
            try {
                $user = new User();

                $user->name = $data->name;
                $user->email = $data->email;
                $user->password = $data->password;
                $user->active = 1;

                if (isset($data->photo))
                    $user->photo = $data->photo;
                else
                    $user->photo = "defaultPhoto.png";

                $user->save();
                $response['msg'] = "Usuario guardado correctamente";
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema: " . $e->getMessage();
                $response['status'] = 0;
            }
        }

        return response()->json($response);
    }

    /* Modify User */
    public function modify(Request $request, $id)
    {
        $response = ["status" => 1, "msg" => ""];

        $data = $request->getContent();
        $data = json_decode($data);

        if ($data != null) {
            try {
                $user = User::find($id);

                if ($user) {
                    if (isset($data->name))
                        $user->name = $data->name;
                    if (isset($data->password))
                        $user->password = $data->password;
                    if (isset($data->photo))
                        $user->photo = $data->photo;

                    if ($request->has('unsubscribe') && $request->input('unsubscribe') == "si")
                        $user->active = 0;

                    $user->save();
                    $response['msg'] = "Usuario modificado con id " . $user->id;
                }
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema: " . $e->getMessage();
                $response['status'] = 0;
            }
        }

        return response()->json($response);
    }
}

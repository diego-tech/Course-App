<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

                if (!$this->checkemailrepeat($data->email)) {

                    if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
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
                    } else {
                        $response['msg'] = "El email introducido no tiene la forma correcta";
                    }
                } else {
                    $response['msg'] = "Ya existe un usuario con este email";
                }
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
                    if ($request->has('unsubscribe') && $request->input('unsubscribe') == "si") {
                        $user->active = 0;
                    } else {
                        if (isset($data->name))
                            $user->name = $data->name;
                        if (isset($data->password))
                            $user->password = $data->password;
                        if (isset($data->photo))
                            $user->photo = $data->photo;
                    }

                    $user->save();
                    $response['msg'] = "Usuario modificado con id " . $user->id;
                } else {
                    $response['msg'] = "El usuario con id " . $id . " no existe";
                }
            } catch (\Exception $e) {
                $response['msg'] = "Ha ocurrido un problema: " . $e->getMessage();
                $response['status'] = 0;
            }
        }

        return response()->json($response);
    }

    /* Check if user has the same email */
    public function checkemailrepeat($email)
    {
        $check = DB::table('users')
            ->where('email', $email)
            ->value('id');

        if ($check) {
            return true;
        }

        return false;
    }
}

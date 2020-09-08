<?php

namespace App\Http\Controllers;

use App\Call;
use App\Schedule;
use App\User;
use Illuminate\Http\Response;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->class = User::class;
    }

    public function clients()
    {
        return response()->json(User::clients()->get());
    }

    public function destroy(int $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json('Recurso não encontrado', Response::HTTP_NOT_FOUND);
        }

        $existSchedule = Schedule::where('user_id', $user->id)->get();
        $existCall = Call::where('user_id', $user->id)->get();

        if (!is_null($existSchedule) || !is_null($existCall)) {
            return response()->json('Recurso não pode ser excluído, possui relação com um objeto ativo', Response::HTTP_BAD_REQUEST);
        }

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}

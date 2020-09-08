<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\Team;
use Illuminate\Http\Response;

class TeamController extends BaseController
{
    public function __construct()
    {
        $this->class = Team::class;
    }

    public function destroy(int $id)
    {
        $team = Team::find($id);
        if (is_null($team)) {
            return response()->json('Recurso não encontrado', Response::HTTP_NOT_FOUND);
        }

        $existSchedule = Schedule::where('team_id', $team->id)->get();

        if(!is_null($existSchedule)){
            return response()->json('Recurso não pode ser excluído, possui relação com um objeto ativo', Response::HTTP_BAD_REQUEST);
        }

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

}

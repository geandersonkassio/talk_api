<?php

namespace App\Http\Controllers;

use App\Call;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CallController extends BaseController
{
    public function __construct()
    {
        $this->class = Call::class;
    }

    public function update(int $id, Request $request)
    {
        $call = Call::find($id);
        if (is_null($call)) {
            return response()->json('Recurso não encontrado', Response::HTTP_BAD_REQUEST);
        }

        if($request->has('status') && $request->status ==='fechado'){
            $schedule = Schedule::where('call_id', $call->id)->first();

            if(is_null($schedule)){
                return response()->json('Não é possivel fechar um chamado que não foi agendando', Response::HTTP_BAD_REQUEST);
            }
            $schedule->status = 'fechado';
            $schedule->save();
        }    

        $call->fill($request->all());
        $call->save();

        return response()->json($call);
    }

    public function destroy(int $id)
    {
        $call = Call::find($id);
        if (is_null($call)) {
            return response()->json('Recurso não encontrado', Response::HTTP_NOT_FOUND);
        }

        $existSchedule = Schedule::where('call_id', $call->id)->get();

        if(!is_null($existSchedule)){
            return response()->json('Recurso não pode ser excluído, possui relação com um objeto ativo', Response::HTTP_BAD_REQUEST);
        }

        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function searchByUser(int $id)
    {
        return response()->json(Call::where('user_id', $id)->get());
    }
}

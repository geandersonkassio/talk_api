<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleController extends BaseController
{

    public function __construct()
    {
        $this->class = Schedule::class;
    }

    public function store(Request $request)
    {   
        $callOpen = Schedule::where('call_id', $request->call_id)
            ->where('status', 'aberto')->first();

        $scheduleConflict = Schedule::where('team_id', $request->team_id)
            ->where('date_schedule', $request->date_schedule)->first();

        if (!is_null($callOpen)) {
            return response()->json('Esse chamado já está agendado', Response::HTTP_BAD_REQUEST);
        }

        if ($scheduleConflict) {
            return response()->json('Essa equipe está ocupada para este dia', Response::HTTP_BAD_REQUEST);;
        }

        $schedule = Schedule::create($request->all());

        return response()->json($schedule);
    }

    public function update(int $id, Request $request)
    {
        $schedule = Schedule::find($id);
        if (is_null($schedule)) {
            return response()->json('Recurso não encontrado', Response::HTTP_BAD_REQUEST);
        }

        $callOpen = Schedule::where('call_id', $request->call_id)
            ->where('status', 'aberto')->first();

        $callClose = Schedule::where('call_id', $request->call_id)
            ->where('status', 'fechado')->first();

        $scheduleConflict = Schedule::where('team_id', $request->team_id)
            ->where('date_schedule', $request->date_schedule)->first();

        if($callClose && $request->has('status') && $request->status==='aberto'){
            return response()->json('Esse chamado já está fechado, não é possivel abrir o agendamento!', Response::HTTP_BAD_REQUEST);
        }

        if ($callOpen) {
            return response()->json('Esse chamado já está agendado', Response::HTTP_BAD_REQUEST);
        }

        if ($scheduleConflict) {
            return response()->json('Essa equipe está ocupada para este dia', Response::HTTP_BAD_REQUEST);;
        }

        $schedule->fill($request->all());
        $schedule->save();

        return response()->json($schedule);
    }
    
}

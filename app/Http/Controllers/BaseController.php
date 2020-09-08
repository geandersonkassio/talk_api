<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class BaseController extends Controller
{
    protected $class;

    public function index()
    {
        return response()->json($this->class::all());
    }

    public function store(Request $request)
    {
        $recurso = $this->class::create($request->all());
        return response()->json($recurso, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $recurso = $this->class::find($id);
        if (is_null($recurso)) {
            return response()->json('', Response::HTTP_NO_CONTENT);
        }
        return response()->json($recurso);
    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->class::find($id);
        if (is_null($recurso)) {
            return response()->json('Recurso não encontrado', Response::HTTP_NOT_FOUND);
        }

        $recurso->fill($request->all());
        $recurso->save();

        return response()->json($recurso);
    }

    public function destroy(int $id)
    {
        $recurso = $this->class::destroy($id);
        if ($recurso === 0) {
            return response()->json('Recurso não encontrado', Response::HTTP_NOT_FOUND);
        }
        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}

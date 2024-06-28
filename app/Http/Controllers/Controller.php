<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Exception\UuidExceptionInterface;


class Controller extends BaseController
{
    // protected $model;
    // use AuthorizesRequests, ValidatesRequests;

    // public function __construct($model)
    // {
    //     $this->model = $model;
    // }
    // public function index()
    // {
    //     return response()->json($this->model::orderBy('updated_at','DESC')->paginate(10));
    // }
    // public function store(Request $request)
    // {
    //     // $generatedUUID =Str::uuid()->toString();
    //     $record = $this->model::create($request->all());
    //     return response()->json($record, 201);
    // }

    // public function show($id)
    // {
    //     $record = $this->model::findOrFail($id);
    //     return response()->json($record);
    // }

    // public function update(Request $request, $id)
    // {
    //     $record = $this->model::findOrFail($id);
    //     $record->update($request->all());
    //     return response()->json($record);
    // }

    // public function destroy($id)
    // {
    //     $record = $this->model::findOrFail($id);
    //     $record->delete();
    //     return response()->json(null, 204);
    // }
}
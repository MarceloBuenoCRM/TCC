<?php

namespace App\Http\Controllers;

use App\Http\Requests\AulaRequest;
use Illuminate\Http\Request;
use App\Models\AulaModel;
use App\Services\AulaService;
use App\Transformers\AulaTransformer;

class AulaController extends Controller
{
    protected AulaModel $model;
    protected AulaTransformer $transformer;
    protected AulaService $service;

    public function __construct(AulaTransformer $transformer, AulaService $service)
    {
        $this->transformer = $transformer;
        $this->service     = $service;
    }

    public function index(Request $request)
    {
        $rows = $this->service->index($request->all())->simplePaginate($request->per_page);

        $rows = $this->transformer->transform($rows);

        return response()->json([
            'data' => $rows
        ]);
    }

    public function show($id)
    {
        $row = $this->service->show($id)->simplePaginate(1);

        $row = $this->transformer->transform($row);

        return response()->json([
            'data' => $row
        ]);
    }

    public function store(AulaRequest $request)
    {
        $data = $request->all();

        $row = $this->service->create($data);

        return response($row, 201);
    }

    public function update($id, AulaRequest $request)
    {
        $data = $request->all();

        $this->service->update($id, $data);

        return response([], 204);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response([], 204);
    }

    public function getClassDay()
    {
        $rows = $this->service->getClassDay()->paginate(10);

        $rows = $this->transformer->transform($rows);

        return response()->json([
            'data' => $rows
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaRequest;
use Illuminate\Http\Request;
use App\Models\SalaModel;
use App\Services\SalaService;
use App\Transformers\SalaTransformer;

class SalaController extends Controller
{
    protected SalaModel $model;
    protected SalaTransformer $transformer;
    protected SalaService $service;

    public function __construct(SalaTransformer $transformer, SalaService $service)
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

    public function store(SalaRequest $request)
    {
        $data = $request->all();

        $row = $this->service->create($data);

        return response($row, 201);
    }

    public function update($id, SalaRequest $request)
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
}

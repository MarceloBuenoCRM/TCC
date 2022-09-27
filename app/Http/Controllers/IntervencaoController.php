<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntervencaoRequest;
use Illuminate\Http\Request;
use App\Models\IntervencaoModel;
use App\Services\IntervencaoService;
use App\Transformers\IntervencaoTransformer;

class IntervencaoController extends Controller
{
    protected IntervencaoModel $model;
    protected IntervencaoTransformer $transformer;
    protected IntervencaoService $service;

    public function __construct(IntervencaoTransformer $transformer, IntervencaoService $service)
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

    public function store(IntervencaoRequest $request)
    {
        $data = $request->all();

        $row = $this->service->create($data);

        return response($row, 201);
    }

    public function update($id, IntervencaoRequest $request)
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

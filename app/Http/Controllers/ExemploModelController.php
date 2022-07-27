<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExemploModelRequest;
use Illuminate\Http\Request;
use App\Models\ExemploModel;
use App\Services\ExemploModelService;
use App\Transformers\ExemploModelTransformer;

class ExemploModelController extends Controller
{
    protected ExemploModel $model;
    protected ExemploModelTransformer $transformer;
    
    public function __construct(ExemploModel $model, ExemploModelTransformer $transformer, ExemploModelService $service)
    {
        $this->transformer = $transformer;
        $this->service     = $service;
    }

    public function index()
    {
        $rows = $this->service->index()->paginate(10);
        
        $rows = $this->transformer->transform($rows);

        return response()->json([
            'data' => $rows
        ]);
    }

    public function store(ExemploModelRequest $request)
    {
        $row = $this->service->create($request->all());

        return response($row, 201);
    }
}

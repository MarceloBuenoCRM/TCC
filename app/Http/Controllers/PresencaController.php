<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresencaRequest;
use Illuminate\Http\Request;
use App\Models\PresencaModel;
use App\Services\PresencaService;
use App\Transformers\PresencaTransformer;

class PresencaController extends Controller
{
    protected PresencaModel $model;
    protected PresencaTransformer $transformer;
    protected PresencaService $service;

    public function __construct(PresencaTransformer $transformer, PresencaService $service)
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

    public function store(PresencaRequest $request)
    {
        $data = $request->all();

        if(isset($data['verifica'])){
            $row = PresencaModel::where('id_aula', $data['id_aula'])->get();

            if(count($row) > 0){
                return response(['ok'], 201);
            }
        }

        $row = $this->service->create($data);

        return response($row, 201);
    }

    public function update($id, PresencaRequest $request)
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

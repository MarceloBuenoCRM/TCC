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

        if($data['cad_recorrencia'] == true){
            for ($i=0; $i < 24; $i++) {
                if($i >= 1){
                    $datetimeIni = \DateTime::createFromFormat('Y-m-d H:i:s', $data['cad_data_hora_inicio']);
                    $datetimeFim = \DateTime::createFromFormat('Y-m-d H:i:s', $data['cad_data_hora_fim']);
                    $data['cad_data_hora_inicio'] = $datetimeIni->modify('+7 days')->format('Y-m-d H:i:s');
                    $data['cad_data_hora_fim'] = $datetimeFim->modify('+7 days')->format('Y-m-d H:i:s');
                }

                $row = $this->service->create($data);
            }
        }else{
            $row = $this->service->create($data);
        }

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
        $data = $this->service->getClassDay();
        $rows = $data[0]->paginate(10);
        $verifica = $data[1];

        $rows = $this->transformer->transform($rows);

        if($verifica == 1){
            $rows[0]->finalizado = 1;
        }else{
            $rows[0]->finalizado = 0;
        }

        return response()->json([
            'data' => $rows
        ]);
    }
}

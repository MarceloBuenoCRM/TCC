<?php

namespace App\Services;

use App\Models\PresencaModel;
use App\Models\IntervencaoModel;
use Carbon\Carbon;

class IntervencaoService
{
    protected IntervencaoModel $model;

    public function __construct(IntervencaoModel $model)
    {
        $this->model = $model;
    }

    public function index(array $params = [])
    {
        return $this->model->index($params);
    }

    public function show($id)
    {
        return $this->model->index([])->where('intervencao.id', $id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $aula = \DB::table('aulas')
                    ->select('*')
                    ->where('aulas.cad_disciplina', $data['cad_disciplina'])
                    ->where('aulas.cad_data_hora_inicio', 'LIKE', '%' . $data['cad_data'] . '%')->first();

        $presenca = \DB::table('presencas')->where('id_aula', $aula->id)->first();

        if($presenca){
            if($data['cad_aprovado'] == 0){
                PresencaModel::findOrFail($presenca->id)->update(['presenca' => 0]);
            }else{
                PresencaModel::findOrFail($presenca->id)->update(['presenca' => 1]);
            }
        }else{
            if($data['cad_aprovado'] == 0){
                PresencaModel::create(['id_aula' => $aula->id,'presenca' => 0, 'id_aluno' => $data['cad_aluno']]);
            }else{
                PresencaModel::create(['id_aula' => $aula->id,'presenca' => 1, 'id_aluno' => $data['cad_aluno']]);
            }
        }

        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}

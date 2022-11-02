<?php

namespace App\Services;

use App\Models\AulaModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AulaService
{
    protected AulaModel $model;

    public function __construct(AulaModel $model)
    {
        $this->model = $model;
    }

    public function index(array $params = [])
    {
        return $this->model->index($params);
    }

    public function show($id)
    {
        return $this->model->index([])->where('aulas.id', $id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function getClassDay()
    {
        $initialDate = Carbon::now()->format('Y-m-d 00:00:00');
        $lastDate    = Carbon::now()->addDay(1)->format('Y-m-d 00:00:00');
        $rows = DB::table('aulas')
                      ->select('aulas.*', 'salas.*', 'users.cad_nome as dsc_professor')
                      ->join('salas', 'salas.id', 'aulas.cad_num_sala')
                      ->join('users', 'users.id', 'aulas.id_professor')
                      ->whereBetween('cad_data_hora_inicio', [$initialDate, $lastDate])
                      ->orderBy('cad_data_hora_inicio', 'DESC');

        $id_aula = $rows->get()[0]->id;
        $verifica = DB::table('presencas')->where('id_aula', $id_aula)->where('id_aluno', \Auth::id())->get();

        if(count($verifica) > 0){
            $verifica = true;
        }else{
            $verifica = false;
        }

        return [$rows, $verifica];
    }
}

<?php

namespace App\Services;

use App\Models\AulaModel;
use Carbon\Carbon;

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
        return $this->model->index([])->where('id', $id);
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
        return AulaModel::select('*')->whereBetween('cad_data_hora_inicio', [$initialDate, $lastDate]);
    }
}

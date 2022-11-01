<?php

namespace App\Services;

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
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}

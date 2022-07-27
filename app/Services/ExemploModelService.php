<?php

namespace App\Services;

use App\Models\ExemploModel;

class ExemploModelService 
{
    protected ExemploModel $model;

    public function __construct(ExemploModel $model)
    {
        $this->model = $model;
    }

    public function index(Array $params = [])
    {
        return $this->model->index($params);
    }

    public function show($id)
    {
        return $this->model->index([])->where('id_exemplo', $id);
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

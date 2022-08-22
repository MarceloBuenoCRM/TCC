<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'salas';
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];

    public function index($params)
    {
        $query = $this->select("*")
                      ->orderBy('cad_num_sala');

        $query = $this->filter($query, $params);

        return $query;
    }

    private function filter($query, array $params)
    {
        if (isset($params['cad_num_sala'])) {
            $query->where('cad_num_sala', $params['cad_num_sala']);
        }

        if (isset($params['cad_bloco'])) {
            $query->where('cad_bloco', $params['cad_bloco']);
        }

        return $query;
    }
}

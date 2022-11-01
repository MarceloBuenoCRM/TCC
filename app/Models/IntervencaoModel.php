<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervencaoModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'intervencao';
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];

    public function index($params)
    {
        $query = $this->select("intervencao.*", "users.cad_nome")
                      ->join('users', 'users.id', 'intervencao.cad_aluno')
                      ->orderBy('cad_data', 'DESC');

        $query = $this->filter($query, $params);

        return $query;
    }

    private function filter($query, array $params)
    {
        if (isset($params['cad_curso'])) {
            $query->where('cad_curso', $params['cad_curso']);
        }

        if (isset($params['cad_data'])) {
            $query->where('cad_data', $params['cad_data']);
        }

        if (isset($params['cad_aluno'])) {
            $query->where('intervencao.cad_aluno', $params['cad_aluno']);
        }

        if (isset($params['cad_professor'])) {
            $query->where('cad_professor', $params['cad_professor']);
        }

        if (isset($params['cad_aprovado'])) {
            $query->where('cad_aprovado', $params['cad_aprovado']);
        }

        return $query;
    }
}

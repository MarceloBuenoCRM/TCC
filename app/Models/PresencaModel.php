<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresencaModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'presencas';
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id_aluno = \Auth::user()->id;
        });
    }

    public function index($params)
    {
        $query = $this->select("*", "aulas.*", "users.*")
                      ->join('aulas', 'aulas.id', 'presencas.id_aula')
                      ->join('users', 'users.id', 'aulas.id_professor')
                      ->where('id_aluno', \Auth::id());

        $query = $this->filter($query, $params);

        return $query;
    }

    private function filter($query, array $params)
    {
        if (isset($params['id_aula'])) {
            $query->where('id_aula', $params['id_aula']);
        }

        if (isset($params['presenca'])) {
            $query->where('presenca', $params['presenca']);
        }

        if (isset($params['cad_nome'])) {
            $query->where('cad_nome', 'LIKE', '%' . $params['cad_nome'] . '%');
        }

        if (isset($params['cad_disciplina'])) {
            $query->where('cad_disciplina', 'LIKE', '%' . $params['cad_disciplina'] . '%');
        }

        if (isset($params['cad_data_hora_inicio'])) {
            $query->where('cad_data_hora_inicio', 'LIKE', '%' . $params['cad_data_hora_inicio'] . '%');
        }

        return $query;
    }
}

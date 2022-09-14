<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AulaModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'aulas';
    protected $primaryKey   = 'id';
    protected $guarded      = ['id'];

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id_professor = Auth::user()->id;
        });
    }

    public function index($params)
    {
        $query = $this->select("*")
                      ->orderBy('cad_data_hora_inicio');

        $query = $this->filter($query, $params);

        return $query;
    }

    private function filter($query, array $params)
    {
        if (isset($params['cad_disciplina'])) {
            $query->where('cad_disciplina', $params['cad_disciplina']);
        }

        if (isset($params['cad_curso'])) {
            $query->where('cad_curso', $params['cad_curso']);
        }

        if (isset($params['cad_periodo'])) {
            $query->where('cad_periodo', $params['cad_periodo']);
        }

        if (isset($params['cad_data_hora_inicio'])) {
            $query->where('cad_data_hora_inicio', $params['cad_data_hora_inicio']);
        }

        if (isset($params['cad_data_hora_fim'])) {
            $query->where('cad_data_hora_fim', $params['cad_data_hora_fim']);
        }

        if (isset($params['cad_num_sala'])) {
            $query->where('cad_num_sala', $params['cad_num_sala']);
        }

        if (isset($params['cad_bloco'])) {
            $query->where('cad_bloco', $params['cad_bloco']);
        }

        return $query;
    }
}

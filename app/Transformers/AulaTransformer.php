<?php

namespace App\Transformers;

class AulaTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id                   = $value->id;
            $value->cad_disciplina       = (string) $value->cad_disciplina;
            $value->cad_curso            = (string) $value->cad_curso;
            $value->cad_periodo          = (string)$value->cad_periodo;
            $value->cad_num_sala         = (int)$value->cad_num_sala;
            $value->cad_bloco            = (string)$value->cad_bloco;
            $value->cad_data_hora_inicio = (string)$value->cad_data_hora_inicio;
            $value->cad_data_hora_fim    = (string)$value->cad_data_hora_fim;
            $value->cad_tempo_minimo     = (int)$value->cad_tempo_minimo;
            $value->cad_tempo_tolerancia = (int)$value->cad_tempo_tolerancia;
            $value->id_professor         = (int)$value->id_professor;
            $value->cad_latitude         = (float)$value->cad_latitude;
            $value->cad_longitude        = (float)$value->cad_longitude;
            $value->cad_diametro         = (int)$value->cad_diametro;
            $value->cad_recorrencia      = (int)$value->cad_recorrencia;
            return $value;
        });

        return $rows;
    }
}

<?php

namespace App\Transformers;

class IntervencaoTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id                   = $value->id;
            $value->cad_aluno            = (string) $value->cad_aluno;
            $value->cad_curso            = (string) $value->cad_curso;
            $value->cad_disciplina       = (string)$value->cad_disciplina;
            $value->cad_data             = (string)$value->cad_data;
            $value->cad_professor        = (string)$value->cad_professor;
            $value->cad_motivo           = (int)$value->cad_motivo;
            return $value;
        });

        return $rows;
    }
}

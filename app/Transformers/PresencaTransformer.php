<?php

namespace App\Transformers;

class PresencaTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id       = $value->id;
            $value->id_aula  = (int)$value->id_aula;
            $value->presenca = (int)$value->presenca;
            return $value;
        });

        return $rows;
    }
}

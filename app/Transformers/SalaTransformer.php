<?php

namespace App\Transformers;

class SalaTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id            = $value->id;
            $value->cad_num_sala  = (string) $value->cad_num_sala;
            $value->cad_bloco     = (string) $value->cad_bloco;
            $value->cad_latitude  = (string)$value->cad_latitude;
            $value->cad_longitude = (string)$value->cad_longitude;
            $value->cad_diametro  = (string)$value->cad_diametro;
            return $value;
        });

        return $rows;
    }
}

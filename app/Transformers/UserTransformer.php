<?php

namespace App\Transformers;

class UserTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id        = $value->id;
            $value->cad_nome  = (string) $value->cad_nome;
            $value->cad_email = (string) $value->cad_email;

            return $value;
        });

        return $rows;
    }
}

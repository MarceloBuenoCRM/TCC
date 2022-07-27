<?php

namespace App\Transformers;

class ExemploModelTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id         = $value->id;
            $value->observacao = (string) $value->observacao;

            return $value;
        });

        return $rows;
    }
}
<?php

namespace App\Transformers;

class PacienteTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id_paciente                  = $value->id_paciente;
            $value->cad_nome                     = (string) $value->cad_nome;
            $value->cad_email                    = (string) $value->cad_email;
            $value->cad_sexo                     = (string) $value->cad_sexo;
            $value->cad_tel                      = (string) $value->cad_tel;
            $value->cad_cel                      = (string) $value->cad_cel;
            $value->cad_cidade                   = (string) $value->cad_cidade;
            $value->cad_estado                   = (string) $value->cad_estado;
            $value->cad_cep                      = (string) $value->cad_cep;
            $value->cad_data_nascimento          = (string) $value->cad_data_nascimento;
            $value->cad_estado_civil             = (string) $value->cad_estado_civil;
            $value->cad_profissao                = (string) $value->cad_profissao;
            $value->cad_bairro                   = (string) $value->cad_bairro;
            $value->cad_numero                   = (string) $value->cad_numero;
            $value->cad_logradouro               = (string) $value->cad_logradouro;

            return $value;
        });

        return $rows;
    }
}

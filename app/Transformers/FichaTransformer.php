<?php

namespace App\Transformers;

class FichaTransformer
{
    public function transform($rows)
    {
        $rows->getCollection()->transform(function ($value) {
            $value->id_ficha                     = $value->id_ficha;
            $value->cad_meia                     = (string) $value->cad_meia;
            $value->cad_calcado                  = (string) $value->cad_calcado;
            $value->cad_num_calcado              = (int) $value->cad_calcado;
            $value->cad_cirurgia_membro_inferior = (string) $value->cad_cirurgia_membro_inferior;
            $value->cad_hipertensao              = boolval($value->cad_hipertensao);
            $value->hipertensao                  = boolval($value->cad_hipertensao) ? 'Sim' : 'Não';
            $value->cad_esporte                  = (string) $value->cad_esporte;
            $value->cad_hepatite                 = boolval($value->cad_hepatite);
            $value->hepatite                     = boolval($value->cad_hepatite) ? 'Sim' : 'Não';
            $value->cad_medicamento              = (string) $value->cad_medicamento;
            $value->cad_hiv                      = boolval($value->cad_hiv);
            $value->hiv                          = boolval($value->cad_hiv) ? 'Sim' : 'Não';
            $value->cad_psoriase                 = boolval($value->cad_psoriase);
            $value->psoriase                     = boolval($value->cad_psoriase) ? 'Sim' : 'Não';
            $value->cad_dermatite                = boolval($value->cad_dermatite);
            $value->dermatite                    = boolval($value->cad_dermatite) ? 'Sim' : 'Não';
            $value->cad_hanseniase               = boolval($value->cad_hanseniase);
            $value->hanseniase                   = boolval($value->cad_hanseniase) ? 'Sim' : 'Não';
            $value->cad_acido_urico              = boolval($value->cad_acido_urico);
            $value->acido_urico                  = boolval($value->cad_acido_urico) ? 'Sim' : 'Não';
            $value->cad_tempo                    = (string) $value->cad_tempo;
            $value->cad_alergia                  = (string) $value->cad_alergia;
            $value->cad_diabetes                 = (string) $value->cad_diabetes;
            $value->cad_tireoide                 = (string) $value->cad_tireoide;
            $value->cad_circulatorio             = boolval($value->cad_circulatorio);
            $value->circulatorio                 = boolval($value->cad_circulatorio) ? 'Sim' : 'Não';
            $value->cad_antecedentes             = boolval($value->cad_antecedentes);
            $value->antecedentes                 = boolval($value->cad_antecedentes) ? 'Sim' : 'Não';
            $value->cad_sensibilidade            = (string) $value->cad_sensibilidade;
            $value->cad_perfusao_pd              = (string) $value->cad_perfusao_pd;
            $value->cad_perfusao_pe              = (string) $value->cad_perfusao_pe;
            $value->cad_digito_pressao_pd        = (string) $value->cad_digito_pressao_pd;
            $value->cad_digito_pressao_pe        = (string) $value->cad_digito_pressao_pe;
            $value->cad_monofilamento_pd         = (string) $value->cad_monofilamento_pd;
            $value->cad_monofilamento_pe         = (string) $value->cad_monofilamento_pe;
            $value->cad_pat_dermatologicas_pd    = (string) $value->cad_pat_dermatologicas_pd;
            $value->cad_pat_dermatologicas_pe    = (string) $value->cad_pat_dermatologicas_pe;
            $value->cad_pat_ungueais_pd          = (string) $value->cad_pat_ungueais_pd;
            $value->cad_pat_ungueais_pe          = (string) $value->cad_pat_ungueais_pe;
            $value->cad_observacoes              = (string) $value->cad_observacoes;

            return $value;
        });

        return $rows;
    }
}

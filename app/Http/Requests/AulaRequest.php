<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AulaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cad_disciplina'       => ['required'],
            'cad_curso'            => ['required'],
            'cad_periodo'          => ['required'],
            'cad_num_sala'         => ['required'],
            'cad_bloco'            => ['required'],
            'cad_data_hora_inicio' => ['required'],
            'cad_data_hora_fim'    => ['required'],
            'cad_tempo_minimo'     => ['required'],
            'cad_tempo_tolerancia' => ['required'],
            'id_professor'         => '',
        ];
    }

    public function messages()
    {
        return [];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntervencaoRequest extends FormRequest
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
            'cad_aluno'      => ['required'],
            'cad_curso'      => ['required'],
            'cad_disciplina' => ['required'],
            'cad_data'       => ['required'],
            'cad_professor'  => ['required'],
            'cad_motivo'     => ['required'],
            'cad_aprovado'   => '',
        ];
    }

    public function messages()
    {
        return [];
    }
}

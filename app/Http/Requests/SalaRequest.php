<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaRequest extends FormRequest
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
            'cad_num_sala'  => ['required', "unique:salas,cad_num_sala,{$this->get('id')},id"],
            'cad_bloco'     => '',
            'cad_latitude'  => ['required'],
            'cad_longitude' => ['required'],
            'cad_diametro'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'cad_num_sala.required'  => 'O campo Número da Sala é um campo obrigatório.',
            'cad_num_sala.unique'    => 'Registro já existente na base de dados.',
            'cad_latitude.required'  => 'O campo Latitude é um campo obrigatório.',
            'cad_longitude.required' => 'O campo Longitude é um campo obrigatório.',
            'cad_diametro.required'  => 'O campo Diâmetro é um campo obrigatório.',
        ];
    }
}

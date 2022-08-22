<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest
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
            'cad_nome'     => ['required'],
            'cad_email'    => ['required', "unique:users,cad_email,{$this->get('id')},id"],
            'tipo_usuario' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'cad_nome.required'     => 'O campo Nome é um campo obrigatório.',
            'cad_email.required'    => 'O campo Email é um campo obrigatório.',
            'cad_email.unique'      => 'Registro já existente na base de dados.',
            'tipo_usuario.required' => 'O campo Tipo Usuário é um campo obrigatório.',
        ];
    }
}

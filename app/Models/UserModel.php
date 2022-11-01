<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'users';
    protected $primaryKey   = 'id';
    protected $orders       = ['id', 'cad_nome', 'cad_email'];
    protected $guarded      = ['id'];

    public function index($params)
    {
        $query = $this->selectRaw("id,
                                cad_nome,
                                cad_email,
                                tipo_usuario")
                       ->orderBy('id');

        $query = $this->filter($query, $params);

        return $query;
    }

    private function filter($query, array $params)
    {
        if (isset($params['cad_nome'])) {
            $query->where('cad_nome', 'LIKE', '%' . $params['cad_nome'] . '%');
        }

        if (isset($params['cad_email'])) {
            $query->where('cad_email', 'LIKE', '%' . $params['cad_email'] . '%');
        }

        if (isset($params['tipo_usuario'])) {
            $query->where('tipo_usuario', $params['tipo_usuario']);
        }

        return $query;
    }

    public function updateModoEscuro($id)
    {
        $user = $this->findOrFail(Auth::id());
        $modo_escuro = $id;
        $user->update(['cad_modo_escuro' => (int)$modo_escuro]);

        return $modo_escuro;
    }
}

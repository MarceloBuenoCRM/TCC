<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExemploModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table        = 'exemplo_models';
    protected $primaryKey   = 'id';
    protected $orders       = ['observacao'];
    protected $guarded      = ['id'];

    public function index()
    {
        return $this->selectRaw("id,
                                observacao")
                            ->orderBy('id');
    }

    private function filter($query, array $params)
    {
        // Delete if not required.
        return $query;
    }
}

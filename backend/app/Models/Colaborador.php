<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Colaborador extends Model {

    protected $table = 'colaboradores';

    protected $fillable = [
        'codigo',
        'nome_completo',
        'apelido',
        'nome_pai',
        'nome_mae',
        'cpf',
        'data_nascimento',
        'cargo',
    ];

    public function getDataNascimentoAttribute($value) {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['dataNascimento', 'nomePai', 'nomeMae'];

    public function getDataNascimentoAttribute($value) {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    protected function dataNascimento(): Attribute {
        return Attribute::get(fn() => $this->data_nascimento);
    }

    public function setDataNascimento($value) {
        try {
            $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            $this->attributes['data_nascimento'] = $value;
        }
    }

    protected function nomePai(): Attribute {
        return Attribute::get(fn() => $this->nome_pai);
    }

    public function setNomePai($value) {
        $this->attributes['nome_pai'] = $value;
    }

    protected function nomeMae(): Attribute {
        return Attribute::get(fn() => $this->nome_mae);
    }

    public function setNomeMae($value) {
        $this->attributes['nome_mae'] = $value;
    }
}

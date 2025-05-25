<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('colaboradores', function(BluePrint $table) {
             $table->id();
             $table->string('codigo')->unique();
             $table->string('nome_completo');
             $table->string('apelido');
             $table->string('nome_pai');
             $table->string('nome_mae');
             $table->string('cpf')->unique();
             $table->date('data_nascimento');
             $table->string('cargo');
             $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('colaboradores');
    }
};

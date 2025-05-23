<?php

namespace Tests\Feature;

use App\Models\Colaborador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColaboradorTest extends TestCase {

    use RefreshDatabase;

    public function testeCriarColaborador() {
        $data = [
            'codigo' => '1234',
            'nome_completo' => 'Amanda Cardoso Volpato',
            'apelido' => 'Amanda',
            'nome_pai' => 'Edinho Volpato',
            'nome_mae' => 'Rosinete Cardoso',
            'cpf' => '12345678990',
            'data_nascimento' => '1999-06-20',
            'cargo' => 'Analista de Negócios'
        ];


        $response = $this->postJson('/api/colaboradores', $data);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'id' => $response->json('id'),
                'metodo' => 'CRIACAO',
                'retorno' => 'SUCESSO',
            ]);

        $this->assertDatabaseHas('colaboradores', [
            'codigo' => '1234',
            'cpf' => '12345678990'
        ]);
    }

    public function testAtualizarColaborador(): void {

        $id = $this->criarColaborador();


        $dadosAtualizados = [
            'codigo'          => '5678',
            'nome_completo'   => 'Amanda C. Volpato Atualizada',
            'apelido'         => 'Amandinha',
            'nome_pai'        => 'Edinho Volpato',
            'nome_mae'        => 'Rosinete Cardoso',
            'cpf'             => '09876543210',
            'data_nascimento' => '1999-06-20',
            'cargo'           => 'Gerente de Projetos',
        ];

        $response = $this->putJson("/api/colaboradores/{$id}", $dadosAtualizados);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id'      => $id,
                'metodo'  => 'ATUALIZAR',
                'retorno' => 'SUCESSO',
            ]);

        $this->assertDatabaseHas('colaboradores', [
            'id'            => $id,
            'codigo'        => $dadosAtualizados['codigo'],
            'nome_completo' => $dadosAtualizados['nome_completo'],
            'cpf'           => $dadosAtualizados['cpf'],
            'cargo'         => $dadosAtualizados['cargo'],
        ]);
    }

    private function criarColaborador(): int {
        $dados = [
            'codigo'          => '1234',
            'nome_completo'   => 'Amanda C. Volpato',
            'apelido'         => 'Amandinha',
            'nome_pai'        => 'Edinho Volpato',
            'nome_mae'        => 'Rosinete Cardoso',
            'cpf'             => '12345678901',
            'data_nascimento' => '1999-06-20',
            'cargo'           => 'Desenvolvedora',
        ];

        $response = $this->postJson('/api/colaboradores', $dados);

        $response->assertStatus(201);

        return $response->json('id');
    }


    public function testeDeletarColaborador() {
        $dados = [
            'codigo' => '4321',
            'nome_completo' => 'Carlos Silva',
            'apelido' => 'Carlitos',
            'nome_pai' => 'João Silva',
            'nome_mae' => 'Maria Silva',
            'cpf' => '11223344556',
            'data_nascimento' => '1985-04-15',
            'cargo' => 'Desenvolvedor'
        ];

        $responseCriar = $this->postJson('/api/colaboradores', $dados);
        $responseCriar->assertStatus(201)
            ->assertJsonFragment([
                'metodo' => 'CRIACAO',
                'retorno' => 'SUCESSO',
            ]);

        $id = $responseCriar->json('id');

        $responseDeletar = $this->deleteJson('/api/colaboradores/' . $id);

        $responseDeletar->assertStatus(200)
            ->assertJsonFragment([
                'id' => (string) $id,
                'metodo' => 'DELETE',
                'retorno' => 'SUCESSO'
    ]);


        $this->assertDatabaseMissing('colaboradores', [
            'id' => $id,
        ]);
    }
}

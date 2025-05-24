<template>
  <div class="container">
    <!-- Caixa com título e abas -->
    <div class="tabs">
      <h1>Colaboradores da Bruning</h1>
      <div class="tab-links">
        <NuxtLink to="/lista" class="tab" :class="{ active: $route.path === '/lista' }">Lista</NuxtLink>
        <NuxtLink to="/" class="tab" :class="{ active: $route.path === '/' }">Cadastro</NuxtLink>
      </div>
    </div>

    <!-- Formulário -->
    <div class="form-container">
      <h2>Formulário de Cadastro</h2>
      <form @submit.prevent="salvarColaborador">
        <!-- Linha 1 -->
        <div class="row cols-3">
          <div class="field">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" v-model="colaborador.codigo" :disabled="camposDesabilitados" />
          </div>
          <div class="field">
            <label for="nomeCompleto">Nome completo</label>
            <input type="text" id="nomeCompleto" v-model="colaborador.nome_completo" :disabled="camposDesabilitados" />
          </div>
          <div class="field">
            <label for="apelido">Apelido</label>
            <input type="text" id="apelido" v-model="colaborador.apelido" :disabled="camposDesabilitados" />
          </div>
        </div>

        <!-- Linha 2 -->
        <div class="row cols-2">
          <div class="field">
            <label for="nomePai">Nome do pai</label>
            <input type="text" id="nomePai" v-model="colaborador.nome_pai" :disabled="camposDesabilitados" />
          </div>
          <div class="field">
            <label for="nomeMae">Nome do mãe</label>
            <input type="text" id="nomeMae" v-model="colaborador.nome_mae" :disabled="camposDesabilitados" />
          </div>
        </div>

        <!-- Linha 3 -->
        <div class="row cols-3">
          <div class="field">
            <label for="cpf">CPF</label>
            <ClientOnly>
              <input v-imask="{ mask: '000.000.000-00' }" type="text" id="cpf" v-model="colaborador.cpf"
                placeholder="___.___.___-__" :disabled="camposDesabilitados" />
            </ClientOnly>
          </div>
          <div class="field">
            <label for="dataNascimento">Data de nascimento</label>
            <ClientOnly>
              <input v-imask="{ mask: '00/00/0000' }" type="text" id="data_nascimento"
                v-model="colaborador.data_nascimento" placeholder="__/__/____" :disabled="camposDesabilitados" />
            </ClientOnly>
          </div>
          <div class="field">
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" v-model="colaborador.cargo" :disabled="camposDesabilitados" />
          </div>
        </div>

        <!-- Botões -->
        <div class="actions">
          <div class="left-actions">
            <button type="button" @click="voltarParaLista">Voltar</button>
            <button v-if="modo === 'novo'" type="reset" @click="limpar">Limpar</button>
          </div>
          <button v-if="modo !== 'ver'" type="submit" class="save-button">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter();

const modo = ref(route.query?.modo ?? 'novo')
const codigo = ref(route.query?.codigo ?? null)

const camposDesabilitados = ref(false)

const colaborador = ref({
  codigo: '',
  nome_completo: '',
  apelido: '',
  nome_pai: '',
  nome_mae: '',
  cpf: '',
  data_nascimento: '',
  cargo: ''
})

const voltarParaLista = () => {
  router.push('/lista')
}

// Operações 

const salvarColaborador = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/colaboradores', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(colaborador.value)
    })

    const resultado = await response.json()

    if (!response.ok) {
      if (resultado?.errors) {
        const mensagens = Object.values(resultado.errors).flat()
        alert('Erro ao salvar:\n' + mensagens.join('\n'))
      } else {
        alert('Erro: ' + (resultado?.message ?? 'Erro desconhecido'))
      }
      return
    }

    alert('Colaborador cadastrado com sucesso!')
    router.push('/lista')
  } catch (erro) {
    console.error(erro)
    alert('Erro ao conectar com o servidor.')
  }
}

onMounted(async () => {
  if ((modo.value === 'editar' || modo.value === 'ver') && codigo.value) {
    // dados simulados
    colaborador.value = {
      codigo: '999',
      nome: 'Richard Pereira Cardoso',
      apelido: 'Rich',
      nome_pai_mae: 'Maria Cardoso',
      nome_pai_mae2: 'João Pereira',
      cpf: '123.456.789-00',
      nascimento: '1990-01-01',
      cargo: 'Analista'
    }

    camposDesabilitados.value = modo.value === 'ver'
  }
})


</script>

<style scoped>
* {
  font-family: 'Inter', sans-serif;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

.container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 0 24px;
  color: #1f2937;
}

/* Área de abas e título */
.tabs {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #ccc;
  padding: 20px 24px;
  margin-bottom: 24px;
  border-radius: 4px;
  background-color: #fff;
}

.tabs h1 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.tab-links {
  display: flex;
  gap: 20px;
}

.tab {
  color: #888;
  cursor: pointer;
  text-decoration: none;
}

.tab.active {
  color: #3b82f6;
  font-weight: bold;
  border-bottom: 2px solid #3b82f6;
  padding-bottom: 2px;
}

/* Formulário */
.form-container {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 1.5rem;
  background-color: #fff;
}

.form-container h2 {
  margin-bottom: 1.5rem;
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
}

.row {
  display: grid;
  column-gap: 1.5rem;
  row-gap: 1.2rem;
  margin-bottom: 1.5rem;
}

.row.cols-3 {
  grid-template-columns: 1fr 2fr 1fr;
}

.row.cols-2 {
  grid-template-columns: 1fr 1fr;
}

.field label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
}

.field input {
  display: block;
  width: 100%;
  padding: 0.5rem;
  font: inherit;
  color: #111;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.field input::placeholder {
  color: #9ca3af;
}

/* Botões */
.actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1.5rem;
}

.left-actions {
  display: flex;
  gap: 1rem;
}

button {
  font-size: 0.875rem;
  padding: 0.5rem 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  cursor: pointer;
}

.left-actions button {
  background: #fff;
  color: #374151;
}

.save-button {
  background: #10b981;
  color: #fff;
  border-color: #10b981;
}

.save-button:hover {
  background: #0f766e;
}

.left-actions button:hover {
  background: #f3f4f6;
}

/* Responsivo */
@media (max-width: 768px) {

  .row.cols-3,
  .row.cols-2 {
    grid-template-columns: 1fr !important;
  }

  .actions {
    flex-direction: column;
    align-items: flex-start;
  }

  .left-actions {
    margin-bottom: 1rem;
  }

  .save-button {
    align-self: flex-end;
  }
}
</style>

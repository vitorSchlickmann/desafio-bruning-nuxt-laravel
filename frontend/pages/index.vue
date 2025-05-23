<template>
  <div class="container">
    <!-- Caixa com título e abas -->
    <div class="tabs">
      <h1>Colaboradores da Bruning</h1>
      <div class="tab-links">
        <span class="tab">Lista</span>
        <span class="tab active">Cadastro</span>
      </div>
    </div>

    <!-- Formulário -->
    <div class="form-container">
      <h2>Formulário de Cadastro</h2>
      <form @submit.prevent="salvar">
        <!-- Linha 1 -->
        <div class="row cols-3">
          <div class="field">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" v-model="form.codigo" />
          </div>
          <div class="field">
            <label for="nomeCompleto">Nome completo</label>
            <input type="text" id="nomeCompleto" v-model="form.nomeCompleto" />
          </div>
          <div class="field">
            <label for="apelido">Apelido</label>
            <input type="text" id="apelido" v-model="form.apelido" />
          </div>
        </div>

        <!-- Linha 2 -->
        <div class="row cols-2">
          <div class="field">
            <label for="nomePai">Nome do pai / mãe</label>
            <input type="text" id="nomePai" v-model="form.nomePai" />
          </div>
          <div class="field">
            <label for="nomeMae">Nome do pai / mãe</label>
            <input type="text" id="nomeMae" v-model="form.nomeMae" />
          </div>
        </div>

        <!-- Linha 3 -->
        <div class="row cols-3">
          <div class="field">
            <label for="cpf">CPF</label>
            <ClientOnly>
              <input v-imask="{mask: '000.000.000-00'}" type="text" id="cpf" v-model="form.cpf" placeholder="___.___.___-__" />
              </ClientOnly>
          </div>
          <div class="field">
            <label for="dataNascimento">Data de nascimento</label>
            <ClientOnly>
              <input v-mask="{mask: '00/00/0000'}" type="text" id="dataNascimento" v-model="form.dataNascimento"
                placeholder="__/__/____" />
                </ClientOnly>
          </div>
          <div class="field">
            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" v-model="form.cargo" />
          </div>
        </div>

        <!-- Botões -->
        <div class="actions">
          <div class="left-actions">
            <button type="button" @click="voltar">Voltar</button>
            <button type="reset" @click="limpar">Limpar</button>
          </div>
          <button type="submit" class="save-button">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

const form = reactive({
  codigo: '',
  nomeCompleto: '',
  apelido: '',
  nomePai: '',
  nomeMae: '',
  cpf: '',
  dataNascimento: '',
  cargo: ''
})

function voltar() {
  console.log('Voltar clicado')
}

function limpar() {
  Object.keys(form).forEach(key => form[key] = '')
}

function salvar() {
  console.log('Dados salvos:', form)
}
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

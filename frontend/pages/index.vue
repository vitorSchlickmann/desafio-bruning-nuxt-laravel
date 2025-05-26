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
      <form @submit.prevent="submitForm">
        <!-- Linha 1 -->
        <div class="row cols-3">
          <div class="field">
            <label for="codigo">Código</label>
            <input class="nao-clicavel" type="text" id="codigo" v-model="colaborador.codigo"
              :disabled="camposDesabilitados" readonly />
          </div>
          <div class="field">
            <label for="nomeCompleto">Nome completo <span class="obrigatorio">*</span></label>
            <input type="text" id="nome_completo" v-model="colaborador.nome_completo" :disabled="camposDesabilitados" />
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
            <input type="text" id="nome_pai" v-model="colaborador.nome_pai" :disabled="camposDesabilitados" />
          </div>
          <div class="field">
            <label for="nomeMae">Nome do mãe</label>
            <input type="text" id="nome_mae" v-model="colaborador.nome_mae" :disabled="camposDesabilitados" />
          </div>
        </div>

        <!-- Linha 3 -->
        <div class="row cols-3">
          <div class="field">
            <label for="cpf">CPF <span class="obrigatorio">*</span></label>
            <ClientOnly>
              <input v-imask="{ mask: '000.000.000-00' }" type="text" id="cpf" v-model="colaborador.cpf"
                placeholder="___.___.___-__" :disabled="camposDesabilitados"
                @blur="$event.target.dispatchEvent(new Event('input'))" @keydown.enter.prevent
                @change="$event.target.dispatchEvent(new Event('input'))" />
            </ClientOnly>
          </div>
          <div class="field">
            <label for="dataNascimento">Data de nascimento <span class="obrigatorio">*</span></label>
            <ClientOnly>
              <input v-model="colaborador.data_nascimento" type="date" id="data_nascimento"
                :disabled="camposDesabilitados" />
            </ClientOnly>
          </div>
          <div class="field">
            <label for="cargo">Cargo <span class="obrigatorio">*</span></label>
            <input type="text" id="cargo" v-model="colaborador.cargo" :disabled="camposDesabilitados" />
          </div>
        </div>

        <!-- Botões -->
        <div class="actions">
          <div class="left-actions">
            <button type="button" @click="voltarParaLista">Voltar</button>
            <button v-if="modo === 'novo'" @click="limparFormulario" type="button">Limpar</button>
          </div>
          <button v-if="modo !== 'ver'" type="submit" class="save-button">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast de sucesso -->
  <div id="mensagem-sucesso" class="mensagem-sucesso oculta"></div>

  <!-- Toast de erro -->
  <div id="mensagem-erro" class="mensagem-erro oculta"></div>


</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const modo = ref(route.query?.modo ?? 'novo'); // 'novo', 'editar', 'ver'
const id = ref(route.query.id ?? null);

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
});

const voltarParaLista = () => {
  router.push('/lista')
};


const salvarColaborador = async () => {
  const camposObrigatorios = [
    { campo: 'nome_completo', label: 'Nome completo' },
    { campo: 'data_nascimento', label: 'Data de nascimento' },
    { campo: 'cpf', label: 'CPF' },
    { campo: 'cargo', label: 'Cargo' }
  ];

  const faltando = camposObrigatorios
    .filter(({ campo }) => !colaborador.value[campo] || colaborador.value[campo].toString().trim() === '')
    .map(({ label }) => label);

  if (faltando.length > 0) {
    const mensagem = 'Preencha os campos obrigatórios: ' + faltando.join(', ');
    mostrarMensagemErro(mensagem);
    return;
  }

  try {
    colaborador.value.cpf = colaborador.value.cpf.replace(/\D/g, '');

    if (colaborador.value.data_nascimento.includes('/')) {
      const [dia, mes, ano] = colaborador.value.data_nascimento.split('/');
      if (dia && mes && ano) {
        colaborador.value.data_nascimento = `${ano}-${mes}-${dia}`;
      }
    }



    console.log('📤 Dados enviados para API:', colaborador.value);

    const url = `http://localhost:8000/api/colaboradores${modo.value === 'editar' ? `/${colaborador.value.codigo}` : ''}`;
    const response = await fetch(url, {
      method: modo.value === 'editar' ? 'PUT' : 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(colaborador.value)
    });

    const text = await response.text();
    console.log('📥 Resposta crua da API:', text);

    let result;
    try {
      result = JSON.parse(text);
    } catch (e) {
      console.error('❌ Erro ao converter resposta para JSON:', e);
      mostrarMensagemErro('Erro inesperado: resposta inválida do servidor.');
      return;
    }

    if (!response.ok) {
      const cpfErro = 'CPF já cadastrado. Revise os dados';
      if (cpfErro) {
        mostrarMensagemErro(cpfErro);
      } else {
        mostrarMensagemErro('Erro ao cadastrar colaborador. Verifique os dados e tente novamente.');
      }
      return;
    }

    mostrarMensagemSucesso('Colaborador cadastrado com sucesso!');
    setTimeout(() => router.push('/lista'), 500);

  } catch (erro) {
    console.error('❌ Erro inesperado ao salvar colaborador:', erro);
    mostrarMensagemErro('Erro inesperado ao cadastrar colaborador.');
  }
};


const atualizarColaborador = async (codigo) => {
  if (!codigo) {
    mostrarMensagemErro('Código inválido para atualização.');
    return;
  }

  if (
    colaborador.value.data_nascimento &&
    colaborador.value.data_nascimento.includes('/')
  ) {
    const [dia, mes, ano] = colaborador.value.data_nascimento.split('/');
    const dataValida = new Date(`${ano}-${mes}-${dia}`);

    if (!isNaN(dataValida)) {
      colaborador.value.data_nascimento = dataValida.toISOString().slice(0, 10);
    } else {
      mostrarMensagemErro('Data de nascimento inválida.');
      return;
    }
  }


  try {
    const response = await fetch(`http://localhost:8000/api/colaboradores/${codigo}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(colaborador.value)
    });

    const result = await response.json();
    console.log('🔍 Resposta do Laravel:', result);

    if (!response.ok) {
      if (result?.errors?.cpf?.[0]) {
        mostrarMensagemErro(result.errors.cpf[0]);
      } else {
        mostrarMensagemErro('Erro ao atualizar colaborador.');
      }
      return;
    }

    mostrarMensagemSucesso('Colaborador atualizado com sucesso!');
    setTimeout(() => router.push('/lista'), 1500);

  } catch (erro) {
    console.error('❌ Erro inesperado:', erro);
    mostrarMensagemErro('Erro de conexão ao atualizar colaborador.');
  }
};

onMounted(async () => {
  if ((modo.value === 'editar' || modo.value === 'ver') && id.value) {
    try {
      const response = await fetch(`http://localhost:8000/api/colaboradores/${id.value}`);
      const data = await response.json();

      console.log('🟢 Dados recebidos do back-end:', data);
      const converterDataParaDateInput = (dataBR) => {
        if (!dataBR) return ''
        const [dia, mes, ano] = dataBR.split('/')
        return `${ano}-${mes}-${dia}`
      }


      colaborador.value = {
        ...data,
        data_nascimento: converterDataParaDateInput(data.data_nascimento)
      }

      camposDesabilitados.value = modo.value === 'ver';
    } catch (e) {
      console.error('Erro ao carregar colaborador para edição:', e)
    }
  } else {
    try {
      const res = await fetch('http://localhost:8000/api/colaboradores/proximo-codigo');
      const { proximo_codigo } = await res.json();

      colaborador.value.codigo = proximo_codigo;
    } catch (e) {
      colaborador.value.codigo = 1;
    }
  }
});


const submitForm = () => {
  console.log('Modo:', modo.value)
  console.log('ID:', colaborador.value.id)

  if (modo.value === 'editar') {
    atualizarColaborador(colaborador.value.id)
  } else {
    salvarColaborador()
  }
}

const formatarDataParaISO = (dataBR) => {
  if (!dataBR) return ''
  const [dia, mes, ano] = dataBR.split('/')
  return `${ano}-${mes}-${dia}`
}


const mostrarMensagemSucesso = (mensagem = 'Operação realizada com sucesso.') => {
  const el = document.getElementById('mensagem-sucesso');
  if (!el) return;

  el.innerText = mensagem;
  el.classList.remove('oculta');
  setTimeout(() => el.classList.add('oculta'), 3000);
};


const mostrarMensagemErro = (mensagem) => {
  const el = document.getElementById('mensagem-erro');
  if (!el) return;

  el.innerText = String(mensagem);
  el.classList.remove('oculta');
  setTimeout(() => el.classList.add('oculta'), 4000);
};


const limparFormulario = () => {
  const codigoAtual = colaborador.value.codigo

  Object.assign(colaborador.value, {
    nome_completo: '',
    apelido: '',
    nome_pai: '',
    nome_mae: '',
    cpf: '',
    data_nascimento: '',
    cargo: ''
  })

  colaborador.value.codigo = codigoAtual
}


</script>

<style scoped>
* {
  font-family: 'Inter', sans-serif;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

.obrigatorio {
  color: #e53e3e;
  font-weight: bold;
}

.nao-clicavel {
  pointer-events: none;
  background-color: #f9fafb;
  /* mantém o fundo claro */
  color: black;
  cursor: default;
}

.container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 0 24px;
  color: #1f2937;
}

input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
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

.mensagem-sucesso,
.mensagem-erro {
  position: fixed;
  bottom: 20px;
  left: 20px;
  padding: 12px 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  font-size: 14px;
  opacity: 1;
  transition: opacity 0.4s ease-in-out;
  z-index: 9999;
}

.mensagem-sucesso {
  background-color: #38a169;
  /* verde */
  color: white;
}

.mensagem-erro {
  background-color: #e53e3e;
  /* vermelho */
  color: white;
}

.oculta {
  opacity: 0;
  pointer-events: none;
}
</style>

<template>
    <div class="container">
        <div class="tabs">
            <h1>Colaboradores da Bruning</h1>
            <div class="tab-links">
                <NuxtLink to="/lista" class="tab" :class="{ active: $route.path === '/lista' }">Lista</NuxtLink>
                <NuxtLink to="/" class="tab" :class="{ active: $route.path === '/' }">Cadastro</NuxtLink>
            </div>
        </div>

        <div class="caixa-lista">
            <h3 class="subtitulo">Lista de Colaboradores</h3>

            <ul class="lista">
                <li v-for="colaborador in colaboradores" :key="colaborador.codigo" class="item">
                    <div class="item-conteudo">
                        <div>
                            <p class="nome"><strong>{{ colaborador.codigo }} - {{ colaborador.nome_completo }}</strong></p>
                            <p class="nascimento">Nascimento: <strong>{{ colaborador.data_nascimento }}</strong></p>
                        </div>
                        <div class="acoes">
                            <NuxtLink class="visualizar" :to="{ path: '/', query: { modo: 'editar', id: colaborador.id }}">Visualizar</NuxtLink>
                            <NuxtLink class="editar" :to="{ path: '/', query: { modo: 'editar', id: colaborador.id }}">Editar</NuxtLink>
                            <button @click="excluirColaborador(colaborador.id)" class="excluir">Excluir</button>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'

const colaboradores = ref([]);

const carregarColaboradores = async () => {
  try {
    const response = await fetch('http://localhost:8000/api/colaboradores')

    if (!response.ok) {
      throw new Error('Erro ao buscar colaboradores')
    }

    const data = await response.json()

    console.log('Recebido da API:', data) // 👈 veja no console se há erro na estrutura

    colaboradores.value = data
  } catch (erro) {
    console.error('Erro ao carregar colaboradores:', erro)
    alert('Erro ao carregar colaboradores')
  }
}

onMounted(() => {
  carregarColaboradores()
})

const excluirColaborador = async (codigo) => {
  const confirmarExclusao = confirm(`Deseja realmente excluir o colaborador ${codigo}?`)
  if (!confirmarExclusao) return

  try {
    const response = await fetch(`http://localhost:8000/api/colaboradores/${codigo}`, {
      method: 'DELETE'
    })

    if (!response.ok) {
      alert('Erro ao excluir colaborador')
      return
    }

    // ✅ Ajustado: remover usando ID ou código conforme o seu backend
    colaboradores.value = colaboradores.value.filter(c => c.id != codigo)

  } catch (erro) {
    console.error('Erro ao excluir:', erro)
    alert('Erro de conexão ao excluir o colaborador.')
  }
}


</script>

<style scoped>
.container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 24px;
    color: #1f2937;
}

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

.link {
    text-decoration: none;
    color: #888;
}

.link.ativo {
    color: #3b82f6;
    border-bottom: 2px solid #3b82f6;
}

.caixa-lista {
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 24px;
    border-radius: 6px;
}

.subtitulo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
}

.lista {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.item {
    border: 1px solid #ccc;
    padding: 4px 12px;
    border-radius: 4px;
}

.item-conteudo {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.acoes {
    display: flex;
    gap: 8px;
}

.visualizar {
    padding: 8px 17px;
    border: 1px solid #6c757d;
    ;
    background-color: white;
    color: #6c757d;
    ;
    font-weight: bold;
    border-radius: 4px;
    margin-right: 8px;
    text-decoration: none;
    font-size: 15px;
    cursor: pointer;
    opacity: 0.6;
}


.editar {
    padding: 8px 17px;
    border: 1px solid #007bff;
    background-color: white;
    color: #007bff;
    font-weight: bold;
    border-radius: 4px;
    margin-right: 8px;
    text-decoration: none;
    font-size: 15px;
    cursor: pointer;
    opacity: 0.6;
}

.excluir {
    padding: 8px 17px;
    border: 1px solid #dc3540;
    background-color: white;
    color: #dc3545;
    border-radius: 4px;
    font-weight: bold;
    text-decoration: none;
    font-size: 15px;
    cursor: pointer;
    opacity: 0.6;
}

.visualizar:hover {
    border: 2px solid #6c757d;
}

.editar:hover {
    border: 2px solid #007bff;
}

.excluir:hover {
    border: 2px solid #dc3540;
}
</style>

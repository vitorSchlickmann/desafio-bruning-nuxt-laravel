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
          <p class="nome"><strong>{{ colaborador.codigo }} - {{ colaborador.nome }}</strong></p>
          <p class="nascimento">Nascimento: <strong>{{ colaborador.nascimento }}</strong></p>
          <div class="acoes">
            <button class="editar">Editar</button>
            <button class="excluir">Excluir</button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
const colaboradores = [
  { codigo: 999, nome: 'Richard Pereira Cardoso', nascimento: '01/01/1990' },
  { codigo: 888, nome: 'Richard Pereira Cardoso', nascimento: '01/01/1990' },
  { codigo: 777, nome: 'Richard Pereira Cardoso', nascimento: '01/01/1990' },
  { codigo: 666, nome: 'Richard Pereira Cardoso', nascimento: '01/01/1990' }
]
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
  font-size: 16px;
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
  padding: 16px;
  border-radius: 4px;
}

.acoes {
  margin-top: 8px;
}

.editar {
  padding: 6px 12px;
  border: 1px solid #007bff;
  background-color: white;
  color: #007bff;
  border-radius: 4px;
  margin-right: 8px;
  cursor: pointer;
}

.excluir {
  padding: 6px 12px;
  border: 1px solid #dc3545;
  background-color: white;
  color: #dc3545;
  border-radius: 4px;
  cursor: pointer;
}
</style>

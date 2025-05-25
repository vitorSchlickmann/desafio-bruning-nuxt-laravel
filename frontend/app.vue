<template>
  <div class="layout">
    <header class="header">
      <!-- <h2 class="header-title">Bruning Sistemas</h2> -->
       <img class="img-logo" src="./public/logo_bruning-1.png" alt="">
    </header>

    <main class="content">
      <NuxtPage />
    </main>
  </div>
</template>

<style scoped>
* {
  font-family: 'Inter', sans-serif;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

.img-logo {
  width: 180px;
}

.layout {
  background-color: #f9fafb; 
}

.header {
  background-color: #ffffff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 1rem 2rem;
}

.header-title {
  font-size: 1.25rem;
  font-weight: bold;
  color: #10b981; 
}

.content {
  padding: 1.5rem;
}
</style>

# 📋 Sistema de Gerenciamento de Colaboradores

Este projeto foi desenvolvido como parte de um desafio técnico. Ele consiste em um sistema completo de cadastro, edição, visualização, listagem e exclusão de colaboradores, utilizando **Laravel (PHP)** no back-end e **Nuxt 3 (Vue.js)** no front-end.

## 🚀 Tecnologias Utilizadas

### 🔧 Back-end:
- Laragon 2025 v8.1.0 (Ferramenta que engloba Apache, MySQL e Composer) 
    - Download: https://github.com/leokhoa/laragon/releases/download/8.1.0/laragon-wamp.exe
- PHP 8.3.16 
- Laravel Framework 12.15.0
- API RESTful com validações, tratamento de erros e controle de CORS
- Banco de dados MySQL 8.4.3

### 🎨 Front-end:
- Nuxt 3.17.4 (Vue 3)
- Css Vanilla
- Vue-Imask (para máscaras de CPF)
- Toasts personalizados para mensagens de sucesso e erro

---

## 📁 Estrutura do Projeto

```
├── backend/          # Projeto Laravel (API)
├── frontend/         # Projeto Nuxt (Vue)
├── README.md         # Instruções do projeto
```

## ⚙️ Como executar o projeto

### 🐙 Back-end (Laravel com MySql)

> Acessar a pasta desafio-bruning
- executar cd backend

> 1 - Instale as dependencias
- composer install - (Em torno de 15 minutos pra instalar todas as depêndencias).
- cp .env.example .env - (Cria o arquivo .env para obter as configurações do projeto).
- php artisan key:generate - (Cria uma APP_KEY no .env, usada para encriptação e sessões seguras).
- php artisan migrate - (Cria todas as tabelas necessárias no banco).

> 2 - Execute o servidor
- php artisan serve

> A API estará disponível em: `http://localhost:8000


###  Front-end (Nuxt 3)

> Acesse a pasta frontend
- cd frontend 

> Instale as depedências 
- npm install

> Inicie o servidor de desenvolvimento.
- npm run dev

> O projeto estará rodando no navegador em `localhost:3000

## 📌 Funcionalidades

- ✅ Cadastro de colaboradores
- ✅ Edição de colaboradores existentes
- ✅ Visualização (modo somente leitura)
- ✅ Exclusão com confirmação modal
- ✅ Máscara no CPF
- ✅ Validação de campos obrigatórios
- ✅ Toasts de sucesso e erro
- ✅ Responsividade mobile

---

# Autor

Desenvolvido por Vitor Schlickmann Luciano como parte de um desafio técnico.

# Dica extra, para testes rápidos, use o Postman para consumir o endpoint do projeto.
- http://localhost:8000/api/colaboradores

# Sistema de Transações

Este projeto consiste em uma API em Laravel 10 e um frontend em Vue.js (Vite) para gerenciar clientes, transações de crédito e débito, com autenticação de administrador usando Sanctum.

## Backend (API Laravel)

### Pré-requisitos
- PHP 8.4 ou superior
- Composer
- MySQL ou outro banco compatível

### Instalação
1. Entre na pasta do backend:
```bash
cd transactions-api
```
2. Instale dependências:
```bash
composer install
```
3. Configure o `.env` com suas credenciais de banco:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=transactions
DB_USERNAME=root
DB_PASSWORD=secret
```
4. Gere a chave da aplicação:
```bash
php artisan key:generate
```
5. Rode migrations e seeders:
```bash
php artisan migrate --seed
```
> O seeder cria um usuário administrador inicial (`admin@example.com` / `password123`) e as roles `admin` e `client`.

### Executando a API
```bash
php artisan serve
```
A API estará disponível em `http://localhost:8000`.

### Endpoints Principais
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| POST | /api/login | Autenticar admin, retorna token |
| POST | /api/logout | Logout admin (Bearer token) |
| GET  | /api/me | Retorna dados do admin autenticado |
| POST | /api/client | Registrar novo cliente |
| GET  | /api/clients | Listar todos os clientes |
| GET  | /api/clients/{id} | Detalhes do cliente + histórico + saldo |
| POST | /api/clients/{id}/transactions | Registrar crédito/débito |

> Todas as rotas de clientes e transações requerem autenticação Bearer token.

## Frontend (Vue.js + Vite)

### Pré-requisitos
- Node.js 18+ (ou superior)
- npm ou yarn

### Instalação
1. Entre na pasta do frontend:
```bash
cd transactions-frontend
```
2. Instale dependências:
```bash
npm install
```
3. Configure variáveis de ambiente em `.env`:
```dotenv
VITE_API_URL=http://localhost:8000/api
```

### Executando o Frontend
```bash
npm run dev
```
O app estará disponível em `http://localhost:5173`.

### Funcionalidades
- Login do administrador
- Listagem de clientes
- Detalhes do cliente
- Registro de crédito e débito
- Histórico de transações
- Logout

## Testes Backend
Para rodar os testes automatizados:
```bash
php artisan test
```

Todos os testes de autenticação, clientes e transações estão inclusos.
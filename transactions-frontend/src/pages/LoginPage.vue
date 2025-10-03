<template>
  <div class="login-page">
    <h1>Login do Administrador</h1>

    <form @submit.prevent="handleLogin" class="login-form">
      <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="email" placeholder="admin@example.com" required />
      </div>

      <div class="form-group">
        <label for="password">Senha:</label>
        <input id="password" type="password" v-model="password" placeholder="Digite sua senha" required />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? "Entrando..." : "Login" }}
      </button>

      <p v-if="error" class="error">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";
import api from "../services/api";

const email = ref("");
const password = ref("");
const error = ref("");
const loading = ref(false);

const router = useRouter();
const auth = useAuthStore();

const handleLogin = async () => {
  error.value = "";
  loading.value = true;

  try {
    const res = await api.post("/login", {
      email: email.value,
      password: password.value,
    });

    // Armazena o token no Pinia/localStorage
    auth.setToken(res.data.token);

    // Redireciona para a página de clientes
    router.push("/clients");
  } catch (e) {
    if (e.response?.status === 401) {
      error.value = "Credenciais inválidas.";
    } else if (e.response?.status === 403) {
      error.value = "Acesso negado. Apenas administradores podem logar.";
    } else {
      error.value = "Erro no login. Tente novamente.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.login-page {
  max-width: 400px;
  margin: 5em auto;
  padding: 2em;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 0 10px #ccc;
  text-align: center;
  background-color: #f9f9f9;
}

.login-form .form-group {
  margin-bottom: 1em;
  text-align: left;
}

.login-form label {
  display: block;
  margin-bottom: 0.3em;
  font-weight: bold;
}

.login-form input {
  width: 100%;
  padding: 0.5em;
  box-sizing: border-box;
}

.login-form button {
  width: 100%;
  padding: 0.7em;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}

.login-form button:disabled {
  background-color: #a5d6a7;
  cursor: not-allowed;
}

.error {
  color: red;
  margin-top: 1em;
}
</style>

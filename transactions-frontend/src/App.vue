<template>
  <div id="app">
    <header v-if="auth.token" class="app-header">
      <span>Bem-vindo, {{ auth.user?.name }}</span>
      <button @click="handleLogout">Logout</button>
    </header>

    <router-view />
  </div>
</template>

<script setup>
import { useAuthStore } from "./stores/auth";
import { useRouter } from "vue-router";

const auth = useAuthStore();
const router = useRouter();

const handleLogout = () => {
  auth.logout();
  router.push("/login");
};
</script>

<style>
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1em;
  background-color: #42b983;
  color: white;
}

button {
  background: white;
  color: #42b983;
  border: none;
  padding: 0.5em 1em;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #e0e0e0;
}
</style>

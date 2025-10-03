<template>
  <div class="clients-page">
    <h1>Clientes</h1>

    <div class="clients-grid">
      <div v-for="client in clients" :key="client.id" class="client-card">
        <h2>{{ client.name }}</h2>
        <p>{{ client.email }}</p>
        <router-link :to="`/clients/${client.id}`" class="details-btn">Ver Detalhes</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../services/api";

const clients = ref([]);

const fetchClients = async () => {
  try {
    const res = await api.get("/clients");
    clients.value = res.data;
  } catch (e) {
    alert("Erro ao carregar clientes");
  }
};

onMounted(fetchClients);
</script>

<style scoped>
.clients-page {
  max-width: 900px;
  margin: 2em auto;
  padding: 0 1em;
}

h1 {
  text-align: center;
  margin-bottom: 2em;
}

.clients-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 1.5em;
}

.client-card {
  background: #fff;
  padding: 1em;
  border-radius: 8px;
  box-shadow: 0 0 10px #ccc;
  transition: transform 0.2s, box-shadow 0.2s;
}

.client-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 20px #bbb;
}

.client-card h2 {
  margin: 0 0 0.5em 0;
  font-size: 1.2em;
}

.client-card p {
  margin: 0 0 1em 0;
  color: #555;
}

.details-btn {
  display: inline-block;
  padding: 0.5em 1em;
  background-color: #42b983;
  color: white;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s;
}

.details-btn:hover {
  background-color: #36966d;
}
</style>

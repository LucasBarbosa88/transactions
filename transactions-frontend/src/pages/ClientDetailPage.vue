<template>
  <div class="client-detail">
    <h1>{{ client.name }}</h1>
    <p>Email: {{ client.email }}</p>
    <p>Saldo atual: R$ {{ Number(balance).toFixed(2) }}</p>

    <transaction-form @transaction-created="fetchClient"></transaction-form>

    <ul>
      <li v-for="t in transactions" :key="t.id">
        {{ t.type === 'credit' ? 'Crédito' : 'Débito' }}: R$ {{ Number(t.amount).toFixed(2) }} -
        {{ new Date(t.created_at).toLocaleString() }}
      </li>
    </ul>

  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../services/api";
import TransactionForm from "../components/TransactionForm.vue";

const route = useRoute();
const client = ref({});
const transactions = ref([]);
const balance = ref(0);

const fetchClient = async () => {
  try {
    const res = await api.get(`/clients/${route.params.id}`);
    client.value = res.data.user;
    transactions.value = res.data.transactions;
    balance.value = res.data.balance;
  } catch (e) {
    alert(e.response?.data?.message || "Erro ao carregar cliente");
  }
};

onMounted(fetchClient);
</script>

<style scoped>
.client-detail {
  max-width: 600px;
  margin: 2em auto;
  padding: 1em;
  background-color: #fff;
  border-radius: 6px;
  box-shadow: 0 0 10px #ccc;
}

h1 {
  margin-bottom: 0.5em;
}

h2 {
  margin-top: 2em;
  margin-bottom: 0.5em;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  padding: 0.5em 0;
  border-bottom: 1px solid #eee;
}
</style>

<template>
  <form @submit.prevent="submit" class="transaction-form">
    <div class="form-group">
      <label for="type">Tipo:</label>
      <select id="type" v-model="type">
        <option value="credit">Crédito</option>
        <option value="debit">Débito</option>
      </select>
    </div>

    <div class="form-group">
      <label for="amount">Valor:</label>
      <input id="amount" type="number" v-model.number="amount" placeholder="Digite o valor" step="0.01" min="0.01"
        required />
    </div>

    <button type="submit" :disabled="loading">
      {{ loading ? "Processando..." : "Registrar" }}
    </button>

    <p v-if="error" class="error">{{ error }}</p>
  </form>
</template>

<script setup>
import { ref } from "vue";
import { useRoute } from "vue-router";
import api from "../services/api";

const route = useRoute();
const type = ref("credit");
const amount = ref(0);
const loading = ref(false);
const error = ref("");
const emit = defineEmits(["transaction-created"]);

const submit = async () => {
  error.value = "";
  loading.value = true;

  try {
    if (!type.value || amount.value <= 0) {
      error.value = "Preencha corretamente tipo e valor.";
      return;
    }

    await api.post(`/clients/${route.params.id}/transactions`, {
      type: type.value,
      amount: amount.value
    });

    // limpa o formulário
    type.value = "credit";
    amount.value = 0;

    // notifica o parent para atualizar saldo e histórico
    emit("transaction-created");
  } catch (e) {
    error.value = e.response?.data?.message || "Erro ao registrar transação";
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.transaction-form {
  margin-top: 2em;
  border: 1px solid #ccc;
  padding: 1em;
  border-radius: 6px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 1em;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.3em;
}

input,
select {
  width: 100%;
  padding: 0.5em;
  box-sizing: border-box;
}

button {
  width: 100%;
  padding: 0.7em;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}

button:disabled {
  background-color: #a5d6a7;
  cursor: not-allowed;
}

.error {
  color: red;
  margin-top: 0.5em;
}
</style>

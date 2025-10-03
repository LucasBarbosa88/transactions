<template>
  <form @submit.prevent="login">
    <input v-model="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Senha" />
    <button type="submit">Login</button>
  </form>
</template>

<script>
import api from "../services/api";
import { useAuthStore } from "../stores/auth";
import { useRouter } from "vue-router";

export default {
  data() {
    return { email: "", password: "" };
  },
  setup() {
    const auth = useAuthStore();
    const router = useRouter();
    const login = async () => {
      try {
        const res = await api.post("/login", {
          email: this.email,
          password: this.password
        });
        auth.setToken(res.data.token);
        router.push("/clients");
      } catch (e) {
        alert("Erro no login");
      }
    };
    return { login };
  }
};
</script>

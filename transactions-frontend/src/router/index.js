import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/LoginPage.vue";
import ClientsPage from "../pages/ClientsPage.vue";
import ClientDetailPage from "../pages/ClientDetailPage.vue";
import { useAuthStore } from "../stores/auth";

const routes = [
  { path: "/", redirect: "/login" },        // raiz redireciona para login
  { path: "/login", component: LoginPage }, // rota pública
  { path: "/clients", component: ClientsPage }, 
  { path: "/clients/:id", component: ClientDetailPage } 
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Guard global
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();

  // rotas que não precisam de autenticação
  const publicPages = ["/login"];
  const authRequired = !publicPages.includes(to.path);

  if (authRequired && !auth.token) {
    next("/login"); // redireciona para login se não logado
  } else {
    next(); // permite acesso
  }
});

export default router;

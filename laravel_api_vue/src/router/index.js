import { useAuthStore } from "@/stores/auth";
import ForgotPasswordView from "@/views/Auth/ForgotPasswordView.vue";
import LoginView from "@/views/Auth/LoginView.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import HomeView from "@/views/HomeView.vue";
import CreateView from "@/views/Posts/CreateView.vue";
import ShowView from "@/views/Posts/ShowView.vue";
import UpdateView from "@/views/Posts/UpdateView.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
      meta: { guest: true },
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
      meta: { guest: true },
    },
    {
      path: "/forgot-password",
      name: "forgot-password",
      component: ForgotPasswordView,
      meta: { guest: true },
    },
    {
      path: "/create",
      name: "create",
      component: CreateView,
      meta: { auth: true },
    },
    {
      path: "/show/:id",
      name: "show",
      component: ShowView,
    },
    {
      path: "/update/:id",
      name: "update",
      component: UpdateView,
      meta: { auth: true },
    },
  ],
});

router.beforeEach(async (to, from) => {
  const authStore = useAuthStore();
  await authStore.getUser();

  if (authStore.user && to.meta.guest) {
    return { name: "home" };
  }

  if (!authStore.user && to.meta.auth) {
    return { name: "login" };
  }
});

export default router;

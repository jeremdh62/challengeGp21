import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
//import store from "../store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
      /*redirect:
        store.state.user.id == "" || store.state.user.token == ""
          ? "/login"
          : "",*/
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
    {
      path: "/article/:id",
      name: "article",
      component: () => import("../views/ArticleView.vue"),
    },
    {
      path: "/articles",
      name: "articles",
      component: () => import("../views/ArticlesView.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
    },
    {
      path: "/:pathMatch(.*)*",
      redirect: "/",
    },
  ],
});

export default router;

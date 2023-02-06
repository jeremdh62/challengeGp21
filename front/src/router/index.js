import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import DashboardView from "../views/Admin/DasboardView.vue";
import AdminArticlesView from "../views/Admin/AdminArticlesView.vue";
import AdminArticleEditView from "../views/Admin/AdminArticleEditView.vue";
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
      path: "/admin",
      name: "admin",
      component: DashboardView,
    },
    {
      path: "/admin/articles",
      name: "admin-articles",
      component: AdminArticlesView,
    },
    {
      path: "/admin/articles/:id",
      name: "admin-article-edit",
      component: AdminArticleEditView,
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

import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import DashboardView from "../views/Admin/DasboardView.vue";
import AdminArticlesView from "../views/Admin/AdminArticlesView.vue";
import AdminArticleEditView from "../views/Admin/AdminArticleEditView.vue";
import ForumsView from "../views/ForumsView.vue";
import ForumView from "../views/ForumView.vue";
import AdminForumsView from "../views/Admin/AdminForumsView.vue";
import AdminForumEditView from "../views/Admin/AdminForumEditView.vue";
import ForumEdit from "../views/ForumEditView.vue";
//import store from "../store";

// TODO: Login redirect
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
      path: "/admin/forums",
      name: "admin-forums",
      component: AdminForumsView,
    },
    {
      path: "/admin/forums/:id",
      name: "admin-forum-edit",
      component: AdminForumEditView,
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
      path: "/forum/:id",
      name: "forum",
      component: ForumView,
    },
    {
      path: "/forums",
      name: "forums",
      component: ForumsView,
    },
    {
      path: "/forums/edit/:id",
      name: "forum-edit",
      component: ForumEdit,
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

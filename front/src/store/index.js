import { createStore } from "vuex";
import axios from "axios";

const instance = axios.create({
  baseURL: "http://localhost:8000",
  headers: {
    accept: "application/json",
    "Content-Type": "application/json",
  },
});

let user = JSON.parse(localStorage.getItem("user"));
if (!user) {
  user = {
    id: "",
    token: "",
  };
} else {
  user = JSON.parse(user);
  try {
    instance.defaults.headers.common["Authorization"] = user.token;
  } catch (error) {
    user = {
      id: "",
      token: "",
    };
  }
}

const store = createStore({
  state: {
    status: "",
    user: user,
    userInfo: {},
    articles: [],
    forums: [],
    comments: [],
  },
  mutations: {
    setStatus: (state, status) => {
      state.status = status;
    },
    logUser: (state, user) => {
      state.user.id = user.id;
      state.user.token = user.token;
      instance.defaults.headers.common["Authorization"] = user.token;
      localStorage.setItem("user", JSON.stringify(user));
    },
    userInfo: (state, userInfo) => {
      state.userInfo = userInfo;
    },
    logout: (state) => {
      state.user.id = "";
      state.user.token = "";
      state.userInfo = {};
      localStorage.removeItem("user");
      delete instance.defaults.headers.common["Authorization"];
    },
    setArticles: (state, articles) => {
      state.articles = articles;
    },
    deleteArticle: (state, article) => {
      state.articles = state.articles.filter((a) => a.id !== article.id);
    },
    setForums: (state, forums) => {
      state.forums = forums;
    },
    deleteForum: (state, forum) => {
      state.forums = state.forums.filter((f) => f.id !== forum.id);
    },
    setComments: (state, comments) => {
      state.comments = comments;
    },
  },
  getters: {
    getStatus: (state) => {
      return state.status;
    },
    getUser: (state) => {
      return state.user;
    },
    getUserInfo: (state) => {
      return state.userInfo;
    },
    getArticles: (state) => {
      return state.articles;
    },
    getForums: (state) => {
      return state.forums;
    },
    getComments: (state) => {
      return state.comments;
    },
  },
  actions: {
    createAccount: ({ commit }, userInfo) => {
      commit("setStatus", "loading");
      return new Promise((resolve, reject) => {
        instance
          .post("/users", userInfo)
          .then((response) => {
            resolve(response);
            commit("setStatus", "createdAccount");
          })
          .catch((error) => {
            commit("setStatus", "errorCreatingAccount");
            reject(error);
          });
      });
    },
    login: ({ commit }, userInfo) => {
      commit("setStatus", "loading");
      return new Promise((resolve, reject) => {
        instance
          .post("/api/users/login", userInfo)
          .then((response) => {
            commit("setStatus", "loggedIn");
            commit("logUser", response.data);
            resolve(response);
          })
          .catch((error) => {
            commit("setStatus", "errorLoggingIn");
            reject(error);
          });
      });
    },
    getUserInfo: ({ commit }) => {
      return new Promise((resolve, reject) => {
        instance
          .get("/users/info/")
          .then((response) => {
            resolve(response);
            commit("userInfo", response.data);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getAllArticles: ({ commit }) => {
      return new Promise((resolve, reject) => {
        instance
          .get("/articles")
          .then((response) => {
            commit("setArticles", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateArticle: ({ commit }, article) => {
      return new Promise((resolve, reject) => {
        instance
          .put("/articles/" + article.id, article)
          .then((response) => {
            commit;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    createArticle: ({ commit }, article) => {
      return new Promise((resolve, reject) => {
        instance
          .post("/articles", article)
          .then((response) => {
            commit;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteArticle: ({ commit }, article) => {
      return new Promise((resolve, reject) => {
        instance
          .delete("/articles/" + article.id)
          .then((response) => {
            commit("deleteArticle", article);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getAllForums: ({ commit }) => {
      return new Promise((resolve, reject) => {
        instance
          .get("/forums")
          .then((response) => {
            commit("setForums", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getValidForums: ({ commit }) => {
      return new Promise((resolve, reject) => {
        instance
          .get("/forums?isValid=true")
          .then((response) => {
            commit("setForums", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    createForum: ({ commit }, forum) => {
      return new Promise((resolve, reject) => {
        instance
          .post("/forums", forum)
          .then((response) => {
            commit;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateForum: ({ commit }, forum) => {
      return new Promise((resolve, reject) => {
        instance
          .put("/forums/" + forum.id, forum)
          .then((response) => {
            commit("setForums", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteForum: ({ commit }, forum) => {
      return new Promise((resolve, reject) => {
        instance
          .delete("/forums/" + forum.id)
          .then((response) => {
            commit("deleteForum", response);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getAllComments: ({ commit }, forumId) => {
      return new Promise((resolve, reject) => {
        instance
          .get("/comments?forum=" + forumId)
          .then((response) => {
            commit("setComments", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    createComment: ({ commit }, comment) => {
      return new Promise((resolve, reject) => {
        instance
          .post("/comments", comment)
          .then((response) => {
            commit;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
  },
});

export default store;

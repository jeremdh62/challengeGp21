import { createStore } from "vuex";
import axios from "axios";

const instance = axios.create({
  baseURL: "http://localhost:8000",
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
  },
});

export default store;

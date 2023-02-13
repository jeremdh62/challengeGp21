import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

// vuetify
import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

// quill editor (Text Rich Editor)
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import "@vueup/vue-quill/dist/vue-quill.bubble.css";
import { QuillEditor } from "@vueup/vue-quill";

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);

app.use(router);

app.use(store);

app.use(vuetify);

app.component("QuillEditor", QuillEditor);

app.mount("#app");

<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-card class="mx-auto" max-width="500">
      <v-card-title class="text-h6 font-weight-regular justify-space-between">
        <span>Login</span>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="username"
          :rules="usernameRules"
          label="Username"
          required
        ></v-text-field>

        <v-text-field
          v-model="password"
          :rules="passwordRules"
          type="password"
          clearable
          label="Password"
          placeholder="Enter your password"
        ></v-text-field>
      </v-card-text>

      <v-btn color="primary" variant="plain" @click="navigateTo('register')">
        Create Account
      </v-btn>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="success" @click="validate"> Login </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import { mapState } from "vuex";

export default {
  data: () => ({
    mode: "login",
    valid: true,
    username: "",
    usernameRules: [(v) => !!v || "Username is required"],
    password: "",
    passwordRules: [(v) => !!v || "Password is required"],
  }),
  mounted() {
    if (this.$store.state.user.id != "") {
      this.$router.push({ name: "home" });
    }
  },

  computed: {
    ...mapState(["status"], ["user"]),
  },
  methods: {
    async validate() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.login();
      }
    },
    login() {
      this.$store
        .dispatch("login", {
          name: this.name,
          password: this.password,
        })
        .then(
          (response) => {
            console.log(response);
          },
          (error) => {
            console.log(error);
          }
        );
    },
    navigateTo(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>

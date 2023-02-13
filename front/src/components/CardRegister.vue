<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-card class="mx-auto" max-width="500">
      <v-card-title class="text-h6 font-weight-regular justify-space-between">
        <span>Create Account</span>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="username"
          :counter="10"
          :rules="usernameRules"
          label="Username"
          required
        ></v-text-field>

        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
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

        <v-checkbox
          v-model="checkbox"
          :rules="[(v) => !!v || 'You must agree to continue!']"
          label="Do you agree?"
          required
        ></v-checkbox>
      </v-card-text>

      <v-btn color="primary" variant="plain" @click="navigateTo('login')">
        Login
      </v-btn>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="success" @click="createAccount"> createAccount </v-btn>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import { mapState } from "vuex";

export default {
  data: () => ({
    valid: true,
    username: "",
    usernameRules: [
      (v) => !!v || "Username is required",
      (v) => (v && v.length <= 10) || "Userame must be less than 10 characters",
    ],
    password: "",
    passwordRules: [
      (v) => !!v || "Password is required",
      (v) => (v && v.length >= 8) || "Password must be equal or greater than 8",
    ],
    email: "",
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    checkbox: false,
  }),

  computed: {
    ...mapState(["status"]),
  },
  mounted() {
    if (this.$store.state.user.id != "") {
      this.$router.push({ name: "home" });
    }
  },
  methods: {
    async validate() {
      const { valid } = await this.$refs.form.validate();

      if (valid) {
        this.createAccount();
      }
    },
    createAccount() {
      // TODO: Register user
      this.$store
        .dispatch("createAccount", {
          username: this.username,
          email: this.email,
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

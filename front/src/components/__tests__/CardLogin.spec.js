import { describe, it, expect } from "vitest";
import store from "../../store";

import { mount } from "@vue/test-utils";
import CardLogin from "../CardLogin.vue";

describe("Login", () => {
  it("renders properly", () => {
    const wrapper = mount(CardLogin, {
      global: {
        plugins: [store],
      },
    });
    console.log(wrapper);
    expect(wrapper.text()).toContain("Login");
  });
});

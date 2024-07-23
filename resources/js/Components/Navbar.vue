<template>
  <fwb-navbar class="shadow-lg drop-shadow-lg" v-if="canLogin.is_admin">
    <template #logo>
      <div class="flex justify-center items-center">
        <i class="fa-solid fa-film text-white fa-2xl"></i>
      </div>
    </template>
    <template #default="{ isShowMenu }">
      <fwb-navbar-collapse :is-show-menu="isShowMenu">
        <fwb-navbar-link is-active link="/"> Home </fwb-navbar-link>
        <fwb-navbar-link is-active link="/admin"> Admin </fwb-navbar-link>
        <fwb-navbar-link is-active link="/admin/users"> Users </fwb-navbar-link>
        <fwb-navbar-link is-active link="/admin/movies">
          Movies
        </fwb-navbar-link>
        <fwb-navbar-link link="#" @click.prevent="logout" v-if="canLogin">
          Log out
        </fwb-navbar-link>
        <!-- logout form -->
        <form id="logout-form" action="/logout" method="POST" class="hidden">
          <input type="hidden" name="_token" :value="csrfToken" />
        </form>
      </fwb-navbar-collapse>
    </template>
    <!-- if user not auth show this -->
    <template #right-side v-if="!canLogin || !canRegister">
      <div class="flex justify-end gap-4">
        <a href="/login">
          <fwb-button> Login </fwb-button>
        </a>
        <a href="/register">
          <fwb-button outline> Register </fwb-button>
        </a>
      </div>
    </template>
  </fwb-navbar>

  <fwb-navbar class="shadow-lg drop-shadow-lg" v-else>
    <template #logo>
      <div class="flex justify-center items-center">
        <i class="fa-solid fa-film text-white fa-2xl"></i>
      </div>
    </template>
    <template #default="{ isShowMenu }">
      <fwb-navbar-collapse :is-show-menu="isShowMenu">
        <!-- route welcome -->
        <fwb-navbar-link is-active link="/"> Home </fwb-navbar-link>
        <fwb-navbar-link link="#" @click.prevent="logout" v-if="canLogin">
          Log out
        </fwb-navbar-link>
        <!-- logout form -->
        <form id="logout-form" action="/logout" method="POST" class="hidden">
          <input type="hidden" name="_token" :value="csrfToken" />
        </form>
      </fwb-navbar-collapse>
    </template>
    <!-- if user not auth show this -->
    <template #right-side v-if="!canLogin || !canRegister">
      <div class="flex justify-end gap-4">
        <a href="/login">
          <fwb-button> Login </fwb-button>
        </a>
        <a href="/register">
          <fwb-button outline> Register </fwb-button>
        </a>
      </div>
    </template>
  </fwb-navbar>
</template>

<script setup>
import {
  FwbButton,
  FwbNavbar,
  FwbNavbarCollapse,
  FwbNavbarLink,
  FwbNavbarLogo,
} from "flowbite-vue";

import { ref } from "vue";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

const csrfToken = ref(
  document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
);

const logout = () => {
  document.getElementById("logout-form").submit();
};
</script>

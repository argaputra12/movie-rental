<script setup>
import Navbar from "@/Components/Navbar.vue";
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

defineProps({
  userMovies: {
    type: Array,
    required: true,
  },
  canLogin: {
    type: Object,
  },
  canRegister: {
    type: Object,
  },
});
</script>

<template>
  <Navbar :can-login="canLogin" :can-register="canRegister" />
  <div>
    <div class="min-h-screen bg-gray-100">
      <!-- Page Heading -->
      <header v-if="$slots.header">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

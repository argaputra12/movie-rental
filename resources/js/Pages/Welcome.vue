<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import { FwbButton, FwbA, FwbCard } from "flowbite-vue";
import { defineProps } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

defineProps({
  movies: {
    type: Array,
    required: true,
  },
  canLogin: {
    type: Boolean,
    required: true,
  },
  canRegister: {
    type: Boolean,
    required: true,
  },
});

const urlMovie = (id) => {
  return "/movies/watch/" + id;
};

const mustLogin = () => {
  $toast.open("You have to login to watch the movie");

  setTimeout(() => {
    window.location.href = "/login";
  }, 2000);
};
</script>

<template>
  <Head title="Welcome" />

  <!-- Navbar here -->
  <Navbar :can-login="canLogin" :can-register="canRegister" />

  <!-- Movie display -->
  <div class="bg-gray-800">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
      <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center mb-16">
        <div>
          <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">Watch movies and TV shows</span>
            <span class="block text-indigo-600">anytime, anywhere</span>
          </h2>
        </div>

        <div class="w-full justify-between items-center gap-4">
          <div class="relative w-full h-96">
            <img
              src="https://i.ytimg.com/vi/XFqn3uy238E/maxresdefault.jpg"
              alt="movie"
              class="w-full h-full object-cover rounded-lg"
            />
          </div>
        </div>
      </div>

      <!-- Display movie list -->
      <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="movie in movies"
          :key="movie.id"
          class="relative bg-white p-4 rounded-lg shadow-lg h-80"
        >
          <img
            :src="movie.image_url"
            alt="movie"
            class="w-full h-48 object-cover rounded-lg mb-3"
            @error="handleImageError"
          />
          <h3 class="text-lg font-semibold">{{ movie.title }}</h3>
          <div class="absolute bottom-4 right-4">
            <a :href="urlMovie(movie.id)" v-if="canLogin">
              <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Watch Video
              </button>
            </a>
            <a v-else>
              <button
                class="bg-blue-500 text-white px-4 py-2 rounded"
                @click="mustLogin"
              >
                Watch Video
              </button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

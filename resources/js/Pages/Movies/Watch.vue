<script setup>
import { ref, onMounted, onUnmounted, watchEffect } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useTimer } from "vue-timer-hook";

const $toast = useToast();

const props = defineProps({
  movie: {
    type: Object,
  },
  userMovie: {
    type: Object,
  },
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

const remainingTime = ref(0);
const timer = ref(null);

const initializeTimer = () => {
  const time = new Date();
  time.setSeconds(time.getseconds() + props.userMovie.duration * 60);
  const timer = useTimer({
    endTime: time,
    onTimeOver: () => {
      $toast.open({
        message: "Time is up!",
        type: "error",
      });
    },
  });
};

onMounted(() => {
  initializeTimer();
  watchEffect(() => {
    if (timer.isExpired.value) {
      $toast.open({
        message: "Time is up!",
        type: "error",
      });
    }
  });
});
</script>

<template>
  <Head title="Watch Movie" />

  <!-- Navbar here -->
  <Navbar :can-login="canLogin" :can-register="canRegister" />

  <!-- Blocking display if user movie null -->
  <div
    v-if="userMovie === null || userMovie.status != 'approved'"
    class="bg-gray-800 absolute inset-0 bg-opacity-90 flex justify-center items-center"
  >
    <div class="bg-white w-1/2 mx-auto mt-20 p-8 rounded-lg">
      <h2 class="text-3xl font-extrabold text-gray-900">Request for movie</h2>
      <p class="text-gray-500 mt-4">
        You need to request this movie from the admin.
      </p>
      <div class="mt-8 flex justify-end gap-4">
        <FwbButton color="alternative" @click="goBack">Go back</FwbButton>
        <FwbButton color="default" @click="requestAccess(movie.id)"
          >Request access</FwbButton
        >
      </div>
    </div>
  </div>

  <!-- Movie display -->
  <div class="bg-gray-800">
    <div
      class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 min-h-screen"
    >
      <iframe
        :src="movie.video_url"
        frameborder="0"
        class="w-full h-[720px]"
      ></iframe>
    </div>
  </div>

  <!-- Timer Display -->
  <div
    v-if="remainingTime > 0"
    class="fixed bottom-0 right-0 m-4 bg-black text-white p-2 rounded-md"
  >
    Time Remaining: {{ Math.floor(remainingTime / 60000) }}m
    {{ Math.floor((remainingTime % 60000) / 1000) }}s
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useTimer } from "vue-timer-hook";
import axios from "axios";
import { FwbButton } from "flowbite-vue";
import Navbar from "@/Components/Navbar.vue";

const $toast = useToast();

const props = defineProps({
  movie: {
    type: Object,
  },
  userMovie: {
    type: Object,
  },
  canLogin: {
    type: Object,
  },
  canRegister: {
    type: Object,
  },
});

const remainingTime = ref(0);
const timer = ref(null);
let interval = null;

const sendUpdateRequest = async () => {
  try {
    const response = await axios.put(
      `/movies/update-duration/${props.userMovie.id}`,
      {
        duration: Math.ceil(remainingTime.value / 60000), // Convert milliseconds to minutes
      },
    );

    if (response.data.error) {
      throw new Error(response.data.error);
    }

    if (remainingTime.value <= 0) {
      clearInterval(interval);
      $toast.open("Time is up. Redirecting to home page.");
      window.location.href = "/"; // Redirect when time is up
    }
  } catch (error) {
    console.error(error);
    $toast.open({
      message: "Failed to update duration. Please try again.",
      type: "error",
    });
  }
};

const initializeTimer = () => {
  const durationInSeconds = props.userMovie.duration * 60;
  timer.value = useTimer({
    autoStart: true,
    expiryTimestamp: Date.now() + durationInSeconds * 1000, // Convert seconds to milliseconds
    onExpire: async () => {
      await sendUpdateRequest();
    },
  });

  remainingTime.value = durationInSeconds * 1000; // Initialize remaining time in milliseconds
  interval = setInterval(async () => {
    remainingTime.value = timer.value.remainingTime;
    await sendUpdateRequest();
  }, 60000); // Send update request every minute
};

onMounted(() => {
  initializeTimer();
});

onUnmounted(() => {
  clearInterval(interval);
});

const requestAccess = async (movieId) => {
  try {
    const response = await axios.post(`/movies/request-access/${movieId}`);

    if (response.data.success) {
      $toast.success("Request sent successfully. Please wait for approval.");
      $toast.open("Request sent successfully. Please wait for approval.");

      window.location.href = "/"; // Redirect to home page
    }
    else {
      throw new Error(response.data.error);
    }

    window.location.href = "/"; // Redirect to home page
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <Head title="Watch Movie" />

  <!-- Navbar here -->
  <Navbar :can-login="canLogin" :can-register="canRegister" />

  <!-- Blocking display if user movie null -->
  <div
    v-if="userMovie === null || userMovie.status !== 'approved'"
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

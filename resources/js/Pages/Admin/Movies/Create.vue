<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";
import { FwbInput, FwbButton, FwbFileInput } from "flowbite-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

const csrfToken = ref(
  document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
);
//method for handle file changes
const handleFileChange = (e) => {
  //assign file to state
  image.value = e.target.files[0];
};
</script>

<template>
  <Head title="Add New Movie" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          class="overflow-hidden sm:rounded-lg flex flex-col gap-2 justify-center items-center"
        >
          <div class="rounded-md p-8 w-1/2 bg-gray-900">
            <h1 class="font-semibold text-xl mb-6 text-white">Add New Movie</h1>
            <form
              class="w-full flex flex-col gap-4"
              enctype="multipart/form-data"
              @submit="storeMovie"
            >
              <fwb-input
                v-model="title"
                label="Title"
                placeholder="Enter movie title"
                required
              />
              <fwb-input
                v-model="video_url"
                label="Movie URL"
                placeholder="Enter movie URL"
                required
              />
              <fwb-file-input
                v-model="file"
                label="Upload file"
                accept="image/*"
                size="lg"
                class="text-xs"
                @change="handleFileChange($event)"
              >
                <p class="!mt-1 text-sm text-gray-500 dark:text-gray-300">
                  SVG, PNG, JPG or GIF (MAX. 800x400px).
                </p>
              </fwb-file-input>
              <fwb-button
                type="submit"
                color="default"
                @click="storeMovie"
                class="mt-4"
                >Submit</fwb-button
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import axios from "axios";

const $toast = useToast();

export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      title: "",
      video_url: "",
      image_url: "",
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    storeMovie(e) {
      e.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("file", this.file);
      formData.append("image_url", this.image_url);
      formData.append("title", this.title);
      formData.append("video_url", this.video_url);

      axios
        .post("/admin/movies/store", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;

          if (currentObj.success) {
            let instance = $toast.success("Movie created successfully");
            this.$toast.open("Movie created successfully");
            $toast.clear();

            // return to the movies index page
            window.location.href = "/admin/movies";
          } else {
            $toast.error(response.data.message);
          }
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
  },
};
</script>

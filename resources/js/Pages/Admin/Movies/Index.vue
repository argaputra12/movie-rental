<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps, defineComponent } from "vue";
import {
  FwbA,
  FwbTable,
  FwbTableBody,
  FwbTableCell,
  FwbTableHead,
  FwbTableHeadCell,
  FwbTableRow,
  FwbButton,
} from "flowbite-vue";
import Pagination from "@/Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

defineComponent({
  components: {
    Pagination,
  },
});

defineProps({
  movies: {
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

const deleteMovie = async (id) => {
  try {
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
    const response = await fetch(`/admin/movies/delete/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-CSRF-TOKEN": csrfToken,
      },
      body: new URLSearchParams({
        _token: csrfToken,
      }),
    });

    if (!response.ok) {
      throw new Error("Network response was not ok.");
    }

    const data = await response.json();
    if (data.success) {
      window.location.reload();

      let instance = $toast.success("Movie deleted successfully");
      this.$toast.open({
        message: "Movie deleted successfully",
        type: "success",
      });
      $toast.clear(instance);
    } else {
      // Handle failure
      console.error("Failed to delete movie.");
    }
  } catch (error) {
    console.error("Error deleting movie:", error);
  }
};
</script>

<template>
  <Head title="Movies Database" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movie Database
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg flex flex-col gap-2">
          <div class="flex justify-end">
            <a href="/admin/movies/create">
              <fwb-button color="default">Add Movies</fwb-button>
            </a>
          </div>
          <fwb-table>
            <fwb-table-head>
              <fwb-table-head-cell>Title</fwb-table-head-cell>
              <fwb-table-head-cell>Image URL</fwb-table-head-cell>
              <fwb-table-head-cell>Video URL</fwb-table-head-cell>
              <fwb-table-head-cell>
                <span class="sr-only">Edit</span>
              </fwb-table-head-cell>
            </fwb-table-head>
            <fwb-table-body>
              <fwb-table-row v-for="movie in movies.data" :key="movie.id">
                <fwb-table-cell>{{ movie.title }}</fwb-table-cell>
                <fwb-table-cell>{{ movie.image_url }}</fwb-table-cell>
                <fwb-table-cell>{{ movie.video_url }}</fwb-table-cell>
                <fwb-table-cell class="flex gap-2 justify-end">
                  <fwb-a href="#"> Edit </fwb-a>
                  <fwb-a href="#" @click="deleteMovie(movie.id)">
                    Delete
                  </fwb-a>
                </fwb-table-cell>
              </fwb-table-row>
            </fwb-table-body>
          </fwb-table>
          <Pagination :links="movies.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

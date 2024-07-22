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
} from "flowbite-vue";
import Pagination from "@/Components/Pagination.vue";

defineComponent({
  components: {
    Pagination,
  },
});

defineProps({
  userMovies: {
    type: Array,
    required: true,
  },
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});
</script>

<template>
  <Head title="Admin Dashboard" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Admin Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg flex flex-col gap-2">
          <fwb-table>
            <fwb-table-head>
              <fwb-table-head-cell>Name</fwb-table-head-cell>
              <fwb-table-head-cell>Video Title</fwb-table-head-cell>
              <fwb-table-head-cell>Status</fwb-table-head-cell>
              <fwb-table-head-cell>Duration</fwb-table-head-cell>
              <fwb-table-head-cell>
                <span class="sr-only">Edit</span>
              </fwb-table-head-cell>
            </fwb-table-head>
            <fwb-table-body>
              <fwb-table-row
                v-for="userMovie in userMovies.data"
                :key="userMovie.id"
              >
                <fwb-table-cell>{{ userMovie.user.name }}</fwb-table-cell>
                <fwb-table-cell>{{ userMovie.movie.title }}</fwb-table-cell>
                <fwb-table-cell class="capitalize">{{
                  userMovie.status
                }}</fwb-table-cell>
                <fwb-table-cell>
                  {{
                    userMovie.movie.duration
                      ? userMovie.movie.duration
                      : "No Duration"
                  }}
                </fwb-table-cell>
                <fwb-table-cell>
                  <fwb-a href="#"> Edit </fwb-a>
                </fwb-table-cell>
              </fwb-table-row>
            </fwb-table-body>
          </fwb-table>
          <Pagination :links="userMovies.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

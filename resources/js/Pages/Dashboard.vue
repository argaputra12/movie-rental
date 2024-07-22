<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import {
  FwbA,
  FwbTable,
  FwbTableBody,
  FwbTableCell,
  FwbTableHead,
  FwbTableHeadCell,
  FwbTableRow,
} from "flowbite-vue";

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

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Admin Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <fwb-table>
            <fwb-table-head>
              <fwb-table-head-cell>Name</fwb-table-head-cell>
              <fwb-table-head-cell>Video Title</fwb-table-head-cell>
              <fwb-table-head-cell>Status</fwb-table-head-cell>
              <fwb-table-head-cell>Action</fwb-table-head-cell>
              <fwb-table-head-cell>
                <span class="sr-only">Edit</span>
              </fwb-table-head-cell>
            </fwb-table-head>
            <fwb-table-body>
              <fwb-table-row>
                <fwb-table-cell>Apple MacBook Pro 17"</fwb-table-cell>
                <fwb-table-cell>Sliver</fwb-table-cell>
                <fwb-table-cell>Laptop</fwb-table-cell>
                <fwb-table-cell>$2999</fwb-table-cell>
                <fwb-table-cell>
                  <fwb-a href="#"> Edit </fwb-a>
                </fwb-table-cell>
              </fwb-table-row>
            </fwb-table-body>
          </fwb-table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

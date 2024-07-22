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
  users: {
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
          <fwb-table>
            <fwb-table-head>
              <fwb-table-head-cell>Name</fwb-table-head-cell>
              <fwb-table-head-cell>Email</fwb-table-head-cell>
              <fwb-table-head-cell>Role</fwb-table-head-cell>
              <fwb-table-head-cell>
                <span class="sr-only">Edit</span>
              </fwb-table-head-cell>
            </fwb-table-head>
            <fwb-table-body>
              <fwb-table-row v-for="user in users.data" :key="user.id">
                <fwb-table-cell>{{ user.name }}</fwb-table-cell>
                <fwb-table-cell>{{ user.email }}</fwb-table-cell>
                <fwb-table-cell class="capitalize">{{
                  user.is_admin == 1 ? "Admin" : "User"
                }}</fwb-table-cell>

                <fwb-table-cell>
                  <fwb-a href="#"> Edit </fwb-a>
                </fwb-table-cell>
              </fwb-table-row>
            </fwb-table-body>
          </fwb-table>
          <Pagination :links="users.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

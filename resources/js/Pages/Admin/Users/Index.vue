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
  users: {
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

const deleteUser = async (id) => {
  try {
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
    const response = await fetch(`/admin/users/delete/${id}`, {
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
      // Handle success, e.g., update UI or redirect
      window.location.reload();

      let instance = $toast.success("User deleted successfully");
      this.$toast.open({
        message: "User deleted successfully",
        type: "success",
      });
      $toast.clear();
    } else {
      // Handle failure
      console.error("Failed to delete user.");
    }
  } catch (error) {
    console.error("Error deleting user:", error);
  }
};
</script>

<template>
  <Head title="Users Database" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Database
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg flex flex-col gap-2">
          <div class="flex justify-end">
            <a href="/admin/users/create">
              <fwb-button color="default">Add User</fwb-button>
            </a>
          </div>
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
                <fwb-table-cell class="flex gap-2 justify-end">
                  <fwb-a href="#"> Edit </fwb-a>
                  <fwb-a href="#" @click="deleteUser(user.id)"> Delete </fwb-a>
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

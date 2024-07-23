<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, ref, onMounted } from "vue";
import { FwbInput, FwbButton } from "flowbite-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

// Define and destructure props
const props = defineProps({
  userMovie: {
    type: Object,
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

// Initialize form using useForm
const form = useForm({
  name: "",
  title: "",
  status: "",
  duration: "",
});

// Set form values on mount
onMounted(() => {
  form.name = props.userMovie.name;
  form.title = props.userMovie.title;
  form.status = props.userMovie.status;
  form.duration = props.userMovie.duration;
});

// CSRF token (if needed, often managed by Inertia)
const csrfToken = ref(
  document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
);

// Status options
const statusOptions = [
  { value: "waiting", label: "Waiting" },
  { value: "approved", label: "Approved" },
  { value: "rejected", label: "Rejected" },
];

// Update approval function
const updateApproval = async () => {
  try {
    const response = await fetch(
      `/admin/movies/update-approval/${props.userMovie.id}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken.value,
        },
        body: JSON.stringify({
          name: form.name,
          title: form.title,
          status: form.status,
          duration: form.duration,
        }),
      },
    );

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    if (data.success) {
      $toast.success("Approval updated successfully");

      // Redirect to the admin page
      window.location.href = "/admin";
    } else {
      $toast.error("Update failed, please try again");
    }
  } catch (error) {
    $toast.error("Error updating approval: " + error.message);
  }
};
</script>

<template>
  <Head title="Edit Approval" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          class="overflow-hidden sm:rounded-lg flex flex-col gap-2 justify-center items-center"
        >
          <div class="rounded-md p-8 w-1/2 bg-gray-900">
            <h1 class="font-semibold text-xl mb-6 text-white">Edit Approval</h1>
            <div class="w-full flex flex-col gap-4">
              <!-- Input fields -->
              <FwbInput
                v-model="form.name"
                label="User Name"
                placeholder="Enter user name"
                required
              />
              <FwbInput
                v-model="form.title"
                label="Movie Title"
                placeholder="Enter movie title"
                required
              />
              <label
                for="status"
                class="block text-sm font-medium text-gray-900 dark:text-white"
                >Status</label
              >
              <select
                v-model="form.status"
                id="status"
                class="w-full text-gray-900 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 rounded-md"
              >
                <option value="">Select Status</option>
                <option
                  v-for="item in statusOptions"
                  :key="item.value"
                  :value="item.value"
                >
                  {{ item.label }}
                </option>
              </select>
              <FwbInput
                v-model="form.duration"
                label="Duration (in minutes)"
                type="number"
                required
              />
              <FwbButton color="default" @click="updateApproval" class="mt-4">
                Submit
              </FwbButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

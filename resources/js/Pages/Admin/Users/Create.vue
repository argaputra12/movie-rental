<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps, defineComponent, ref } from "vue";
import { FwbInput, FwbButton } from "flowbite-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

const csrfToken = ref(
  document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
);

const name = ref(document.querySelector('input[name="name"]'));
const email = ref(document.querySelector('input[name="email"]'));
const password = ref(document.querySelector('input[name="password"]'));

const storeUser = async () => {
  try {
    const response = await fetch("/admin/users/store", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken.value,
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        password: password.value,
      }),
    });

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    if (data.success) {
      let instance = $toast.success({
        title: "User created successfully",
        message: "User created successfully",
        type: "success",
      });
      this.$toast.open({
        message: "User created successfully",
        type: "success",
      });
      $toast.clear();

      // return to the users index page
      window.location.href = "/admin/users";
    } else {
      $toast.error(data.message);
    }
  } catch (error) {
    $toast.error(error.message);
  }
};
</script>

<template>
  <Head title="Add New User" />

  <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          class="overflow-hidden sm:rounded-lg flex flex-col gap-2 justify-center items-center"
        >
          <div class="rounded-md p-8 w-1/2 bg-gray-900">
            <h1 class="font-semibold text-xl mb-6 text-white">Add New User</h1>
            <div class="w-full flex flex-col gap-4" method="POST">
              <fwb-input
                v-model="name"
                label="Name"
                placeholder="enter user name"
                required
              />
              <fwb-input
                v-model="email"
                label="Email"
                placeholder="enter user email address"
                required
              />
              <fwb-input
                v-model="password"
                label="Password"
                placeholder="enter user password"
                required
              />
              <fwb-button color="default" @click="storeUser" class="mt-4"
                >Submit</fwb-button
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

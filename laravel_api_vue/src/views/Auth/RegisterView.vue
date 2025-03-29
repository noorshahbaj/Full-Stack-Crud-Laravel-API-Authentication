<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const { errors } = storeToRefs(useAuthStore());
const { authenticate } = useAuthStore();

const formData = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
  <main>
    <h1 class="title">Register a new account</h1>

    <form
      @submit.prevent="authenticate('register', formData)"
      class="w-1/2 mx-auto space-y-6"
    >
      <div>
        <input type="text" id="name" placeholder="Name" v-model="formData.name" />
        <p class="error" v-if="errors.name">{{ errors.name[0] }}</p>
      </div>

      <div>
        <input type="email" id="email" placeholder="Email" v-model="formData.email" />
        <p class="error" v-if="errors.email">{{ errors.email[0] }}</p>
      </div>

      <div>
        <input
          type="password"
          id="password"
          placeholder="Password"
          v-model="formData.password"
        />
        <p class="error" v-if="errors.password">{{ errors.password[0] }}</p>
      </div>

      <div>
        <input
          type="password"
          id="password_confirmation"
          placeholder="Confirm Password"
          v-model="formData.password_confirmation"
        />
      </div>

      <button class="primary-btn cursor-pointer" type="submit">Register</button>
    </form>
  </main>
</template>

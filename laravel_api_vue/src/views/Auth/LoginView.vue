<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const { errors } = storeToRefs(useAuthStore());
const { authenticate } = useAuthStore();

const formData = reactive({
  email: "",
  password: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
  <main>
    <h1 class="title">Login to your account</h1>

    <form
      @submit.prevent="authenticate('login', formData)"
      class="w-1/2 mx-auto space-y-6"
    >
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

      <button class="primary-btn cursor-pointer" type="submit">Login</button>
    </form>
  </main>
</template>

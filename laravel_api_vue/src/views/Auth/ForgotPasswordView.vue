<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { onMounted, reactive } from "vue";

const { errors } = storeToRefs(useAuthStore());
const { forgotPassword } = useAuthStore();

const formData = reactive({
  email: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
  <main>
    <h1 class="title">Enter Your Email</h1>

    <form @submit.prevent="forgotPassword(formData)" class="w-1/2 mx-auto space-y-6">
      <div>
        <input type="email" id="email" placeholder="Email" v-model="formData.email" />
        <p class="error" v-if="errors.email">{{ errors.email[0] }}</p>
      </div>

      <button class="primary-btn cursor-pointer" type="submit">Login</button>
    </form>
  </main>
</template>

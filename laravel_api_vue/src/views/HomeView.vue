<script setup>
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from "vue";

const { getAllPosts } = usePostsStore();
const posts = ref([]);
const isLoading = ref(true); // Add a loading state

onMounted(async () => {
  posts.value = await getAllPosts();
  isLoading.value = false; // Set loading to false after fetching data
});
</script>

<template>
  <main>
    <h1 class="title">Latest Posts</h1>

    <div v-if="isLoading">
      <p>Loading posts...</p>
      <!-- Show a loading message -->
    </div>

    <div v-else-if="posts.length > 0">
      <div v-for="post in posts" :key="post.id" class="border-l-4 border-blue-500 pl-4 mb-12">
        <h2 class="font-bold text-3xl">{{ post.title }}</h2>
        <p class="text-xs text-slate-600 mb-4">Posted by {{ post.user.name }}</p>
        <p>
          {{ post.body }}
          <router-link :to="{ name: 'show', params: { id: post.id } }" class="text-blue-500 font-bold underline">Read
            more...</router-link>
        </p>
      </div>
    </div>
    <div v-else>
      <h2 class="title">There are no posts</h2>
    </div>
  </main>
</template>

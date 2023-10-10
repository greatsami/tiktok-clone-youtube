<template>
  <div class="bg-[#f8f8f8] h-[100vh]">
    <TopNav />

    <div class="flex justify-between mx-auto w-full px-2 max-w-[1140x]">
      <slot />
    </div>
  </div>
</template>
<script setup lang="ts"></script>
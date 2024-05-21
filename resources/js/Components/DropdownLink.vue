<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  href: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Link
    :href="href"
    class="block w-[100px] px-4 py-2 text-end text-3xl leading-5 text-main-black  focus:outline-none transition duration-150 ease-in-out"
  >
    <slot />
  </Link>
</template>

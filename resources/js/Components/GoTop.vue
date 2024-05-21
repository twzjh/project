<script>
import gotopBg from '/images/FrontEndIcon/go-top.png';
export default {
  data() {
    return {
      gotopBg,
    };
  },
  methods: {
    goToTop() {
      window.scrollTo({ top: 0 });
    },
  },
};
</script>

<template>
  <div class="fixed bottom-5 right-8 z-[10] max-xl:bottom-40 max-xl:w-[80px] max-sm:right-1 max-sm:bottom-6 max-sm:w-[48px]">
    <button type="button" @click="goToTop" class="focus:outline-none">
      <img :src="gotopBg" alt="go-top" class="w-[80px]">
    </button>
  </div>
</template>


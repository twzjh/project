<script>
import whiFacebook from '/images/FrontEndIcon/facebook-white.png';
import whiYoutube from '/images/FrontEndIcon/white-youtube.png';
import { Link } from '@inertiajs/vue3';
export default {
  components: {
    Link,
  },
  props: {
    parentClass: String,
  },
  data() {
    return {
      whiFacebook,
      whiYoutube,
    };
  },
};
</script>

<template>
  <footer class="w-full flex h-[120px] bg-main-black text-main-white max-xl:h-[168px] sm items-center justify-center" :class="parentClass">
    <div class="w-full flex justify-evenly max-xl:flex-col max-sm:gap-y-4">
      <div class="flex justify-center items-center footer gap-x-4">
        <div class="break-keep">©2022</div>
        <div class="break-keep">五術研究社版權所有</div>
      </div>
      <div class="flex justify-center items-center footer gap-x-6 max-sma:gap-2">
        <div class="flex justify-center items-center gap-x-6 sm1 mr-52 max-xl:mr-0 max-sma:gap-2">
          <Link href="/connection" class="p-[8px] hover:text-lake-green hover:border-b border-lake-green break-keep">聯絡我們</Link>
          <div class="border-r h-[48px] sm2"></div>
          <Link href="/paymentTerms" class="p-[8px] hover:text-lake-green hover:border-b border-lake-green break-keep">付款與退款流程</Link>
          <div class="border-r h-[48px] sm2"></div>
          <Link href="/privacy" class="p-[8px] hover:text-lake-green hover:border-b border-lake-green break-keep">隱私權政策</Link>
        </div>
        <div class="flex justify-center items-center gap-x-6 sm3">
          <a target="_blank" href="https://www.facebook.com/groups/wussu/?ref=share_group_link">
            <img :src="whiFacebook" alt="facebook" class="sma-src">
          </a>
          <a target="_blank" href="https://www.youtube.com/@wushuzaizai">
            <img :src="whiYoutube" alt="youtube" class="sma-src">
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  @apply text-[24px] font-bold font-JhengHei
}

@media (max-width:1269px) {
  .xl {
    @apply h-[168px] flex-col gap-x-32 justify-center
  }

  .xl1 {
    @apply gap-x-0 mt-4
  }
}

@media (max-width:599px) {
  .footer {
  @apply text-[16px]
  }

  .sm {
    @apply h-[256px]
  }

  .sm1 {
    @apply flex flex-col gap-0 items-start
  }

  .sm2 {
    @apply hidden
  }

  .sm3 {
    @apply flex flex-col gap-0 mt-[52px] gap-y-4 ml-[60px]
  }

  .sma-src {
    @apply w-[32px] h-[32px]
  }
}
</style>

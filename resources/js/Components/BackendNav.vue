<script>
import logo from '/images/BackEndIcon/Logo.png';
import chevronUp from '/images/BackEndIcon/Vector-up.svg';
import chevronDown from '/images/BackEndIcon/Vector-down.svg';
import { Link } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';

export default {
  components: {
    Link, DropdownLink,
  },
  data() {
    return {
      logo,
      chevronUp,
      chevronDown,
      show: false,
      showChevron: chevronDown,
    };
  },
  methods: {
    openNav() {
      this.show = !this.show;

      if (this.show === true) {
        this.showChevron = chevronUp;
      } else {
        this.showChevron = chevronDown;
      }
    },
  },
};
</script>

<template>
  <div class="overflow-hidden">
    <div
      class="w-full h-20 bg-light-light-gary p-3 flex text-center items-center text-main-black font-bold text-3xl font-JhengHei topNav">
      <img :src="logo" alt="網站logo" class="w-[44px] me-3 ml-10">
      <span>五術研究社 後台管理</span>
      <DropdownLink :href="route('logout')" method="post" as="button" class="ml-auto p-10 cursor-pointer">登出</DropdownLink>
    </div>
    <div class="flex">
      <div
        class="flex flex-col items-start bg-light-light-gary w-[270px] h-[91vh] text-2xl font-JhengHei font-bold text-dark-gray">
        <Link :href="route('payment.index')" class="px-5 py-5 mt-5 cursor-pointer">付款紀錄管理</Link>
        <div class="w-[80%] h-3 border-b border-light-gary mb-6"></div>
        <Link :href="route('member.manage')" class="px-5 py-2 mb-8 cursor-pointer">會員管理</Link>
        <Link :href="route('callus.index')" class="px-5 py-2 mb-2 cursor-pointer">聯絡我們紀錄</Link>
        <div class="w-[80%] h-4 border-b border-light-gary mb-2"></div>
        <div class="px-5 py-2 mt-5 mb-5 cursor-pointer flex" @click="openNav">
          <span class="cursor-pointer">服務與課程管理</span>
          <img :src="showChevron" alt="箭頭" class="w-[20px] h-[20px] mt-2 ml-3 cursor-pointer">
        </div>
        <Link :href="route('service.content')" v-if="show === true" class="px-5 py-2 mb-5 cursor-pointer">服務內容管理</Link>
        <Link :href="route('soncourse.content')" v-if="show === true" class="px-5 py-2 mb-2 cursor-pointer">子課程內容管理</Link>
        <div class="w-[80%] h-4 border-b border-light-gary mb-2"></div>
        <Link :href="route('seo.manage')" class="px-5 py-2 mt-5 cursor-pointer mb-2">SEO管理</Link>
        <a href="#" class="px-5 py-2 mt-5 cursor-pointer">Google分析管理</a>
      </div>
      <div class="w-[95%]">
        <!-- 標題 -->
        <slot name="title" class="bg-white"></slot>
        <!-- 內容 -->
        <div class="overflow-auto h-[calc(100vh-152px)]">
          <slot name="content"></slot>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped>
.topNav {
  box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
}
</style>

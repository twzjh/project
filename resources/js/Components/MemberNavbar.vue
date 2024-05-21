<script>
import { Link } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';
export default {
  components: {
    Link, DropdownLink,
  },
  props: {
    nowpage: {
      type: Number,
      default: 1,
    },
  },
};
</script>

<template>
  <header class="header">
    <h2>會員中心</h2>
    <div class="flex w-auto gap-x-2 sm:gap-x-4 pb-[60px] sm:pb-[80px] xl:pb-[120px] flex-wrap gap-y-4 justify-center sma:gap-y-0">
      <Link :href="route('member.edit')" class="nav-btn" :class="{ 'active': nowpage === 1 }">個人資料</Link>
      <Link :href="route('member.courses')" class="nav-btn" :class="{ 'active': nowpage === 2 }">我的課程</Link>
      <Link :href="route('member.record')" class="nav-btn" :class="{ 'active': nowpage === 3 }">購買紀錄</Link>
      <span class="w-[1px] h-15 bg-white"></span>
      <DropdownLink :href="route('logout')" method="post" as="button" class="nav-btn">登出</DropdownLink>
    </div>
  </header>
</template>

<style scoped>
.header{
  @apply bg-black w-full flex flex-col justify-center items-center pt-[120px] sm:pt-[160px] xl:pt-[224px]
}
h2{
  border: none !important;
  @apply font-NotoSerif text-white text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider p-0 pb-2 sm:mb-[40px] mb-[16px] xl:mb-[16px] relative
}
h2::after {
  content: "";
  @apply h-[2px] w-[110%] bg-white absolute bottom-0 left-[-4%]
}
h3{
  @apply font-JhengHei text-[20px] sm:text-[32px] font-bold
}
.nav-btn{
  @apply py-3 px-3 sm:px-6 text-white border border-white rounded-md font-JhengHei text-[18px] sm:text-2xl cursor-pointer hover:bg-zinc-800 break-keep w-auto text-center
}
.active{
  @apply bg-white hover:bg-white text-black
}
</style>

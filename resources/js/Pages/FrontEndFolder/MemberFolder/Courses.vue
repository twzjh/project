<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import MemberNavbar from '@/Components/MemberNavbar.vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    MemberNavbar, Navbar, Footer, Link, Head,
  },
  props: {
    courseData: Array,
  },
  methods: {
    // 變換類型標籤顏色
    typeColor(type) {
      switch (type) {
      case 1:
        return { class: 'bg-main-blue', text: '占星' };
      case 2:
        return { class: 'bg-main-brown', text: '中醫' };
      case 3:
        return { class: 'bg-dark-gray', text: '魔法' };
      case 4:
        return { class: 'bg-main-green', text: '其他' };
      default:
        return 'bg-main-green'; // 預設情況
      }
    },
    // 跳到指定課程傳出courseId
    goPage(id) {
      this.$inertia.get('/coursecontent', { 'courseId': id });
    },
  },
};
</script>

<template>
  <Head title="我的課程"></Head>
  <Navbar />
  <MemberNavbar :nowpage="2"></MemberNavbar>
  <div class="wrap">
    <section class="section" :class="{ 'no-section': !courseData.data?.length }">
      <div v-if="courseData.length" class="flex w-11/12 gap-x-[20px] gap-y-4 sm:gap-y-6 xl:gap-y-5 flex-wrap">
        <!-- 課程卡片 -->
        <div v-for="course in courseData" :key="course.id" class="shadow-cardShadow p-4 flex flex-col gap-5 w-full sma:w-[48%] xl:w-card3 relative">
          <Link class="absolute inset-0" @click="goPage(course.id)"></Link>
          <h3 class="text-[20px] sm:text-[32px] font-bold">{{ course.course_name }}</h3>
          <p class="text-[16px] sm:text-2xl leading-7 sm:leading-10 text-gray-600 tracking-widest mb-1">{{ course.course_introduce }}</p>
          <div class="flex justify-between mt-auto">
            <span class="text-white text-[16px] sm:text-[18px] py-2 px-4 rounded-full" :class="typeColor(course.course_type).class">{{ typeColor(course.course_type).text }}</span>
            <Link @click="goPage(course.id)" class="px-4 py-2 sm:px-6 bg-blue-green rounded-full text-white hover:bg-lake-green text-[16px] sm:text-[18px] z-[2]">前往課程</Link>
          </div>
        </div>
        <!-- 課程卡片 -->
      </div>
      <div v-else class="flex pt-10">
        <h3 class="noneText">尚未購買/解鎖任何課程</h3>
      </div>
    </section>
  </div>
  <Footer></Footer>
</template>

<style scoped>
.section{
  @apply flex flex-col items-center w-full pt-[30px] sm:pt-[60px] pb-[60px] sm:pb-[80px] xl:pb-[120px] xl:w-11/12 mx-auto
}
.wrap{
  min-height: calc(100vh - (305px + 256px));
}
@media screen and (min-width: 600px) {
  .wrap{
    min-height: calc(100vh - (424px + 256px));
  }
}
@media screen and (min-width: 680px) {
  .wrap{
    min-height: calc(100vh - (424px + 168px));
  }
}
@media screen and (min-width: 1270px) {
  .wrap{
    min-height: calc(100vh - (522px + 120px));
  }
}
.norecord{
  @apply fixed bottom-0
}
.noneText{
  @apply text-[18px] sm:text-2xl text-dark-gray
}
</style>

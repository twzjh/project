<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import ServiceCard from '@/Components/ServiceCard.vue';
import CourseCard from '@/Components/CourseCard.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    ServiceCard, CourseCard, Navbar, Footer, Head,
  },
  props: {
    keyword: String,
    serviceFilterData: Object,
    courseFilterData: Object,
    boughtArray: Array,
    boughtService: Array,
  },
  data() {
    return {
      found: true,
      parentClass: this.serviceFilterData.length || this.courseFilterData.length ? '' : 'norecord',
    };
  },
  computed: {
    foundKeyword() {
      return this.serviceFilterData.length || this.courseFilterData.length;
    },
  },
};
</script>

<template>
  <Head title="搜尋結果"></Head>
  <Navbar />
  <header class="header">
    <h2>搜尋結果</h2>
    <span class="result" v-if="foundKeyword">以下是跟「{{ keyword }}」有關的所有課程</span>
    <span class="result" v-else>查無跟「{{ keyword }}」有關的課程</span>
  </header>
  <main class="flex flex-col items-center w-full wrap">
    <section class="flex w-11/12 py-[30px] sm:py-[40px] xl:py-[60px] items-center flex-col">
      <ServiceCard :service-data="serviceFilterData" :bought-service=boughtService></ServiceCard>
    </section>
    <section class="course-section">
      <CourseCard :course-data="courseFilterData" :bought-course=boughtArray></CourseCard>
    </section>
    <section v-if="!foundKeyword" class="h-max">
    </section>
  </main>
  <Footer></Footer>
</template>

<style scoped>
  .header{
    @apply bg-black w-full flex flex-col justify-center items-center pt-[120px] sm:pt-[160px] xl:pt-[224px]
  }
  h2{
    @apply font-NotoSerif text-white text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider p-0 pb-2 mb-[16px] sm:mb-[40px] xl:mb-[16px] relative
  }
  h2::after {
    content: "";
    @apply h-[2px] w-[90%] bg-white absolute bottom-0 left-[4%]
  }
  .course-section{
    @apply flex w-11/12 sm:w-8/12 xl:w-11/12 p-0 mb-[60px] xl:py-[60px] gap-x-[20px] gap-y-5 flex-wrap
  }
  .result{
    @apply font-JhengHei text-white text-[12px] sm:text-[28px] xl:text-[32px] tracking-wide mb-[60px] sm:mb-[80px] xl:mb-[120px]
  }
  .norecord{
  @apply fixed bottom-0
  }
  .wrap{
  min-height: calc(100vh - (270px + 256px));
  }
  @media screen and (min-width: 600px) {
    .wrap{
      min-height: calc(100vh - (408px + 256px));
    }
  }
  @media screen and (min-width: 680px) {
    .wrap{
      min-height: calc(100vh - (408px + 168px));
    }
  }
  @media screen and (min-width: 1270px) {
    .wrap{
      min-height: calc(100vh - (512px + 120px));
    }
  }
</style>


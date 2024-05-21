<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import ServiceCard from '@/Components/ServiceCard.vue';
import CourseCard from '@/Components/CourseCard.vue';
import gotopBg from '/images/FrontEndIcon/go-top.png';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Mousewheel, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    ServiceCard, CourseCard, Navbar, Footer, Swiper, SwiperSlide, Head,
  },
  props: {
    serviceData: Array,
    courseData: Array,
    boughtArray: Array,
    boughtService: Array,
  },
  setup() {
    return {
      modules: [Mousewheel, Navigation],
    };
  },
  data() {
    return {
      gotopBg,
      myBreakpoints: {
        450: {
          slidesPerView: 2,
          spaceBetween: '20',
        },
        700: {
          slidesPerView: 3,
          spaceBetween: '40',
        },
        1270: {
          slidesPerView: 4,
          spaceBetween: '60',
        },
      },
      vedicData: [],
      TCMData: [],
      magicData: [],
      otherData: [],
    };
  },
  mounted() {
    // 4種分類的courseData 1占星2中醫3魔法4其他
    this.vedicData = this.courseData.filter(course => course.course_type === 1);
    this.TCMData = this.courseData.filter(course => course.course_type === 2);
    this.magicData = this.courseData.filter(course => course.course_type === 3);
    this.otherData = this.courseData.filter(course => course.course_type === 4);
    document.title = '五術研究社 - 服務與課程';
  },
  methods: {
    goToTop() {
      window.scrollTo({ top: 0 });
    },
  },
};
</script>

<template>
  <Head title="服務與課程"></Head>
  <Navbar />
  <header class="bg-black w-full flex flex-col justify-center items-center pt-[120px] sm:pt-[160px] xl:pt-[224px]">
    <h1 class="font-NotoSerif text-white text font-bold tracking-wider pb-2 mb-[16px] sm:mb-[40px] xl:mb-[80px] relative">服務與課程</h1>
    <!-- swiper -->
    <div class="swiper-context">
      <Swiper
        :modules="modules"
        navigation
        :direction='horizontal'
        :slides-per-view="2"
        :space-between="16"
        @swiper="onSwiper"
        @slide-change="onSlideChange"
        class="mySwiper w-[92%] xl:w-full"
        :breakpoints="myBreakpoints"
      >
        <SwiperSlide>
          <div class="slide-item">
            <a href="#service"></a>
            <div class="slide-pic bg-service-img"></div>
            <h3>服務</h3>
          </div>
        </SwiperSlide>
        <SwiperSlide>
          <div class="slide-item">
            <a href="#vedic"></a>
            <div class="slide-pic bg-vedic-img"></div>
            <h3>吠陀占星</h3>
          </div>
        </SwiperSlide>
        <SwiperSlide>
          <div class="slide-item">
            <a href="#TCM"></a>
            <div class="slide-pic bg-TCM-img"></div>
            <h3>中醫</h3>
          </div>
        </SwiperSlide>
        <SwiperSlide>
          <div class="slide-item">
            <a href="#magic"></a>
            <div class="slide-pic bg-magic-img"></div>
            <h3>古典魔法</h3>
          </div>
        </SwiperSlide>
        <SwiperSlide>
          <div class="slide-item">
            <a href="#other"></a>
            <div class="slide-pic bg-other-img"></div>
            <h3>其他術數</h3>
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </header>
  <!-- 服務區塊 -->
  <section class="section" id="service">
    <div class="section-nav bg-service-img">
      <h2 class="font-bold text">服務</h2>
      <h2 class="font-semibold text-en">Service</h2>
    </div>
    <div class="flex w-11/12 py-[30px] sm:py-[40px] xl:py-[60px] items-center flex-col">
      <ServiceCard :service-data="serviceData" :bought-service=boughtService></ServiceCard>
    </div>
  </section>
  <!-- 吠陀占星區塊 -->
  <section class="section" id="vedic">
    <div class="section-nav bg-vedic-img">
      <h2 class="font-bold text">吠陀占星</h2>
      <h2 class="font-semibold text-en">Vedic Astrology</h2>
    </div>
    <div class="card-area">
      <CourseCard :course-data="vedicData" :bought-course=boughtArray></CourseCard>
    </div>
  </section>
  <!-- 中醫區塊 -->
  <section class="section" id="TCM">
    <div class="section-nav bg-TCM-img">
      <h2 class="font-bold text">中醫</h2>
      <h2 class="font-semibold text-en">Traditional Chinese Medicine</h2>
    </div>
    <div class="card-area">
      <CourseCard :course-data="TCMData" :bought-course=boughtArray></CourseCard>
    </div>
  </section>
  <!-- 古典魔法區塊 -->
  <section class="section" id="magic">
    <div class="section-nav bg-magic-img">
      <h2 class="font-bold text">古典魔法</h2>
      <h2 class="font-semibold text-en">Classical Magic</h2>
    </div>
    <div class="card-area">
      <CourseCard :course-data="magicData" :bought-course=boughtArray></CourseCard>
    </div>
  </section>
  <!-- 其他區塊 -->
  <section class="section" id="other">
    <div class="section-nav bg-other-img">
      <h2 class="font-bold text">其他術數</h2>
      <h2 class="font-semibold text-en">Other</h2>
    </div>
    <div class="card-area">
      <CourseCard :course-data="otherData" :bought-course=boughtArray></CourseCard>
    </div>
  </section>
  <!-- gotop -->
  <div class="fixed bottom-5 right-8 z-[10] max-xl:bottom-40 max-xl:w-[80px] max-sma:right-1 max-sma:bottom-6 max-sma:w-[48px]">
    <button type="button" @click="goToTop" class="focus:outline-none">
      <img :src="gotopBg" alt="go-top" class="w-[80px]">
    </button>
  </div>
  <Footer />
</template>

<style scoped>
h1::after {
  content: "";
  @apply h-[2px] w-[90%] bg-white absolute bottom-0 left-[4%]
}
h2{
  @apply z-[2]
}
h3{
  @apply text-center mt-2 select-none
}
.section{
  @apply flex flex-col items-center w-full mb-[30px] sm:mb-[40px] xl:mb-[60px]
}
.card-area{
  @apply flex w-[82.9%] py-[30px] sm:py-[40px] xl:py-[60px] gap-x-[20px] gap-y-5 flex-wrap
}
.text{
  @apply text-[32px] sm:text-[52px] xl:text-[64px]
}
.text-en{
  @apply text-[24px] sm:text-[32px] xl:text-[48px]
}
.section-nav{
  @apply w-full h-[200px] sm:h-[320px] bg-black text-white font-NotoSerif flex flex-col justify-center items-center overflow-hidden bg-center bg-cover relative
}
.section-nav::before{
  content:'';
  @apply absolute flex w-full h-full bg-black/75
}
.swiper-context{
  @apply w-full sm:max-w-[980px] mb-[60px] sm:mb-[80px] xl:mb-[120px] font-JhengHei text-white text-[20px] sm:text-[28px] xl:text-[32px] font-bold relative overflow-x-hidden
}
.swiper-context a{
  @apply inset-0 z-[2] absolute
}
.swiper-container {
  max-width: 980px !important; /* 設定 container 的最大寬度 */
  margin-left: auto !important;
  margin-right: auto !important;
}
.swiper {
  @apply flex gap-x-[16px]
}
.swiper-slide {
  @apply !w-[120px] sm:!w-[200px]
}
.swiper-wrapper > .swiper-slide:last-child {
  margin-right: 0 !important;
}
.slide-item{
  @apply w-[120px] sm:h-[200px] h-[150px] flex flex-col items-center sm:w-[200px]
}
.slide-pic{
  @apply w-[120px] h-[90px] sm:w-[200px] sm:h-[150px] bg-center bg-cover
}
.slide-item > h3{
  @apply text-start sm:text-center text-[20px] sm:text-[28px] xl:text-[32px]
}
.slide-item > a{
  @apply w-[120px] sm:w-[200px]
}
</style>

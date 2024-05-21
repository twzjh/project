<script>
import Cart from '/images/FrontEndIcon/white-cart.png';
import { Link } from '@inertiajs/vue3';
export default {
  components: {
    Link,
  },
  props: {
    courseData: Array,
    boughtCourse: Array,
  },
  data() {
    return {
      cart: Cart,
      cartForm: {},
    };
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
    addCart(id) {
      // 買過的課程不能買
      if (this.boughtCourse.includes(id)) {
        return;
      }
      this.cartForm.id = id;
      this.cartForm.type = 2;
      this.$inertia.post('/addCart', this.cartForm,
        {
          preserveState: false,
          preserveScroll: true,
          onSuccess: (res) => {
            const msg = res.props.flash.message;
            Swal.fire({
              title: msg,
              buttonsStyling: false,
              customClass: {
                popup: 'w-[330px]',
                title: 'font-JhengHei text-black border-0 pt-[20px] pb-4',
                actions: 'w-[40%] mt-2',
                confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
              },
            });
          },
        });
    },
    // 跳到指定課程傳出courseId
    goPage(id) {
      this.$inertia.get('/coursecontent', { 'courseId': id });
    },
  },
};
</script>

<template>
  <!-- 第二頁下面的加入購物車卡片 -->
  <div class="courseCard" v-for="course in courseData" :key="course.id">
    <Link class="absolute inset-0" @click="goPage(course.id)"></Link>
    <h3 class="text-[20px] sm:text-[32px] font-bold">{{ course.course_name }}</h3>
    <p class="text-[16px] sm:text-2xl leading-7 sm:leading-10 text-gray-600 tracking-widest">{{ course.course_introduce }}</p>
    <span class="text-[16px] sm:text-2xl text-blue-green leading-7 sm:leading-10 self-end font-bold mt-auto">NT${{ course.course_price.toLocaleString() }}</span>
    <div class="flex">
      <span class="text-white text-[16px] sm:text-[18px] py-2 px-4 rounded-full" :class="typeColor(course.course_type).class">{{ typeColor(course.course_type).text }}</span>
      <div class="px-4 py-2 sm:px-6 rounded-full ml-auto text-white flex items-center z-[2] canBuy"
        @click.stop="addCart(course.id)"
        :class="{ 'bought': boughtCourse.includes(course.id) }"
      >
        <img :src="cart" class="w-[16px] sm:w-[24px] mr-2 sm:mr-2 sm:h-full h-[16px]">
        <span class="text-[16px] sm:text-[18px] select-none">加入購物車</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.courseCard {
  @apply shadow-cardShadow p-4 flex flex-col gap-5 w-full xl:w-card3 relative
}
.canBuy{
  @apply bg-blue-green hover:bg-lake-green cursor-pointer
}
.bought{
  @apply bg-light-gary hover:bg-light-gary cursor-default
}
</style>


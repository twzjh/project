<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Maincourses from '@/Components/Maincourses.vue';
import Cart from '/images/FrontEndIcon/white-cart.png';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    Navbar,
    Footer,
    Maincourses,
    Head,
  },
  props: {
    courses: Object,
    chapter: Object,
    boughtArray: Array,
  },
  data() {
    return {
      Cart,
      cartForm: {},
    };
  },
  methods: {
    addCart(id) {
      // 買過的課程不能買
      if (this.boughtArray.includes(id)) {
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
  },
};
</script>

<template>
  <Head title="課程介紹"></Head>
  <Navbar />
  <div class="w-full flex flex-col items-center bg-main-black pt-[224px] pb-[120px] title titlexl titlesm">
    <div>{{ courses.course_name }}</div>
    <div class="w-[300px] border-b-2 border-main-white max-sma:w-[120px]"></div>
  </div>
  <div class="w-full pt-[60px] pb-[120px] flex justify-center max-xl:pb-20 max-sm:pt-[30px] max-sm:pb-[60px]">
    <div class="w-3/4 flex flex-col max-xl:w-11/12">
      <div class="mb-[60px] flex flex-col max-xl:mb-[40px]">
        <div
          class="text-right text-[32px] font-JhengHei text-blue-green font-bold max-xl:text-[28px] max-sm:text-[20px]">
          NT${{ courses.course_price.toLocaleString() }}</div>
        <div @click="addCart(courses.id)" class="flex justify-end mt-[12px]">
          <button type="button"
            class="py-2 px-6 flex items-center rounded-full bg-blue-green text-main-white text-[18px] font-normal max-sm:text-[12px] max-sm:px-4 hover:bg-lake-green" :class="{ 'bought': boughtArray.includes(courses.id) }">
            <img :src="Cart" alt="" class="mr-4">加入購物車
          </button>
        </div>
        <div class="text-[36px] text-blue-green my-6 font-bold max-sm:text-[20px]">課程介紹：</div>
        <div class="text-[24px] font-normal font-JhengHei max-sm:text-[16px] break-words">{{ courses.detail_introduce }}</div>
      </div>
      <div class="flex flex-col">
        <div class="text-left text-[24px] font-bold text-blue-green max-sm:text-[16px]">付費課程，將於購買後解鎖。</div>
        <Maincourses :coursedata="courses" :chapterdata="chapter"></Maincourses>
      </div>
    </div>
  </div>
  <Footer />
  <!-- <Maincourses /> -->
</template>

<style scoped>
.title {
  @apply text-[64px] font-NotoSerif text-main-white font-bold
}
.bought{
  @apply bg-light-gary hover:bg-light-gary cursor-default
}

/* 寬度為1270px以下 */
@media screen and (max-width: 1269px) {
  .titlexl {
    @apply text-[52px] pt-[160px] pb-[80px]
  }

  .history_title {
    @apply text-[52px] h-[83px]
  }

  .hottitle {
    @apply text-[42px]
  }

  .hottext {
    @apply text-[28px]
  }

  .classlist {
    @apply text-light-gary font-JhengHei text-[28px] font-bold px-[24px] py-[8px]
  }
}

/* 寬度為600px以下 */
@media screen and (max-width: 599px) {
  .titlesm {
    @apply text-[32px] pt-[120px] pb-[60px]
  }

  .hottitle {
    @apply text-[24px]
  }

  .hottext {
    @apply text-[20px]
  }

  .about {
    @apply text-[16px]
  }

  .classlist {
    @apply text-light-gary font-JhengHei text-[20px] font-bold px-[24px] py-[8px]
  }
}
</style>

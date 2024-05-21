<script>
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import Input from '@/Components/Input.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import VectorDown from '/images/FrontEndIcon/Vector-down.png';
import Date from '/images/FrontEndIcon/date.png';
export default {
  components: {
    Link, Input, Navbar, Footer, Head,
  },
  props: {
    cartCount: Number,
    serviceData: Array,
    courseData: Array,
  },
  data() {
    return {
      vectorDown: VectorDown,
      date: Date,
      remitForm: {
        date: '',
        price: '',
        fiveNum: '',
      },
      orderDetail: {
        goodsId: [],
        goodsType: [],
        goodsPrice: [],
      },
    };
  },
  computed: {
    priceTotal() {
      let serviceTotal = 0;
      let courseTotal = 0;
      this.serviceData.forEach(goods => serviceTotal += goods.service.service_price);
      this.courseData.forEach(goods => courseTotal += goods.course.course_price);
      return serviceTotal + courseTotal;
    },
  },
  mounted() {
    this.serviceData.forEach(goods => {
      this.orderDetail.goodsId.push(goods.goods_id);
      this.orderDetail.goodsType.push(goods.goods_type);
      this.orderDetail.goodsPrice.push(goods.service.service_price);
    });
    this.courseData.forEach(goods => {
      this.orderDetail.goodsId.push(goods.goods_id);
      this.orderDetail.goodsType.push(goods.goods_type);
      this.orderDetail.goodsPrice.push(goods.course.course_price);
    });
  },
  methods: {
    focusDate() {
      const inputElement = this.$refs.dateInput.$el.querySelector('input');
      inputElement.showPicker();
    },
    sendRemittance() {
      // 購物車為空不能匯款
      if (!this.cartCount) {
        Swal.fire({
          title: '購物車為空!',
          buttonsStyling: false,
          customClass: {
            popup: 'w-[330px]',
            title: 'font-JhengHei text-black border-0 pt-[20px] pb-4',
            actions: 'w-[40%] mt-2',
            confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
          },
        });
        return ;
      }
      const fiveInput = document.querySelector('#number');
      if (fiveInput.value < 9999 || fiveInput.value > 99999) {
        fiveInput.focus();
        Swal.fire({
          title: '請填入正確末五碼格式!',
          buttonsStyling: false,
          customClass: {
            popup: 'w-[390px]',
            title: 'font-JhengHei text-black border-0 pt-[20px] pb-4',
            actions: 'w-[40%] mt-2',
            confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
          },
        });
        return ;
      }
      // 送出匯款資料
      Swal.fire({
        title: '是否送出匯款資料?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[330px]',
          title: 'font-JhengHei text-black border-0 pt-[20px] font-bold',
          actions: 'mt-2',
          confirmButton: 'swal-btn bg-blue-green text-white order-2 w-[130px]',
          cancelButton: 'swal-btn bg-white w-[130px]',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post(route('shopping.order'), { 'total': this.priceTotal, 'detailFrom': this.orderDetail, 'remitForm': this.remitForm });
        }
      });
    },
  },
};
</script>

<template>
  <Head title="付款頁"></Head>
  <Navbar />
  <header class="flex justify-center text-center mb-[60px] xl:mb-[120px] pt-[120px] sm:pt-[160px] xl:pt-[224px]">
    <h2 class="font-NotoSerif text-black text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider border-b-2 p-0 border-[#0B0B0B] sm:mb-[40px] mb-[16px] xl:mb-[16px] min-w-2/12 break-keep">付款說明</h2>
  </header>
  <main class="font-JhengHei flex flex-col items-center">
    <section class="w-11/12 xl:w-8/12 mb-[60px]">
      <h3 class="text-blue-green title mb-[30px]">付款說明</h3>
      <h4 class="text-[16px] sm:text-[24px] mb-6 font-bold">我們的唯一的付款方式為「轉帳」，恕不提供信用卡的選項。</h4>
      <div class="text-[20px] sm:text-[28px] xl:text-[24px] font-bold xl:font-normal sm:leading-[42.5px] xl:shadow-cardShadow sm:py-6 xl:px-[84px]">
        <p>您須匯款的金額為<span class="title text-blue-green">NT${{ priceTotal.toLocaleString() }}</span></p>
        <p>請匯款至戶名<span class="title">○○○</span></p>
        <p>帳戶<span class="title">XXXX-XXXX-XXXX-XXXXXX</span></p>
        <p>匯款後，請填寫下列表格，告知我們您的匯款帳號後五碼，客服將即刻為您處理。</p>
      </div>
    </section>

    <section class="w-11/12 xl:w-8/12 relative">
      <h3 class="text-blue-green title mb-[30px]">輸入轉帳資料</h3>
      <form class="flex flex-col gap-y-4 sm:pl-[33px] w-full sm:w-[43%] xl:w-[28%] mb-[30px] sm:mb-[60px]" @submit.prevent="sendRemittance()">
        <Input
          title='匯款日期' type="date" name='date'
          :value-data="remitForm.date"
          @update="(value) => remitForm.date = value"
          ref='dateInput'
          class="dateInput"
        >
          <img :src="date" alt="日期" class="absolute top-3 left-[-30px] bg-main-white p-1">
          <img :src="vectorDown" alt="select" class="absolute top-3 right-2 bg-white p-2 cursor-pointer" @click="focusDate()">
        </Input>
        <Input
          title='匯款金額' type="number" name='price'
          :value-data="remitForm.price"
          @update="(value) => remitForm.price = value"
        />
        <Input
          title='匯款帳號後五碼' type="number" name='number'
          :value-data="remitForm.fiveNum"
          @update="(value) => remitForm.fiveNum = value"
        />

        <div class="flex justify-between xl:justify-center w-full absolute bottom-[-42px] sm:top-[320px] left-0 gap-x-[16px] sm:gap-x-[32px] xl:gap-x-[120px]">
          <Link :href="route('shopping.index')" class="button">返回購物車</Link>
          <button type="submit" class="button">送出匯款資料</button>
        </div>
      </form>
    </section>

  </main>
  <Footer class="mt-[102px] sm:mt-[140px] xl:mt-[174px]" />
</template>

<style scoped>
.title{
  @apply text-[20px] sm:text-[28px] xl:text-[32px] font-bold
}
.button{
  @apply text-[16px] sm:text-[24px] text-center py-2 w-[163.5px] sm:w-[320px] sm:h-[56px] border border-blue-green text-blue-green rounded-md hover:bg-lake-green hover:text-white
}
.dateInput{
  width: 93% !important;
  @media screen and (min-width: 600px) {
    width: 100% !important;
  };
  @apply ml-auto sm:w-auto sm:ml-0
}
</style>

<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import DeleteIcon from '/images/FrontEndIcon/Vector.png';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    Link, Navbar, Footer, Head,
  },
  props: {
    userData: Object,
    serviceData: Array,
    courseData: Array,
  },
  data() {
    return {
      deleteIcon: DeleteIcon,
      orderTotal: '',
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
    goodsTotal() {
      const serviceTotal = this.serviceData.length;
      const courseTotal = this.courseData.length;
      return serviceTotal + courseTotal;
    },
  },
  methods: {
    deleteItem(id) {
      Swal.fire({
        title: '是否確定刪除?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[300px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-blue-green text-white order-2',
          cancelButton: 'swal-btn bg-white',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post(route('shopping.delete'), { 'goodsId': id }, {
            preserveState: false,
            preserveScroll: true,
          });
        }
      });
    },
    goPay() {
      this.orderTotal = this.priceTotal;
      // 購物車為空不能匯款
      if (Number(this.orderTotal) === 0) {
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
      this.$inertia.get('/shopping/payment');
    },
  },
};
</script>

<template>
  <Head title="購物車"></Head>
  <Navbar />
  <header class="flex justify-center text-center mb-[60px] xl:mb-[120px] pt-[120px] sm:pt-[160px] xl:pt-[224px]">
    <h2 class="font-NotoSerif text-black text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider border-b-2 p-0 border-[#0B0B0B] sm:mb-[40px] mb-[16px] xl:mb-[16px] min-w-2/12 break-keep">購物車</h2>
  </header>
  <main class="font-JhengHei flex flex-col items-center">
    <!-- 會員資料 -->
    <section class="py-6 px-8 shadow-cardShadow w-11/12 xl:w-7/12 mb-[60px]">
      <h3 class="text-[20px] sm:text-[32px] font-bold border-b border-light-gary pb-[12px]">會員資料</h3>
      <ul class="text-[18px] mt-[12px] flex flex-col gap-y-2">
        <li>{{ userData.name }}</li>
        <li>{{ userData.member.member_phone }}</li>
        <li>{{ userData.email }}</li>
      </ul>
    </section>
    <!-- 購買的服務 -->
    <section class="flex flex-col items-start w-11/12 xl:w-7/12 mb-[24px] sm:mb-[30px]">
      <h3 class="font-bold text-blue-green title mb-[30px]">服務</h3>
      <table class="w-full font-bold">
        <tr class="w-full border-b border-dark-gray">
          <th class="w-2/12 text-dark-gray">項次</th>
          <th class="w-7/12">品項</th>
          <th class="w-2/12">金額</th>
          <th class="w-1/12"></th>
        </tr>
        <!-- 購物車品項 -->
        <tr class="border-b-2 border-light-gray flex flex-wrap sm:table-row" v-for="(goods, index) in serviceData" :key="index">
          <td class="pl-6 text-dark-gray w-2/12">{{ index + 1 }}</td>
          <td class="w-10/12 sm:w-auto pr-6 sm:pr-2">{{ goods.service.service_name }}</td>
          <td class="price">NT${{ goods.service.service_price.toLocaleString() }}</td>
          <td class="delete">
            <img :src="deleteIcon" alt="移除" class="min-w-[24px] w-[24px] sm:w-[30px] h-max" @click="deleteItem(goods.id)">
          </td>
        </tr>
        <tr class="flex flex-wrap justify-between sm:table-row" v-if="serviceData.length < 1">
          <td class="text-dark-gray nonetext" colspan="4">無購買服務</td>
        </tr>
      </table>
    </section>

    <!-- 購買的課程 -->
    <section class="flex flex-col items-start w-11/12 xl:w-7/12 mb-[30px] sm:mb-[60px]">
      <h3 class="font-bold text-blue-green title mb-[30px]">課程</h3>
      <table class="w-full font-bold">
        <tr class="w-full border-b border-dark-gray">
          <th class="w-2/12 text-dark-gray">項次</th>
          <th class="w-7/12">品項</th>
          <th class="w-2/12">金額</th>
          <th class="w-1/12"></th>
        </tr>
        <!-- 購物車品項 -->
        <tr class="border-b-2 border-light-gray flex flex-wrap sm:table-row" v-for="(goods, index) in courseData" :key="index">
          <td class="pl-6 text-dark-gray w-2/12">{{ index + 1 }}</td>
          <td class="w-10/12 sm:w-auto pr-6 sm:pr-2">{{ goods.course.course_name }}</td>
          <td class="price">NT${{ goods.course.course_price.toLocaleString() }}</td>
          <td class="delete">
            <img :src="deleteIcon" alt="移除" class="min-w-[24px] w-[24px] sm:w-[30px] h-max" @click="deleteItem(goods.id)">
          </td>
        </tr>

        <tr class="flex flex-wrap justify-between sm:table-row" v-if="courseData.length < 1">
          <td class="text-dark-gray nonetext" colspan="4">無購買課程</td>
        </tr>
        <tr v-if="courseData.length < 1" class="flex">
          <td class="nonetd" colspan="4"></td>
        </tr>

        <tr class="flex sm:table-row px-[10px] sm:px-0">
          <td class="total text-dark-gray">共計{{ goodsTotal }}項</td>
          <td class="total text-dark-gray text-end sm:pr-6">合計"</td>
          <td class="total text-blue-green text-end sm:text-start" colspan="2">NT${{ priceTotal.toLocaleString() }}</td>
        </tr>
      </table>
    </section>

    <div class="flex justify-center mb-[60px] sm:mb-[80px] xl:mb-[120px] w-11/12 xl:w-7/12">
      <div class="flex justify-center gap-x-[16px] sm:gap-x-[120px] w-full xl:w-[80%]">
        <Link :href="route('services')" class="button">繼續看課程</Link>
        <Link @click="goPay()" class="button">匯款去</Link>
      </div>
    </div>
  </main>
  <Footer />
</template>

<style scoped>
.title{
  @apply text-[20px] sm:text-[28px] xl:text-[32px]
}
th{
  @apply text-dark-gray font-bold text-[24px] hidden sm:table-cell text-start
}
td{
  @apply text-[20px] sm:text-[28px] xl:text-[32px] py-4
}
.price{
  @apply text-blue-green text-[16px] sm:text-[24px] w-6/12 sm:w-auto pt-0 sm:pt-4 ml-auto
}
.delete{
  @apply p-0 pr-10 sm:pl-6 w-4/12 sm:w-auto flex justify-end sm:table-cell cursor-pointer hover:opacity-90
}
.total{
  @apply text-[16px] sm:text-[24px] break-keep w-4/12 sm:w-auto
}
.button{
  @apply text-[16px] sm:text-[24px] text-center py-2 w-[148px] sm:w-[277px] xl:w-[320px] border border-blue-green text-blue-green rounded-md hover:bg-lake-green hover:text-white
}
.nonetext{
  @apply text-[22px]
}
.nonetd{
  @apply p-0 py-1
}
</style>

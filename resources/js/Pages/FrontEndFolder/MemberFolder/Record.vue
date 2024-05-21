<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import MemberNavbar from '@/Components/MemberNavbar.vue';
import VectorUp from '/images/FrontEndIcon/Vector-up.png';
import VectorDown from '/images/FrontEndIcon/Vector-down.png';
import { Link, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    MemberNavbar, Navbar, Footer, Link, Head,
  },
  props: {
    // controller回傳要渲染的資料
    orderData: Object,
    // controller回傳現在是desc還是asc
    sort: {
      type: String,
      default: 'desc',
    },
    // controller回傳現在是依照哪個欄位排
    column: {
      type: String,
      default: 'created_at',
    },
  },
  data() {
    return {
      vectorUp: VectorUp,
      vectorDown: VectorDown,
      sortType: this.sort === 'desc' ? true : false, // (初始倒序)
    };
  },
  computed: {
    // 換前後頁碼圖示 往前&lsaquo; 往後&rsaquo;
    pagination() {
      const pagination = this.orderData.links.map(page => {
        page.label = page.label.replace('&laquo; Previous', '&lsaquo;').replace('Next &raquo;', '&rsaquo;');
        return page;
      });
      return pagination;
    },
  },
  methods: {
    // 排序日期跟價格
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('record.sortData'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'nowpage': this.nowpage },
        preserveState: true,
        preserveScroll: true,
      });
    },
    // 排序圖示(上下箭頭切換)
    sortArrow(column) {
      if (this.sortType && this.column === column) {
        return this.vectorDown;
      }
      return this.vectorUp;
    },
    // 判斷類型來選擇渲染服務還是課程名稱
    orderDetail(goods) {
      return goods.goods_type === 1 ? goods.service.service_name : goods.course.course_name;
    },
    // 判斷status來顯示訂單狀態
    orderStatus(order) {
      switch (order.order_status) {
      case 1:
        return '待客服確認款項';
      case 2:
        return '收到款項，課程已解鎖';
      case 3:
        return '尚未付款';
      case 4:
        return '訂單取消';
      default:
        return '待客服確認款項'; // 預設情況
      }
    },
    // 轉換日期格式
    dateFormat(date) {
      return date.split('T')[0].replace(/-/g, '/');
    },
  },
};
</script>

<template>
  <Head title="購買紀錄"></Head>
  <Navbar />
  <MemberNavbar :nowpage="3"></MemberNavbar>
  <div class="wrap">
    <section class="section">
      <div class="flex flex-col w-[95%] xl:w-8/12 py-[24px] gap-x-[20px] gap-y-5 flex-wrap justify-center bg-white rounded-md px-[16px] sm:px-[24px] shadow-cardShadow">
        <div class="flex items-center justify-between">
          <h3 class="text-black font-JhengHei text-[30px] sm:text-[32px]">購買紀錄</h3>
          <span class="text-sm sm:text-[18px] text-dark-gray">僅保留六個月內資料</span>
        </div>
        <div class="flex" v-if="!orderData.data.length">
          <h3 class="text-dark-gray text-xl">尚未購買任何課程/服務</h3>
        </div>
        <div class="w-full" v-else>
          <!-- 平板以上課程卡片 -->
          <table class="mb-4 hidden sm:table w-full">
            <thead class="bg-blue-green">
              <tr class="text-white font-bold">
                <th class="sm:cursor-pointer" @click="sortData('created_at')">
                  <span class="relative pr-2">
                    日期
                    <img :src="sortArrow('created_at')" class="vector  right-[-12px]"> <!-- 上下箭頭圖示 -->
                  </span>
                </th>
                <th>購買項目</th>
                <th class="sm:cursor-pointer" @click="sortData('total')">
                  <span class="relative pr-4">
                    價格
                    <img :src="sortArrow('total')" class="vector  right-[-3px]"> <!-- 上下箭頭圖示 -->
                  </span>
                </th>
                <th>付款方式</th>
                <th>訂單狀態</th>
              </tr>
            </thead>
            <tbody class="pc">
              <!-- order渲染 -->
              <tr v-for="(order, index) in orderData.data ?? []" :key="index">
                <td>{{ dateFormat(order.created_at) }}</td>
                <td class="p0">
                  <!-- 購買項目渲染 -->
                  <ul class="flex flex-col w-full" v-for="(goods, index) in order.order_detail" :key="index">
                    <li class="record" :class="{ 'lastNone': index + 1 === order.order_detail.length }">{{ orderDetail(goods) }}</li>
                  </ul>
                </td>
                <td>{{ order.total.toLocaleString() }}</td>
                <td>匯款</td>
                <td>{{ orderStatus(order) }}</td>
              </tr>
            </tbody>
          </table>
          <!-- 手機板課程卡片 -->
          <table class="mb-4 phone sm:hidden w-full">
            <tbody v-for="(order, index) in orderData.data ?? []" :key="index">
              <!-- order渲染 -->
              <tr>
                <th>日期</th>
                <td>{{ dateFormat(order.created_at) }}</td>
              </tr>
              <tr>
                <th>購買項目</th>
                <td class="p0">
                  <!-- 購買項目渲染 -->
                  <ul class="w-full" v-for="(goods, index) in order.order_detail" :key="index">
                    <li class="record" :class="{ 'lastNone': index + 1 === order.order_detail.length }">{{ orderDetail(goods) }}</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <th>價格</th>
                <td>{{ order.total.toLocaleString() }}</td>
              </tr>
              <tr>
                <th>付款方式</th>
                <td>匯款</td>
              </tr>
              <tr>
                <th>訂單狀態</th>
                <td>{{ orderStatus(order) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- 分頁器 -->
      <div class="pagination">
        <div v-for="(link, index) in pagination" :key="index">
          <Link v-if="link.url" :href="link.url" class="page" :class="{ 'nowpage': link.active }">
            <span v-html="link.label"></span>
          </Link>
          <Link v-else :href="link.url" class="none">
            <span v-html="link.label"></span>
          </Link>
        </div>
      </div>
    </section>
  </div>
  <Footer></Footer>
</template>

<style scoped>
table, th, td{
  @apply border border-light-gary text-[16px] sm:text-2xl p-[8px] xl:px-4 py-[10px] font-JhengHei text-center
}
.pc>tr:nth-of-type(even){
  @apply bg-main-white
}
.p0{
  padding: 0;
}
.record{
  @apply border-b border-light-gary p-[8px] xl:px-4 xl:py-[10px] text-start
}
.lastNone {
  @apply border-b-0
}
.page{
  @apply px-[10px] py-1 cursor-pointer mt-6 hover:bg-gray-200
}
.pagination{
  @apply flex text-dark-gray select-none gap-x-1 text-[24px] sm:text-[18px] mt-[26px]
}
.nowpage{
  @apply bg-blue-green text-white rounded hover:bg-blue-green
}
.none{
  @apply px-[10px] py-1 select-none mt-6 text-light-gary cursor-default
}
.wrap{
  min-height: calc(100vh - (305px + 256px));
}
th{
  @apply bg-blue-green text-white font-bold
}
table.phone td{
  @apply text-start
}
table.phone > tbody:nth-of-type(even){
  @apply bg-main-white
}
table.phone th{
  @apply w-3/12
}
.vector{
  @apply brightness-[3] absolute top-3
}
.section{
  @apply flex flex-col items-center w-full pt-[30px] sm:pt-[60px] mb-[60px] sm:mb-[80px] xl:mb-[120px] xl:w-11/12 m-auto
}
.norecord{
  @apply fixed bottom-0
}
</style>

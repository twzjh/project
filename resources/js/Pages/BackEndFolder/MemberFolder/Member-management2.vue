<script>
import BackendNav from '@/Components/BackendNav.vue';
import chevronLeft from '/images/BackEndIcon/chevron-left.svg';
import chevronRight from '/images/BackEndIcon/chevron-right.svg';
import chevronUp from '/images/BackEndIcon/chevron-up.svg';
import chevronDown from '/images/BackEndIcon/chevron-down.svg';
import { Link, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Link,
    Head,
  },
  props: {
    userData: Object,
    orderData: Object,
    sort: {
      type: String,
      default: 'desc',
    },
    column: {
      type: String,
      default: 'created_at',
    },
  },
  data() {
    return {
      chevronLeft,
      chevronRight,
      chevronDown,
      chevronUp,
      userId: this.userData.id,
      sortType: this.sort === 'desc' ? true : false, // (初始倒序)
    };
  },
  computed: {
    // 換前後頁碼
    pagination() {
      const pagination = this.orderData.links.map(page => {
        page.label = page.label.replace('&laquo; Previous', '&lsaquo;').replace('Next &raquo;', '&rsaquo;');
        return page;
      });
      return pagination;
    },
  },
  methods: {
    // 跳轉到會員編輯頁
    editPage() {
      this.$inertia.get(route('backmember.edit'), { 'userId': this.userData.id });
    },
    // 排序日期跟價格
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('backmember.sortData'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'userId': this.userData.id },
        preserveState: true,
      });
    },
    // 排序圖示(上下箭頭切換)
    sortArrow(column) {
      if (this.sortType && this.column === column) {
        return this.chevronDown;
      }
      return this.chevronUp;
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

<style scoped>
tbody:nth-child(odd) {
  background-color: #e6e6e6;
  /* 設定偶數行的背景色 */
}
.record{
  @apply border-b border-light-gary p-[8px] xl:px-4 xl:py-[10px] text-start
}
.lastNone {
  @apply border-b-0
}
.pagination{
  @apply flex text-dark-gray select-none gap-x-1 text-[24px] sm:text-[18px] pl-10 mt-6 mb-10
}
.page{
  @apply px-[10px] py-1 cursor-pointer mt-6 hover:bg-gray-200
}
.none{
  @apply px-[10px] py-1 select-none mt-6 text-light-gary cursor-default
}
.nowpage{
  @apply bg-dark-gray text-white rounded hover:bg-dark-gray
}
.noresult{
  @apply text-dark-gray text-[22px] text-center py-3
}
</style>

<template>
  <Head title="後臺會員購買紀錄"></Head>
  <BackendNav>
    <template v-slot:title><h2 class="pl-10 pt-4 font-JhengHei text-2xl font-bold flex leading-[40px]">
      <Link @click="editPage()"
        class=" font-JhengHei text-lg bg-dark-dark-gary w-[88px] h-[40px] rounded text-white cursor-pointer mr-4 pt-[6px] text-center">
        ‹&nbsp;返回</Link>會員管理 ▸ {{ userData.name }}
    </h2></template>
    <template v-slot:content><main>

      <div class="w-full h-4 shadow-xl mb-5"></div>
      <div class="flex">
        <Link @click="editPage()"
          class="ml-10 text-2xl font-JhengHei p-3 border-2 border-dark-gray w-[146px] rounded text-bg-dark-gray mb-5 text-center cursor-pointer">
          個人資料
        </Link>
        <div
          class="ml-5 text-2xl font-JhengHei p-3 bg-dark-gray w-[146px] rounded text-white mb-5 text-center cursor-pointer">
          購買紀錄
        </div>
      </div>
      <table class="w-[95%] ml-10 border border-light-light-gary text-center text-2xl font-medium font-JhengHei">
        <thead>
          <tr class="bg-dark-gray text-white">
            <th class="w-[160px] py-2 border border-light-light-gary ">
              <div class="flex justify-center items-center cursor-pointer" @click="sortData('created_at')">
                <span class="text-center">日期</span>
                <img :src="sortArrow('created_at')" class="w-[10px] h-[10px] ms-2">
              </div>
            </th>
            <th class="w-[300px] py-2 border border-light-light-gary">購買項目</th>
            <th class="w-[160px] py-2 border border-light-light-gary">
              <div class="flex justify-center items-center cursor-pointer" @click="sortData('total')">
                <span class="text-center">價格</span>
                <img :src="sortArrow('total')" class="w-[10px] h-[10px] ms-2">
              </div>
            </th>
            <th class="w-[160px] py-2 px-4 border border-light-light-gary">付款方式</th>
            <th class="w-[280px] py-2 px-4 border border-light-light-gary">訂單狀態</th>
          </tr>
        </thead>
        <tbody v-for="order in orderData.data ?? []" :key="order.id">
          <tr>
            <td class="px-3 py-3 border border-light-light-gary" rowspan="4">{{ dateFormat(order.created_at) }}</td>
            <td class="border border-light-light-gary p-0">
              <ul class="flex flex-col w-full" v-for="(goods, index) in order.order_detail" :key="index">
                <li class="record" :class="{ 'lastNone': index + 1 === order.order_detail.length }">{{ orderDetail(goods) }}</li>
              </ul>
            </td>
            <td class="px-3 py-3 border border-light-light-gary" rowspan="4">{{ order.total.toLocaleString() }}</td>
            <td class="p-3 border border-light-light-gary" rowspan="4">轉帳</td>
            <td class="p-3 border border-light-light-gary" rowspan="4">{{ orderStatus(order) }}</td>
          </tr>
        </tbody>
        <!-- 如果沒有購買紀錄 -->
        <tbody v-if="!orderData.data.length">
          <td class="noresult">尚未有購買紀錄</td>
        </tbody>
      </table>

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

    </main></template>

  </BackendNav>
</template>

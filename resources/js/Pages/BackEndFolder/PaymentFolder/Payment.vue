<script>
import BackendNav from '@/Components/BackendNav.vue';
import VectorUp from '/images/BackEndIcon/backend-up.png';
import VectorDown from '/images/BackEndIcon/backend-down.png';
import Search from '/images/BackEndIcon/search1.png';
import { Link, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Link,
    Head,
  },
  props: {
    orderData: Object,
    newStatusValue: {
      type: Number,
      default: 5,
    },
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
    // controller回傳keyword
    returnKeyword: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      vectorUp: VectorUp,
      vectorDown: VectorDown,
      sortType: this.sort === 'desc' ? true : false, // (初始倒序)
      search: Search,
      keyword: this.returnKeyword,
      statusValue: this.newStatusValue,
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
  watch: {
    statusValue(newValue) {
      this.paymentSelect(Number(newValue));
    },
  },
  methods: {
    // 判斷類型來選擇渲染服務還是課程名稱
    orderDetail(goods) {
      return goods.goods_type === 1 ? goods.service.service_name : goods.course.course_name;
    },
    edit(id) {
      this.$inertia.get(route('payment.edit'), { 'orderId': id });
    },
    // 排序日期跟價格
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('payment.sortData'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'status': this.statusValue, 'keyword': this.keyword },
        preserveState: true,
      });
    },
    // 排序圖示(上下箭頭切換)
    sortArrow(column) {
      if (this.sortType && this.column === column) {
        return this.vectorDown;
      }
      return this.vectorUp;
    },
    dateFormat(date) {
      return date.split('T')[0].replace(/-/g, '/');
    },
    // 搜尋關鍵字
    keywordSearch() {
      router.visit(route('payment.sortData'), {
        method: 'get',
        data: { 'keyword': this.keyword, 'status': this.statusValue },
        preserveState: false,
      });
    },
    // 篩選訂單狀態
    paymentSelect(statusValue) {
      router.visit(route('payment.sortData'), {
        method: 'get',
        data: { 'status': statusValue, 'keyword': this.keyword },
        preserveState: false,
      });
    },
    // 訂單狀態的名稱顯示
    paymentName(statusValue) {
      const status = Number(statusValue);
      if (status === 1) {
        return '待客服確認款項';
      } else if (status === 2) {
        return '收到款項，課程已解鎖';
      } else if (status === 3) {
        return '尚未付款';
      } else if (status === 4) {
        return '訂單取消';
      } else if (status === 5) {
        return '訂單成立';
      }
    },
  },
};
</script>

<template>
  <Head title="後臺付款紀錄"></Head>
  <BackendNav>
    <template v-slot:title>
      <!-- 最上層頁面名稱搜索分類列 -->
      <div class="full-container h-[48px] flex justify-between items-center p-5">
        <h1 class="text-[24px] font-bold font-JhengHei mt-5">付款記錄管理</h1>
        <div class="mt-5 flex">
          <label>
            <select v-model="statusValue" id="order" name="payment" class="w-[240px] h-[36px] p-0 mx-3 px-2 rounded font-JhengHei">
              <option value="0" disabled selected>訂單狀態</option>
              <option value="5">全部</option>
              <option value="3">尚未付款</option>
              <option value="1">待客服確認款項</option>
              <option value="2">收到款項，課程已解鎖</option>
              <option value="4">訂單取消</option>
            </select>
          </label>
          <label>
            <input type="text" id="searchInput" placeholder="搜尋會員名稱/信箱" class="w-[240px] h-[36px] p-0 px-2 rounded" v-model="keyword" @keyup.enter="keywordSearch()">
            <img :src="search" alt="搜尋" class="search-icon" @click="keywordSearch()">
          </label>
        </div>
      </div>
      <div class="w-full h-4 shadow-xl"></div>
    </template>
    <template v-slot:content>
      <main>
        <!-- 付款紀錄表 -->
        <div class="full-container p-5 text-[24px]">
          <table class="font-JhengHei text-center">
            <thead class="bg-dark-gray text-white">
              <tr class="p-4 border border-black">
                <th class="cursor-pointer p-2" @click="sortData('created_at')">
                  <span class="relative pr-2">
                    日期
                    <img :src="sortArrow('created_at')" class="vector right-[-12px]"> <!-- 上下箭頭圖示 -->
                  </span>
                </th>
                <th>購買項目</th>
                <th>會員名稱</th>
                <th>信箱</th>
                <th class="sm:cursor-pointer" @click="sortData('total')">
                  <span class="relative pr-4">
                    價格
                    <img :src="sortArrow('total')" class="vector right-[-3px]"> <!-- 上下箭頭圖示 -->
                  </span>
                </th>
                <th>付款方式</th>
                <th>訂單狀態</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody v-for="(order, index) in orderData.data" :key="order.id" :class="{ 'even-row': index % 2 === 1 }">
              <tr class="p-3">
                <td>{{ dateFormat(order.created_at) }}</td>
                <td>
                  <div v-for="(goods, index) in order.order_detail" :key="index" class="buy-items flex flex-col justify-start items-center">
                    <div class="item w-full border-0 border-b-2 border-light-light-gary p-2 pl-5 text-left">{{ orderDetail(goods) }}</div>
                  </div>
                </td>
                <td>{{ order.user.name }}</td>
                <td>{{ order.user.email }}</td>
                <td>{{ order.total.toLocaleString('zh-TW') }}</td>
                <td>匯款</td>
                <td>{{ paymentName(order.order_status) }}</td>
                <td>
                  <Link @click="edit(order.id)" class="inline-block bg-blue-green text-white py-2 px-6 rounded text-[18px]">
                    編輯
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>

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
      </main>
    </template>
  </BackendNav>

</template>

<style scoped>
.full-container {
  @apply w-[calc(100vw-270px)];
}
table {
  @apply w-full border-collapse;
}
th,
td {
  @apply border-[2px] border-light-light-gary text-center;
}
th {
  @apply text-white
}
.even-row {
  background-color: #e6e6e6;
}
.vector{
  @apply brightness-[3] absolute top-3
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
.search-label {
  @apply relative;
}
.search-icon {
  @apply absolute w-[20px] h-[20px] right-[50px] top-[105px] bg-center bg-no-repeat cursor-pointer;
}
.search-label input[type="text"] {
  @apply pr-[30px];
}
.buy-items:last-child > *:last-child {
  @apply border-b-0;
}

</style>

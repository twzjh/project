<script>
import BackendNav from '@/Components/BackendNav.vue';
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Link,
  },
  props: {
    orderData: Object,
  },
  methods: {
    // 判斷類型來選擇渲染服務還是課程名稱
    orderDetail(goods) {
      return goods.goods_type === 1 ? goods.service.service_name : goods.course.course_name;
    },
    edit(id) {
      this.$inertia.get(route('payment.edit'), { 'orderId': id });
    },
  },
};
</script>

<template>
  <BackendNav>
    <template v-slot:title>
      <!-- 最上層頁面名稱搜索分類列 -->
      <div class="full-container h-[48px] flex justify-between items-center p-5">
        <h1 class="text-[24px] font-bold font-JhengHei mt-5">付款記錄管理</h1>
        <div class="mt-5">
          <label>
            <select id="order" name="payment" class="w-[240px] h-[36px] p-0 mx-3 px-2 rounded font-JhengHei">
              <option value="">訂單狀態</option>
              <option value="all">全部</option>
              <option value="unpaid">尚未付款</option>
              <option value="pending">待客服確認款項</option>
              <option value="received">收到款項，課程已解鎖</option>
              <option value="cancelled">訂單取消</option>
            </select>
          </label>
          <label>
            <input type="text" id="searchInput" placeholder="搜尋會員名稱/信箱" class="w-[240px] h-[36px] p-0 px-2 rounded">
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
              <tr class="border border-black">
                <th class="p-2">日期 &#9660;</th>
                <th class="p-2">購買項目</th>
                <th class="p-2">會員名稱</th>
                <th class="p-2">信箱</th>
                <th class="p-2">價格 &#9660;</th>
                <th class="p-2">付款方式</th>
                <th class="p-2">訂單狀態</th>
                <th class="p-2">操作</th>
              </tr>
            </thead>
            <tbody v-for="(order, index) in orderData" :key="order.id" :class="{ 'bg-light-light-gary': index % 2 === 1 }">
              <tr class="p-3">
                <td>{{ order.created_at.split('T')[0].replace(/-/g, '/') }}</td>
                <td>
                  <div v-for="(goods, index) in order.order_detail" :key="index" class="flex flex-col justify-center items-center">
                    <div class="buy-items w-full border-0 border-b-2 py-2">{{ orderDetail(goods) }}</div>
                  </div>
                </td>
                <td>{{ order.user.name }}</td>
                <td>{{ order.user.email }}</td>
                <td>{{ order.total.toLocaleString('zh-TW') }}</td>
                <td>匯款</td>
                <td>已匯款</td>
                <td>
                  <Link @click="edit(order.id)" class="inline-block bg-blue-green text-white py-2 px-6 rounded text-[18px]">
                    編輯
                  </Link>
                </td>
              </tr>
              <!-- <tr class="p-3 bg-light-light-gary">
                <td>2024/03/19</td>
                <td>
                  <div class="flex flex-col justify-center items-center">
                    <div class="buy-items w-full border-0 border-b-2">核彈</div>
                    <div class="buy-items w-full border-0 border-b-2">核彈</div>
                    <div class="buy-items w-full border-0 border-b-2">核彈</div>
                  </div>
                </td>
                <td>習敬平</td>
                <td>xxx@gmail.com</td>
                <td>3,000,000</td>
                <td>匯款</td>
                <td>已匯款</td>
                <td>
                  <Link :href="route('payment.edit')" class="inline-block bg-blue-green text-white py-2 px-6 rounded text-[18px]">
                    編輯
                  </Link>
                </td>
              </tr> -->
            </tbody>
          </table>
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
  @apply border-[2px] border-light-gary text-center;
}

th {
  @apply text-white
}

/* td .buy-items:nth-last-child(1) {
  @apply border-b-0;
} */
</style>

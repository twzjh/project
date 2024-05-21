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
    response: Object,
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
    returnKeyword: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      jumpAdd: 0,
      jumpEdit: 0,
      selectedContact: '', // 儲存選中的聯絡紀錄
      vectorUp: VectorUp,
      vectorDown: VectorDown,
      search: Search,
      sortType: this.sort === 'desc' ? true : false,
      keyword: this.returnKeyword,
    };
  },
  computed: {
    // 換前後頁碼圖示 往前&lsaquo; 往後&rsaquo;
    pagination() {
      const pagination = this.response.links.map(page => {
        page.label = page.label.replace('&laquo; Previous', '&lsaquo;').replace('Next &raquo;', '&rsaquo;');
        return page;
      });
      return pagination;
    },
  },
  methods: {
    callUsEdit(contact) {
      this.selectedContact = contact; // 將選中的聯絡記錄存在 selectedContact 中
      this.jumpAdd = 1; // 彈出詳細內容視窗
    },
    // 排序日期
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('callus.sortData'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'keyword': this.keyword },
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
    deleteFile(id) {
      Swal.fire({
        title: '是否確定刪除?',
        html: '<span class="font-JhengHei text-dark-gray text-[24px]">刪除後無法復原</span>',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[300px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
          cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post(route('callus.delete'), { id: id },
            {
              onSuccess: (res) => {
                const msg = res.props.flash.message;
                Swal.fire(msg);
              },
            });
        }
      });
    },
    // 搜尋名字
    keyWords() {
      router.visit(route('callus.sortData'), {
        method: 'get',
        data: { 'keyword': this.keyword },
        preserveState: true,
      });
    },
    // 轉換日期格式
    dateFormat(date) {
      return date.split('T')[0].replace(/-/g, '/');
    },
  },
};
</script>

<template>
  <Head title="後臺聯絡我們"></Head>
  <BackendNav>
    <template v-slot:title>
      <!-- 最上層頁面名稱搜索列 -->
      <div class="pt-3 flex justify-between items-center px-5">
        <h1 class="text-[24px] font-bold font-JhengHei pl-5">聯絡我們記錄</h1>
        <div class="px-3">
          <label>
            <input type="text" placeholder="搜尋姓名" class="w-[240px] h-[36px] px-2 rounded" @keyup.enter="keyWords()" v-model="keyword">
            <img :src="search" alt="搜尋" class="search-icon" @click="keyWords()">
          </label>
        </div>
      </div>
      <div class="w-full h-4 shadow-xl"></div>
    </template>
    <template v-slot:content>
      <main>
        <div class="full-container flex flex-col items-start">
          <div class=" w-[80%] text-end text-[24px] font-semibold text-dark-gray mt-5 ml-14">
            <span>紀錄僅保留六個月</span>
          </div>
          <!-- 聯絡紀錄表 -->
          <div class="w-[80%] p-3 ml-20 flex flex-col justify-center items-center">
            <table class="font-JhengHei text-center text-[24px]">
              <thead class="bg-dark-gray text-white">
                <tr class="p-4 border border-black">
                  <th class="cursor-pointer" @click="sortData('created_at')">
                    <span class="relative pr-2">
                      日期
                      <img :src="sortArrow('created_at')" class="vector  right-[-12px]"> <!-- 上下箭頭圖示 -->
                    </span>
                  </th>
                  <th>姓名</th>
                  <th class="w-[60%]">主旨</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <tr class="p-3" v-for="contact in response.data" :key="contact.id">
                  <td>{{ dateFormat(contact.created_at) }}</td>
                  <td>{{ contact.contact_name }}</td>
                  <td class="text-start">{{ contact.contact_main }}</td>
                  <td>
                    <button type="button"
                      class="inline-block bg-main-white text-main-red border border-main-red py-2 px-3 mr-3 rounded"
                      @click="deleteFile(contact.id)">刪除</button>
                    <button type="button" class="inline-block bg-blue-green text-white py-2 px-3 rounded"
                      @click="callUsEdit(contact)">查看</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- 分頁器 -->
            <div class="pagination" v-if="pagination.length >= 4">
              <div v-for="(link, index) in pagination" :key="index">
                <Link v-if="link.url" :href="link.url" class="page" :class="{ 'nowpage': link.active }">
                  <span v-html="link.label"></span>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </main>
    </template>
  </BackendNav>
  <!-- 查看彈跳視窗 -->
  <div v-if="jumpAdd === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[15%] left-[50%] translate-x-[-50%] bg-white rounded">
        <div class="w-[580px] h-[604px] flex flex-col font-JhengHei rounded">
          <div class="bg-dark-gray text-white text-2xl p-3">詳細內容</div>
          <div
            class="bg-main-white text-black w-[35px] px-3 py-1 text-center rounded absolute ml-[525px] mt-3 border border-gray-500 cursor-pointer"
            @click="jumpAdd = 0">X</div>
          <div class="flex">
            <table class="font-JhengHei text-center text-[24px]">
              <thead class="bg-light-gary text-white">
                <tr>
                  <th class="w-[150px]">日期</th>
                  <td class="bg-white text-black">{{ dateFormat(selectedContact.created_at) }}</td>
                </tr>
                <tr>
                  <th class="w-[150px]">姓名</th>
                  <td class="bg-white text-black">{{ selectedContact.contact_name }}</td>
                </tr>
                <tr>
                  <th class="w-[150px]">電話</th>
                  <td class="bg-white text-black">{{ selectedContact.contact_tel }}</td>
                </tr>
                <tr>
                  <th class="w-[150px]">E-amil</th>
                  <td class="bg-white text-black">{{ selectedContact.contact_email }}</td>
                </tr>
                <tr>
                  <th class="w-[150px]">主旨</th>
                  <td class="bg-white text-black">{{ selectedContact.contact_main }}</td>
                </tr>
              </thead>
            </table>
          </div>
          <div class="overflow-y-scroll h-[300px] py-5 px-6 text-[24px] break-words" id="scroll-area">
            {{ selectedContact.contact_content }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* .full-container {
  @apply w-[calc(100vw-270px)];
} */
table {
  @apply w-full border-collapse;
}
th,
td {
  @apply border-[2px] border-light-gary p-[8px] text-center;
}
th {
  @apply text-white;
}
.vector {
  @apply brightness-[3] absolute top-[13px];
}
.page{
  @apply px-[10px] py-1 cursor-pointer mt-6
}
.pagination{
  @apply flex text-dark-gray select-none gap-x-1 text-[18px] mt-[24px]
}
.nowpage{
  @apply bg-dark-gray text-white rounded
}
input[type="search"]::-webkit-search-cancel-button{
  -webkit-appearance: none;
  content: url('/resources/images/FrontEndIcon/close.svg');
  cursor: pointer;
  transform: translateX(8px);
  @apply hover:opacity-80
}
.search-icon {
  @apply absolute w-[20px] h-[20px] right-[60px] top-[100px] bg-center bg-no-repeat cursor-pointer;
}
/* 設置卷軸寬度 */
#scroll-area::-webkit-scrollbar {
  width: 12px;
}
#scroll-area::-webkit-scrollbar-track {
  @apply bg-light-light-gary rounded-md
}
/* 設置卷軸 */
#scroll-area::-webkit-scrollbar-thumb {
  @apply bg-dark-gray hover:bg-dark-gray/90 rounded-md h-[33px]
}
</style>

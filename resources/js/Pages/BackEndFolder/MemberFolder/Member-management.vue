<script>
import BackendNav from '@/Components/BackendNav.vue';
import chevronLeft from '/images/BackEndIcon/chevron-left.svg';
import chevronRight from '/images/BackEndIcon/chevron-right.svg';
import chevronUp from '/images/BackEndIcon/chevron-up.svg';
import chevronDown from '/images/BackEndIcon/chevron-down.svg';
import searchIcon from '/images/BackEndIcon/search1.png';
import addMemberComponent from '@/Components/add-member.vue';
import { Link, router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    addMemberComponent,
    Link,
    Head,
  },
  props: {
    memberData: Object,
    errors: Object,
    sort: {
      type: String,
      default: 'desc',
    },
    column: {
      type: String,
      default: 'created_at',
    },
    returnKeyword: {
      type: String,
      default: '',
    },
    jumpNow: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      chevronLeft,
      chevronRight,
      chevronDown,
      chevronUp,
      searchIcon,
      jumpAdd: this.jumpNow,
      sortType: this.sort === 'desc' ? true : false, // (初始倒序)
      keyword: this.returnKeyword,
    };
  },
  computed: {
    // 換前後頁碼
    pagination() {
      const pagination = this.memberData.links.map(page => {
        page.label = page.label.replace('&laquo; Previous', '&lsaquo;').replace('Next &raquo;', '&rsaquo;');
        return page;
      });
      return pagination;
    },
  },
  methods: {
    toggleAddMember() {
      if (this.jumpAdd === 0) {
        this.jumpAdd = 1;
      } else {
        this.jumpAdd = 0;
      }
    },
    // 刪除會員帳號
    deleteMember(id) {
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
          this.$inertia.post(route('backmember.delete'), { 'userId': id });
        }
      });
    },
    // 編輯會員帳號
    editMember(id) {
      this.$inertia.get(route('backmember.edit'), { 'userId': id });
    },
    // 排序日期跟價格
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('backmember.sortMember'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'keyword': this.keyword },
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
    // 搜尋關鍵字
    keywordSearch() {
      this.$inertia.get(route('backmember.sortMember'), { keyword: this.keyword });
    },
  },
};
</script>

<style scoped>
tr:nth-child(even) {
  background-color: #e6e6e6;
  /* 設定偶數行的背景色 */
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
#search{
  @apply absolute right-[24px] top-[90px] w-[240px] rounded
}
.searchIcon{
  @apply absolute h-5 bg-white right-[35px] top-[100px] z-[2] cursor-pointer
}
</style>

<template>
  <Head title="後臺會員管理"></Head>
  <BackendNav class="relative">
    <template v-slot:title>
      <h2 class="pl-10 pt-4 font-JhengHei text-2xl font-bold">會員管理</h2>
      <input type="search" name="search" id="search" placeholder="搜尋會員名稱/電話" v-model="keyword" @keyup.enter="keywordSearch()">
      <img :src="searchIcon" alt="搜尋" class="searchIcon" @click="keywordSearch()">
    </template>
    <template v-slot:content><main>

      <div class="w-full h-4 shadow-xl mb-5"></div>
      <div class="ml-10 text-2xl font-JhengHei p-3 bg-dark-gray w-[146px] rounded text-white mb-5 text-center cursor-pointer" @click="toggleAddMember">新增會員
      </div>
      <table class="w-[95%] ml-10 border border-light-light-gary text-center text-2xl font-medium font-JhengHei">
        <thead>
          <tr class="bg-dark-gray text-white">
            <th class="w-[160px] py-2 px-4 border border-light-light-gary">
              <div class="flex justify-center items-center cursor-pointer" @click="sortData('id')">
                <span class="text-center">會員編號</span>
                <img :src="sortArrow('id')" alt="" class="w-[10px] h-[10px] ms-2">
              </div>
            </th>
            <th class="w-[280px] py-2 border border-light-light-gary">姓名</th>
            <th class="w-[160px] py-2 px-4 border border-light-light-gary">
              <div class="flex justify-center items-center cursor-pointer" @click="sortData('member_birthday')">
                <span class="text-center">出生日期</span>
                <img :src="sortArrow('member_birthday')" alt="" class="w-[10px] h-[10px] ms-2">
              </div>
            </th>
            <th class="w-[160px] py-2 px-4 border border-light-light-gary">出生城市</th>
            <th class="w-[280px] py-2 px-4 border border-light-light-gary">電話號碼</th>
            <th class="w-[300px] py-2 px-4 border border-light-light-gary">操作</th>
          </tr>
        </thead>

        <tbody v-if="memberData.data.length">
          <tr v-for="member in memberData.data" :key="member.id">
            <td class="px-3 py-3 border border-light-light-gary">{{ member.id }}</td>
            <td class="px-3 py-3 border border-light-light-gary">{{ member.user.name }}</td>
            <td class="px-3 py-3 border border-light-light-gary">{{ member.member_birthday.replace(/-/g, '/') }}</td>
            <td class="p-3 border border-light-light-gary">{{ member.member_city }}</td>
            <td class="p-3 border border-light-light-gary">{{ member.member_phone }}</td>
            <td class="p-3 border border-light-light-gary justify-center">
              <div class="flex justify-center items-center">
                <div class="me-2 border border-main-red text-main-red rounded px-3 py-1 cursor-pointer" @click="deleteMember(member.user.id)">刪除</div>
                <Link @click="editMember(member.user.id)" class="border border-blue-green text-white bg-blue-green rounded px-3 py-1 cursor-pointer">查看/編輯</Link>
              </div>
            </td>
          </tr>
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
  <div v-if="jumpAdd === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[1%] left-[50%] translate-x-[-50%] bg-white rounded h-[300px] scale-90">
        <addMemberComponent :errors="errors"></addMemberComponent>
      </div>
    </div>
  </div>
</template>


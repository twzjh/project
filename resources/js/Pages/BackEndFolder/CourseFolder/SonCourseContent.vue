<script>
import BackendNav from '@/Components/BackendNav.vue';
import VectorUp from '/images/BackEndIcon/backend-up.png';
import VectorDown from '/images/BackEndIcon/backend-down.png';
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
      default: 'course_main',
    },
  },
  data() {
    return {
      vectorUp: VectorUp,
      vectorDown: VectorDown,
      sortType: this.sort === 'desc' ? true : false, // (初始倒序)
      main: {
        1: '否',
        2: '是',
      },
      type: {
        1: '吠陀占星',
        2: '中醫',
        3: '古典魔法',
        4: '其他術數',
      },
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
    // 導向編輯頁面
    editCourse(id) {
      this.$inertia.get(route('editsoncourse', { id: id }));
    },
    // 刪除資料
    deleteCourse(id) {
      Swal.fire({
        title: '是否要刪除?',
        showCancelButton: true,
        confirmButtonText: '確定',
        cancelButtonText: '取消',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[350px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
          cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.get(route('course.delete', id), {}, {
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
        }
      });
    },
    // 排序圖示(上下箭頭切換)
    sortArrow(column) {
      if (this.sortType && this.column === column) {
        return this.vectorDown;
      }
      return this.vectorUp;
    },
    // 排序
    sortData(column) {
      this.sortType = !this.sortType;
      router.visit(route('course.sortData'), {
        method: 'get',
        data: { 'column': column, 'sort': this.sortType ? 'desc' : 'asc', 'nowpage': this.nowpage },
        preserveState: true,
      });
    },
  },
};
</script>

<template>
  <Head title="後臺子課程內容管理"></Head>
  <BackendNav>
    <template v-slot:title>
      <h2 class="pl-10 pt-4 font-JhengHei text-2xl font-bold">子課程管理</h2>
      <div class="w-full h-4 shadow-xl"></div>
    </template>
    <template v-slot:content>
      <main>
        <Link :href="route('addsoncourse')" class="block w-[120px]">
          <div class="w-[120px] ml-10 text-2xl font-JhengHei p-3 bg-dark-gray rounded text-white cursor-pointer mt-5">新增課程
          </div>
        </Link>
        <table class="w-[95%] ml-10 mt-5 border border-light-light-gary text-center text-2xl font-medium font-JhengHei">
          <thead>
            <tr class="bg-dark-gray text-white border border-light-light-gary">
              <th class="w-[160px] px-4" @click="sortData('course_main')">
                <div class="flex justify-center items-center cursor-pointer">
                  <span class="text-center">主打課程</span>
                  <img :src="sortArrow('course_main')" class="vector right-[1468px]">
                </div>
              </th>
              <th class="w-[360px] py-2 border border-light-light-gary">課程名稱</th>
              <th class="w-[160px] px-4 justify-center items-center" @click="sortData('course_price')">
                <div class="flex justify-center items-center cursor-pointer">
                  <span class="text-center">金額</span>
                  <img :src="sortArrow('course_price')" class="vector right-[890px]">
                </div>
              </th>
              <th class="w-[160px] px-4 border border-light-light-gary" @click="sortData('course_type')">
                <div class="flex justify-center items-center cursor-pointer">
                  <span class="">課程類別</span>
                  <img :src="sortArrow('course_type')" class="vector right-[682px]">
                </div>
              </th>
              <th class="w-[320px] py-2 px-4 border border-light-light-gary">簡介</th>
              <th class="w-[200px] py-2 px-4 border border-light-light-gary">操作</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="content in response.data" :key="content.id">
              <td class="px-3 py-3 border border-light-light-gary">{{ main[content.course_main] }}</td>
              <td class="p-3 border border-light-light-gary">{{ content.course_name }}</td>
              <td class="p-3 border border-light-light-gary">{{ content.course_price.toLocaleString('zh-TW') }}</td>
              <td class="p-3 border border-light-light-gary">{{ type[content.course_type] }}</td>
              <td class="p-3 border border-light-light-gary text-start more px-4 py-[10px]">{{ content.course_introduce }}</td>
              <td class="p-3 border border-light-light-gary">
                <div class="flex justify-center items-center">
                  <div class="me-2 border border-main-red text-main-red rounded px-3 py-1 cursor-pointer" @click="deleteCourse(content.id)">刪除</div>
                  <div class="border border-blue-green text-white bg-blue-green rounded px-3 py-1 cursor-pointer" @click="editCourse(content.id)">編輯</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
.more {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  box-sizing:border-box;
  line-height:40px;
}
.vector{
  @apply brightness-[3] absolute top-[263px]
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
</style>

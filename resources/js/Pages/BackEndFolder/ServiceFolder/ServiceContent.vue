<script>
import BackendNav from '@/Components/BackendNav.vue';
import chevronLeft from '/images/BackEndIcon/chevron-left.svg';
import chevronRight from '/images/BackEndIcon/chevron-right.svg';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Link,
    Head,
  },
  props: {
    response: Object,
    servicedata: Object,
  },
  data() {
    return {
      chevronLeft,
      chevronRight,
      jumpAdd: 0,
      jumpEdit: 0,
      form: {
        name: '',
        price: '',
        introduce: '',
      },
      formData: {
        name: '',
        price: '',
        introduce: '',
      },
      editingData: {},
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
    // 新增彈窗
    addService() {
      if (this.jumpAdd === 0) {
        this.jumpAdd = 1;
      } else {
        this.jumpAdd = 0;
      }
      this.form.name = '';
      this.form.price = '';
      this.form.introduce = '';
    },
    // 編輯彈窗
    editService(id) {
      if (this.jumpEdit === 0) {
        this.jumpEdit = 1;
      } else {
        this.jumpEdit = 0;
      }
      this.editingData = this.response.data.find(item => item.id === id);
      this.formData.name = this.editingData.service_name;
      this.formData.price = this.editingData.service_price;
      this.formData.introduce = this.editingData.service_introduce;
    },
    // 新增服務
    newService() {
      if (this.form.name === '' || this.form.price === '' || this.form.introduce === '') {
        Swal.fire({
          title: '請輸入完整資料',
          showConfirmButton: false,
          icon: 'error',
          timer: 1500,
        });
      } else {
        Swal.fire({
          title: '是否要儲存?',
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
            this.$inertia.post(route('service.store'), this.form, {
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
        this.jumpAdd = 0;
      }
    },
    // 更新服務
    updateService() {
      if (this.formData.name === '' || this.formData.price === '' || this.formData.introduce === '') {
        Swal.fire({
          title: '請輸入完整資料',
          showConfirmButton: false,
          icon: 'error',
          timer: 1500,
        });
      } else {
        Swal.fire({
          title: '是否要更新?',
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
            this.$inertia.post(route('service.update', this.editingData.id), this.formData, {
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
        this.jumpEdit = 0;
      }
    },
    // 刪除服務
    deleteService(id) {
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
          this.$inertia.post(route('service.delete', id), {}, {
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
  },
};
</script>

<template>
  <Head title="後臺服務內容管理"></Head>
  <div class="relative">
    <BackendNav>
      <template v-slot:title>
        <h2 class="pl-10 pt-4 font-JhengHei text-2xl font-bold">服務內容管理</h2>
        <div class="w-full h-4 shadow-xl"></div>
      </template>
      <template v-slot:content>
        <main>
          <div
            class="ml-10 text-2xl font-JhengHei p-3 bg-dark-gray w-[170px] rounded text-white mb-5 cursor-pointer mt-5"
            @click="addService">新增服務內容</div>
          <table class="w-[95%] ml-10 border border-light-light-gary text-center text-2xl font-medium font-JhengHei">
            <thead>
              <tr class="bg-dark-gray text-white">
                <th class="w-[25%] py-2 border border-light-light-gary">服務名稱</th>
                <th class="w-[10%] py-2 border border-light-light-gary">金額</th>
                <th class="w-[50%] py-2 border border-light-light-gary">服務介紹</th>
                <th class="w-[15%] py-2 px-4 border border-light-light-gary">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="content in response.data" :key="content.id">
                <td class="p-3 border border-light-light-gary">{{ content.service_name }}</td>
                <td class="border border-light-light-gary">{{ content.service_price.toLocaleString('zh-TW') }}</td>
                <td class="p-2 border-t border-light-light-gary more text-start">{{ content.service_introduce }} </td>
                <td class="border border-light-light-gary">
                  <div class="flex justify-center items-center">
                    <div class="me-2 border border-main-red text-main-red rounded px-3 py-1 cursor-pointer"
                      @click="deleteService(content.id)">刪除</div>
                    <div class="border border-blue-green text-white bg-blue-green rounded px-3 py-1 cursor-pointer"
                      @click="editService(content.id)">編輯</div>
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
  </div>
  <!-- 新增彈跳視窗 -->
  <div v-if="jumpAdd === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[10%] left-[50%] translate-x-[-50%] bg-white rounded">
        <div class="w-[600px] flex flex-col font-JhengHei rounded">
          <div class="bg-dark-gray text-white text-2xl text-center p-3 mb-2 rounded">新增內容</div>
          <div class="flex flex-col py-5 px-6">
            <div class="inputBox">
              <input v-model="form.name" type="" class="mb-3 rounded" required>
              <span>服務名稱</span>
            </div>
            <span class="text-main-red mb-5">服務內容名稱不得超過12字</span>
            <div class="inputBox">
              <input v-model="form.price" type="number" class="mb-3 rounded hide-arrows" required>
              <span>金額</span>
            </div>
            <div class="inputBox">
              <textarea v-model="form.introduce" type="text" class="mb-3 rounded h-60 inputBoxvalue" placeholder="請輸入文字"
                required></textarea>
              <span>介紹(100字內)</span>
            </div>
            <span class="text-main-red mb-5">介紹不得超過100字</span>
            <div class="flex justify-center">
              <div class="border border-main-red text-main-red me-3 rounded px-7 py-1 font-bold cursor-pointer"
                @click="jumpAdd = 0">取消</div>
              <div class="border border-lake-green bg-lake-green text-white rounded px-7 py-1 font-bold cursor-pointer"
                @click="newService">儲存</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- 編輯彈跳視窗 -->
  <div v-if="jumpEdit === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[10%] left-[50%] translate-x-[-50%] bg-white rounded">
        <div class="w-[600px] flex flex-col font-JhengHei rounded">
          <div class="bg-dark-gray text-white text-2xl text-center p-3 mb-2 rounded">編輯內容</div>
          <div class="flex flex-col py-5 px-6">
            <div class="inputBox">
              <input v-model="formData.name" type="text" class="mb-3 rounded" required>
              <span>服務名稱</span>
            </div>
            <span class="text-main-red mb-5">服務內容名稱不得超過12字</span>
            <div class="inputBox">
              <input v-model="formData.price" type="number" class="mb-3 rounded hide-arrows" required>
              <span>金額</span>
            </div>
            <div class="inputBox">
              <textarea v-model="formData.introduce" type="text" class="mb-3 rounded h-60 inputBoxvalue"
                placeholder="請輸入文字" required></textarea>
              <span>介紹(100字內)</span>
            </div>
            <span class="text-main-red mb-5">介紹不得超過100字</span>
            <div class="flex justify-center">
              <div class="border border-main-red text-main-red me-3 rounded px-7 py-1 font-bold cursor-pointer"
                @click="jumpEdit = 0">取消</div>
              <div class="border border-lake-green bg-lake-green text-white rounded px-7 py-1 font-bold cursor-pointer"
                @click="updateService">儲存</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
* {
  box-sizing: border-box;
  font-family: 'Microsoft JhengHei';
}

body {
  min-height: 100vh;
  flex-direction: column;
  gap: 30px;
}

::placeholder {
  color: #b5b5b5;
}

.more {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  box-sizing:border-box;
  line-height:40px;
}

textarea {
  resize: none;
}

.inputBox {
  position: relative;
}

.inputBox input,
.inputBox textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #b5b5b5;
  background: white;
  border-radius: 4px;
  outline: none;
  color: black;
  transition: 0.5s;
}

.inputBox span {
  position: absolute;
  left: 0;
  padding: 10px;
  pointer-events: none;
  font-size: 1em;
  color: rgba(0, 0, 0, 0.25);
  text-transform: uppercase;
  transition: 1s;
}

.inputBox input:valid~span,
.inputBox input:focus~span {
  color: #b5b5b5;
  transform: translateX(14px) translateY(-7px);
  font-size: 0.8em;
  padding: 0;
  background: white;
  letter-spacing: 0.2em;
}

.inputBox input:valid,
.inputBox input:focus {
  border: 1px solid #b5b5b5;
}

/* .inputBox input {
  padding-left: 12px;
} */

.inputBoxvalue~span {
  color: #b5b5b5 !important;
  transform: translateX(14px) translateY(-7px) !important;
  font-size: 0.8em !important;
  padding: 0 !important;
  background: white !important;
  /* border-left: 1px solid #000000; */
  /* border-right: 1px solid #000000; */
  letter-spacing: 0.2em !important;
}

.hide-arrows::-webkit-outer-spin-button,
.hide-arrows::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
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

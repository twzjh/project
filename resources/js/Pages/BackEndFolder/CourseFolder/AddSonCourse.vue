<script>
import BackendNav from '@/Components/BackendNav.vue';
import ChevronLeft from '/images/BackEndIcon/chevron-left-white.svg';
import Checkbox from '/images/BackEndIcon/Checkbox.png';
import Checkbox2 from '/images/BackEndIcon/Checkbox-2.png';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Head,
  },
  props: {
    response: Object,
  },
  data() {
    return {
      ChevronLeft,
      Checkbox,
      Checkbox2,
      jumpAdd: 0,
      jumpEdit: 0,
      mainProduct: 1,
      checkBoxType: Checkbox2,
      nowId: '',
      form: {
        name: '',
        type: 0,
        main: 1,
        price: '',
        hour: '',
        introduce: '',
        detailIntroduce: '',
        photo: '',
      },
      mainPic: '',
      mainPicName: '',
    };
  },
  methods: {
    // 主要課程變更
    changeMain() {
      if (this.mainProduct === 1) {
        this.mainProduct = 2;
        this.checkBoxType = Checkbox;
        this.form.main = 2;
      } else {
        this.mainProduct = 1;
        this.checkBoxType = Checkbox2;
        this.form.main = 1;
      }
    },
    // 新增課程
    addCourse() {
      if (this.form.main === 2) {
        if (this.form.photo === '') {
          Swal.fire({
            icon: 'warning',
            title: '請上傳照片!',
            showConfirmButton: false,
            timer: 1500,
          });
        } else {
          if (this.form.name === '' || this.form.type === 0 || this.form.price === '' || this.form.hour === '' || this.form.introduce === '' || this.form.detailIntroduce === '') {
            Swal.fire({
              icon: 'warning',
              title: '請填寫完整的資料!',
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            const mainCourses = this.response.filter(course => course.course_main === 2);

            if (mainCourses.length >= 2 && this.form.main === 2) {
              Swal.fire({
                icon: 'warning',
                title: '主打課程上限為2堂，若已經兩堂則無法再選擇!',
                showConfirmButton: false,
                timer: 2000,
              });
            } else {
              this.$inertia.post(route('course.store'), this.form);
            }
          }
        }
      } else {
        if (this.form.name === '' || this.form.type === 0 || this.form.price === '' || this.form.hour === '' || this.form.introduce === '' || this.form.detailIntroduce === '') {
          Swal.fire({
            icon: 'warning',
            title: '請填寫完整的資料!',
            showConfirmButton: false,
            timer: 1500,
          });
        } else {
          const mainCourses = this.response.filter(course => course.course_main === 2);

          if (mainCourses.length >= 2 && this.form.main === 2) {
            Swal.fire({
              icon: 'warning',
              title: '主打課程上限為2堂，若已經兩堂則無法再選擇!',
              showConfirmButton: false,
              timer: 2000,
            });
          } else {
            this.mainPic = '',
            this.form.photo = '',
            this.$inertia.post(route('course.store'), this.form);
          }
        }
      }
    },
    // 通知先儲存章節
    notify() {
      Swal.fire({
        icon: 'warning',
        title: '請先儲存課程再建立章節!',
        showConfirmButton: false,
        timer: 1500,
      });
    },
    // 取消回上一頁
    goback() {
      this.$inertia.get(route('soncourse.content'), this.form);
    },
    // 預覽圖片
    putImg(e) {
      const file = e.target.files[0];
      this.form.photo = file;
      this.mainPicName = file.name;
      this.mainPic = URL.createObjectURL(file);
    },
  },
};
</script>

<template>
  <Head title="後臺新增子課程"></Head>
  <div class="relative">
    <BackendNav>
      <template v-slot:title>
        <h2 class="pl-10 pt-4 font-JhengHei text-2xl font-bold">新增子課程</h2>
        <div class="w-full h-4 shadow-xl"></div>
      </template>
      <template v-slot:content>
        <main class="w-[95%]">
          <form>
            <div class="pl-10 pt-4 flex justify-between w-[800px] mb-3">
              <div class="inputBox w-[420px]">
                <input v-model="form.name" type="text" class="mb-3 rounded" required>
                <span>課程標題</span>
              </div>
              <select v-model="form.type" class="rounded w-[160px] h-[38px]">
                <option value="0" selected disabled>課程類別</option>
                <option value="1">吠陀占星</option>
                <option value="2">中醫</option>
                <option value="3">古典魔法</option>
                <option value="4">其他術數</option>
              </select>
            </div>
            <span class="text-main-red pl-10 text-lg">課程標題不得超過10字</span>
            <div class="w-[95%] h-4 border-b border-light-gary mb-3 ml-10"></div>
            <div class="flex pl-10 mb-3 items-center">
              <span class="me-5 font-JhengHei text-2xl font-normal">設為主打課程</span>
              <img :src="checkBoxType" alt="左右打開按鈕" class="w-[44px] h-[22px] cursor-pointer" @click="changeMain">
            </div>
            <div v-if="mainProduct === 2" class="mb-3 ml-10 font-JhengHei">
              <span class="text-lg mb-2">主打課程圖片</span>
              <img v-if="mainPic" :src="mainPic" alt="圖片預覽" class="w-[160px] h-[90px]">
              <div class="text-main-red mb-2 text-lg">圖片建議尺寸：640px*360px(16:9)</div>
              <div class="text-main-red mb-2 text-lg">圖片限定一張，建議大小不超過1MB</div>
              <label class="prettier-input flex">
                <input type="file" accept=".jpg, .png, .jpeg" @change="putImg">
                <div>
                  瀏覽檔案
                </div>
                <span v-if="mainPicName" class="ml-2 bg-light-light-gary rounded w-[240px] h-[48px] text-lg text-dark-gray leading-[48px]">&nbsp;&nbsp;&nbsp;{{ mainPicName }}</span>
                <span v-else class="ml-2 bg-light-light-gary rounded w-[240px] h-[48px] text-lg text-dark-gray leading-[48px]">&nbsp;&nbsp;&nbsp;請選擇檔案</span>
              </label>
            </div>
            <span class="text-main-red pl-10 text-lg">主打課程上限為2堂，若已經兩堂則無法再選擇</span>
            <div class="w-[95%]  h-4 border-b border-light-gary mb-3 ml-10 text-lg"></div>
            <div class="flex flex-col pl-10">
              <div class="inputBox">
                <input v-model="form.price" type="number" class="mb-3 rounded !w-[420px] hide-arrows" required>
                <span>金額</span>
              </div>
              <div class="inputBox">
                <input v-model="form.hour" type="text" class="mb-3 rounded !w-[420px]" required>
                <span>單堂小時數</span>
              </div>
              <div class="inputBox">
                <textarea v-model="form.introduce" type="text" class="mb-3 rounded h-28 !w-[903px] inputBoxvalue"
                  placeholder="請輸入文字" required></textarea>
                <span>列表簡介</span>
              </div>
            </div>
            <div class="text-main-red ml-10 text-lg">列表簡介：顯示於課程列表之簡介，不得超過36字</div>
            <div class="w-[95%]  h-4 border-b border-light-gary mb-3 ml-10"></div>
            <div class="pl-10">
              <div class="inputBox">
                <textarea v-model="form.detailIntroduce" type="text" class="mb-3 rounded h-64 !w-[903px] inputBoxvalue"
                  placeholder="請輸入文字" required></textarea>
                <span>詳細介紹</span>
              </div>
            </div>

            <div class="text-main-red ml-10 text-lg">詳細介紹不得超過500字</div>
            <div class="w-[95%] h-4 border-b border-light-gary mb-3 ml-10"></div>
          </form>
          <div class="w-[95%] flex justify-between items-center mb-5 ml-10">
            <div class="text-2xl font-JhengHei p-2 bg-dark-gray w-[160px] rounded text-white cursor-pointer" @click="notify">新增課程章節
            </div>
            <!-- <div
              class="text-dark-gray border border-dark-gray w-[244px] font-JhengHei text-2xl text-center bg-white p-2 rounded">
              課程影片嵌入教學</div> -->
          </div>
          <table class="w-[95%] ml-10 border border-light-light-gary text-center text-2xl font-medium font-JhengHei">
            <thead>
              <tr class="bg-dark-gray text-white">
                <th class="w-[10%] py-2 border border-light-light-gary">排序</th>
                <th class="w-[20%] py-2 border border-light-light-gary">章節名稱</th>
                <th class="w-[30%] py-2 border border-light-light-gary">章節簡介</th>
                <th class="w-[20%] py-2 border border-light-light-gary">課程影片</th>
                <th class="w-[15%] py-2 px-4 border border-light-light-gary">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="content in 0" :key="content.id">
                <td class="px-3 py-3 border border-light-light-gary"></td>
                <td class="p-3 border border-light-light-gary"></td>
                <td class="p-3 border border-light-light-gary"></td>
                <td class="p-3 border border-light-light-gary"></td>
                <td class="flex flex-row p-3 border border-light-light-gary justify-center">
                  <div class="me-2 border border-main-red text-main-red rounded px-3 py-1 cursor-pointer">刪除</div>
                  <div class="border border-blue-green text-white bg-blue-green rounded px-3 py-1 cursor-pointer">編輯
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex mt-10 ml-10 mb-7">
            <div class="me-2 border border-main-red text-main-red rounded px-7 py-1 cursor-pointer text-center" @click="goback">取消</div>
            <div class="border border-blue-green text-white bg-blue-green rounded px-7 py-1 cursor-pointer"
              @click="addCourse">儲存</div>
          </div>
        </main>
      </template>
    </BackendNav>
  </div>

  <!-- 新增章節 -->
  <div v-if="jumpAdd === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[10%] left-[50%] translate-x-[-50%] bg-white rounded">
        <div class="w-[500px] flex flex-col font-JhengHei rounded">
          <div class="bg-dark-gray text-white text-2xl text-center p-3 mb-2 rounded">新增課程章節</div>
          <div class="flex flex-col py-2 px-4">
            <div class="mb-2 flex">
              <span class="font-JhengHei font-bold text-2xl mb-3">章節資訊</span>
              <div class="inputBox ml-auto">
                <input v-model="form.chapter.chapterNum" type="number" class="!w-[80px] h-[36px] rounded hide-arrows"
                  required>
                <span>排序</span>
              </div>
            </div>
            <div class="inputBox">
              <input v-model="form.chapter.chapterName" type="text" class="mb-3 rounded" required>
              <span>章節名稱</span>
            </div>
            <span class="text-main-red mb-3">章節名稱不得超過16字</span>
            <div class="inputBox">
              <textarea v-model="form.chapter.chapterIntroduce" type="text" class="mb-3 rounded h-60 inputBoxvalue"
                placeholder="請輸入文字" required></textarea>
              <span>章節簡介</span>
            </div>
            <span class="text-main-red mb-1">章節簡介不得超過40字</span>
            <div class="w-[100%] h-3 border-b border-light-gary mb-6"></div>
            <div class="flex flex-col mb-2">
              <span class="font-JhengHei font-bold text-2xl mb-3">課程影片</span>
              <div class="inputBox">
                <input v-model="form.chapter.chapterVideo" type="text" class="mb-3 rounded" required>
                <span>網址</span>
              </div>
            </div>
            <div class="w-[100%] h-3 border-b border-light-gary mb-6"></div>
            <div class="flex justify-center mb-3">
              <div class="border border-main-red text-main-red me-3 rounded px-6 py-1 cursor-pointer"
                @click="jumpAdd = 0">取消</div>
              <div class="border border-lake-green bg-lake-green text-white rounded px-6 py-1 cursor-pointer">新增</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- 編輯章節 -->
  <div v-if="jumpEdit === 1" class=" w-full h-full  absolute top-0 z-50 ">
    <div class="bg-black w-full h-full bg-opacity-40 fixed">
      <div class="absolute top-[10%] left-[50%] translate-x-[-50%] bg-white rounded">
        <div class="w-[500px] flex flex-col font-JhengHei rounded">
          <div class="bg-dark-gray text-white text-2xl text-center p-3 mb-2 rounded">編輯課程章節</div>
          <div class="flex flex-col py-2 px-4">
            <div class="mb-2 flex justify-between">
              <span class="font-JhengHei font-bold text-2xl mb-3">章節資訊</span>
              <div class="inputBox">
                <input type="number" class="mb-3 rounded !w-[80px] !h-[36px] hide-arrows" required>
                <span>排序</span>
              </div>
            </div>
            <div class="inputBox">
              <input type="text" class="mb-3 rounded" required>
              <span>章節名稱</span>
            </div>
            <span class="text-main-red mb-3">章節名稱不得超過16字</span>
            <div class="inputBox">
              <textarea type="text" class="mb-3 rounded h-60 inputBoxvalue" placeholder="請輸入文字" required></textarea>
              <span>章節簡介</span>
            </div>
            <span class="text-main-red mb-1">章節簡介不得超過40字</span>
            <div class="w-[100%] h-3 border-b border-light-gary mb-6"></div>
            <div class="flex flex-col mb-2">
              <span class="font-JhengHei font-bold text-2xl mb-3">課程影片</span>
              <div class="inputBox">
                <input type="text" class="mb-3 rounded" required>
                <span>網址</span>
              </div>
            </div>
            <div class="w-[100%] h-3 border-b border-light-gary mb-6"></div>
            <div class="flex justify-center mb-3">
              <div class="border border-main-red text-main-red me-3 rounded px-6 py-1 cursor-pointer"
                @click="jumpEdit = 0">取消</div>
              <div class="border border-lake-green bg-lake-green text-white rounded px-6 py-1 cursor-pointer">
                儲存</div>
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

.inputBox input {
  padding-left: 12px;
}

.hide-arrows::-webkit-outer-spin-button,
.hide-arrows::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

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
.prettier-input input {
    display: none;
}
.prettier-input div {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 160px;
    height: 48px;
    padding: 4px 8px;
    color: white;
    font-size: 24px;
    font-weight: 400;
    background-color: #6c6c6c;
    cursor: pointer;
    border-radius: 4px;
}
</style>

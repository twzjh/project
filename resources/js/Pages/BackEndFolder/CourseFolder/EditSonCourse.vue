<script>
import BackendNav from '@/Components/BackendNav.vue';
import ChevronLeft from '/images/BackEndIcon/chevron-left-white.svg';
import Checkbox from '/images/BackEndIcon/Checkbox.png';
import Checkbox2 from '/images/BackEndIcon/Checkbox-2.png';
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
    chapters: Object,
    mainCount: Number,
    courseImg: String,
  },
  data() {
    return {
      ChevronLeft,
      Checkbox,
      Checkbox2,
      jumpAdd: 0,
      jumpEdit: 0,
      mainProduct: this.response.course_main,
      checkBoxType: Checkbox2,
      editingData: {},
      form: {
        name: this.response.course_name,
        type: this.response.course_type,
        main: this.response.course_main,
        price: this.response.course_price,
        hour: this.response.course_hour,
        introduce: this.response.course_introduce,
        detailIntroduce: this.response.detail_introduce,
        photo: '',
        chapter: {
          courseId: this.response.id,
          chapterNum: '',
          chapterName: '',
          chapterIntroduce: '',
          chapterVideo: '',
        },
      },
      mainPic: this.response.course_image,
      mainPicName: '',
    };
  },
  mounted() {
    this.maincourse();
  },
  methods: {
    // 導入資料是否為主要課程
    maincourse() {
      if (this.response.course_main === 1) {
        this.checkBoxType = Checkbox2;
        this.mainProduct = 1;
      } else {
        this.checkBoxType = Checkbox;
        this.mainProduct = 2;
      }
    },
    // 新增章節 彈跳視窗
    addChapter() {
      if (this.jumpAdd === 0) {
        this.jumpAdd = 1;
      } else {
        this.jumpAdd = 0;
      }

      this.form.chapter.chapterNum = '';
      this.form.chapter.chapterName = '';
      this.form.chapter.chapterIntroduce = '';
      this.form.chapter.chapterVideo = '';
    },
    // 編輯章節 彈跳視窗
    editChapter(id) {
      if (this.jumpEdit === 0) {
        this.jumpEdit = 1;
      } else {
        this.jumpEdit = 0;
      }
      this.editingData = this.chapters.find(item => item.id === id);
      this.form.chapter.chapterNum = this.editingData.chapter_number;
      this.form.chapter.chapterName = this.editingData.chapter_name;
      this.form.chapter.chapterIntroduce = this.editingData.chapter_introduce;
      this.form.chapter.chapterVideo = this.editingData.chapter_video;
    },
    // checkbox更改狀態
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
    // 新增章節
    newChapter() {
      if (this.form.chapter.chapterNum === '' || this.form.chapter.chapterName === '' || this.form.chapter.chapterIntroduce === '' || this.form.chapter.chapterVideo === '') {
        Swal.fire({
          title: '請輸入完整資料',
          showConfirmButton: false,
          icon: 'error',
          timer: 1500,
        });
      } else {
        Swal.fire({
          title: '是否新增章節?',
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
            this.$inertia.post(route('chapter.store'), this.form.chapter, {
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
    // 更新資料
    update() {
      if (this.form.main === 2) {
        if (this.mainCount === 2 && this.response.course_main !== 2) {
          Swal.fire({
            icon: 'warning',
            title: '主打課程上限為2堂，若已經兩堂則無法再選擇!',
            showConfirmButton: false,
          });
        } else {
          if (this.form.photo === '' && this.mainPic === null && this.mainPicName === '') {
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
                  this.$inertia.post(route('course.update', this.response.id), this.form, {
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
          this.mainPic = '',
          this.form.photo = '',
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
              this.$inertia.post(route('course.update', this.response.id), this.form, {
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
        }
      }
    },
    // 更新章節
    updateChapter() {
      if (this.form.chapter.chapterNum === '' || this.form.chapter.chapterName === '' || this.form.chapter.chapterIntroduce === '' || this.form.chapter.chapterVideo === '') {
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
            this.$inertia.post(route('chapter.update', this.editingData.id), this.form.chapter, {
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
    // 刪除章節
    deleteChapter(id) {
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
          this.$inertia.delete(route('chapter.delete', id), {}, {
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
    // 預覽圖片
    putImg(e) {
      const file = e.target.files[0];
      if (file.size > 1024 * 1024) {
      // File size exceeds 1MB, show an error message
        Swal.fire({
          title: '檔案大小超過限制',
          text: '請選擇不超過1MB的圖片',
          icon: 'error',
        });
        return;
      }
      this.form.photo = file;
      this.mainPicName = file.name;
      this.mainPic = URL.createObjectURL(file);
    },
    // 取消回上一頁
    goback() {
      this.$inertia.get(route('soncourse.content'), this.form);
    },
  },
};
</script>

<template>
  <Head title="後臺編輯子課程"></Head>
  <div class="relative">
    <BackendNav>
      <template v-slot:title>
        <div class="flex pl-10 py-4 shadow-lg">
          <Link :href="route('soncourse.content')" class="font-JhengHei text-lg bg-dark-dark-gary w-[88px] h-[40px] rounded text-white cursor-pointer text-center flex justify-center items-center">
            <img :src="ChevronLeft" alt="向左箭頭" class="w-[10px] me-2">
            <span>返回</span>
          </Link>
          <span class="font-JhengHei text-2xl font-bold ml-5 mt-1">編輯子課程</span>
        </div>
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
            <div class="w-[95%]  h-4 border-b border-light-gary mb-3 ml-10"></div>
            <div class="flex flex-col ml-10">
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
                  required></textarea>
                <span>列表簡介</span>
              </div>
            </div>
            <div class="text-main-red ml-10 text-lg">列表簡介：顯示於課程列表之簡介，不得超過36字</div>
            <div class="w-[95%]  h-4 border-b border-light-gary mb-3 ml-10"></div>
            <div class="ml-10">
              <div class="inputBox">
                <textarea v-model="form.detailIntroduce" type="text" class="mb-3 rounded h-64 !w-[903px] inputBoxvalue"
                  required></textarea>
                <span>詳細介紹</span>
              </div>
            </div>

            <div class="text-main-red ml-10 text-lg">詳細介紹不得超過500字</div>
            <div class="w-[95%] h-4 border-b border-light-gary mb-3 ml-10"></div>
          </form>
          <div class="w-[95%] flex justify-between items-center mb-5 ml-10">
            <div class="text-2xl font-JhengHei p-2 bg-dark-gray w-[160px] rounded text-white cursor-pointer"
              @click="addChapter">新增課程章節
            </div>
            <!-- <div
              class="text-dark-gray border border-dark-gray w-[244px] font-JhengHei text-2xl text-center bg-white p-2 rounded">
              課程影片嵌入教學</div> -->
          </div>
          <table class="ml-10 border border-light-light-gary border-collapse mb-6">
            <thead>
              <tr>
                <th>排序</th>
                <th>章節名稱</th>
                <th>章節簡介</th>
                <th>課程影片</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody class="font-normal text-2xl leading-10 text-[#0B0B0B]">
              <tr class="content-container" v-for="content in chapters" :key="content.id">
                <td class="w-[120px]">{{ content.chapter_number }}</td>
                <td class="w-[360px]">{{ content.chapter_name }}</td>
                <td class="introduce w-[420px] px-4">
                  <span>{{ content.chapter_introduce }}</span>
                </td>
                <td class="video w-[240px] px-4">
                  <p>{{ content.chapter_video }}</p>
                </td>
                <td>
                  <div class="w-[240px] flex justify-center items-center">
                    <div class="me-2 border border-main-red text-main-red rounded px-3 py-1 cursor-pointer" @click="deleteChapter(content.id)">刪除</div>
                    <div class="border border-blue-green text-white bg-blue-green rounded px-3 py-1 cursor-pointer" @click="editChapter(content.id)">編輯</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex mt-10 ml-10 mb-7">
            <div class="me-2 border border-main-red text-main-red rounded px-7 py-1 cursor-pointer text-center" @click="goback">取消</div>
            <div class="border border-blue-green text-white bg-blue-green rounded px-7 py-1 cursor-pointer"
              @click="update">儲存</div>
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
              <div class="border border-lake-green bg-lake-green text-white rounded px-6 py-1 cursor-pointer"
                @click="newChapter">新增</div>
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
                <input v-model="form.chapter.chapterNum" type="number" class="mb-3 rounded !w-[80px] !h-[36px] hide-arrows" required>
                <span>排序</span>
              </div>
            </div>
            <div class="inputBox">
              <input v-model="form.chapter.chapterName" type="text" class="mb-3 rounded" required>
              <span>章節名稱</span>
            </div>
            <span class="text-main-red mb-3">章節名稱不得超過16字</span>
            <div class="inputBox">
              <textarea v-model="form.chapter.chapterIntroduce" type="text" class="mb-3 rounded h-60 inputBoxvalue" placeholder="請輸入文字" required></textarea>
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
                @click="jumpEdit = 0">取消</div>
              <div class="border border-lake-green bg-lake-green text-white rounded px-6 py-1 cursor-pointer" @click="updateChapter">儲存</div>
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

table thead tr th {
  @apply font-bold text-2xl leading-6 text-[#FDFDFD] bg-dark-gray border border-[#D7D2CE] py-2
}
table thead tr th:first-child {
  @apply w-[116px]
}
table thead tr th:nth-child(2) {
  @apply w-[348px]
}
table thead tr th:nth-child(3) {
  @apply w-[408px]
}
table thead tr th:nth-child(4) {
  @apply w-[273px]
}
table thead tr th:nth-child(5) {
  @apply w-[235px]
}

table tbody tr td {
  @apply border border-light-light-gary text-center h-[100px]
}

table tbody tr .introduce span {
  overflow: hidden;
  text-align: start;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  text-overflow: ellipsis;
}

table tbody tr .video p {
  @apply w-[240px] overflow-hidden whitespace-nowrap text-ellipsis
}

table tbody tr:nth-child(even) {
  @apply bg-main-white
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

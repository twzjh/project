<script>
import BackendNav from '@/Components/BackendNav.vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import OpenImg from '/images/BackEndIcon/Checkbox.png';
import CloseImg from '/images/BackEndIcon/Checkbox-2.png';

export default {
  components: {
    BackendNav,
    Link,
    Head,
  },
  props: {
    orderData: Object,
  },
  data() {
    return {
      // swicth button
      OpenImg,
      CloseImg,
      // 確認收款3個按鈕
      activeButton: '',
      // 當前按鈕狀態
      currentAction: '',
      // 上一步狀態
      previousAction: '',
      order: {
        order_status: '',
      },
      newOrderData: this.orderData,
      date: this.orderData.remittance_date?.substring(0, 10),
      lastNumber: this.orderData.last_number,
      total: this.orderData.remittance_price?.toLocaleString('zh-TW'),
      type: typeof this.orderData.remittance_date,
      open: 1,
      editCourse: '',
      courseList: [],
    };
  },
  computed: {
    paymentStyle() {
      let datatxt = '';
      if (this.orderData.order_status === 1) {
        datatxt = '訂單成立';
      }
      if (this.orderData.order_status === 2) {
        datatxt = '確認收款';
      }
      if (this.orderData.order_status === 3) {
        datatxt = '尚未付款';
      }
      if (this.orderData.order_status === 4) {
        datatxt = '訂單取消';
      }
      return datatxt;
    },
  },
  mounted() {
    this.newOrderData.order_detail.forEach(goods => {
      let matchPermission = this.newOrderData.permission.find(item => item.course_id === goods.goods_id);
      if (matchPermission && goods.goods_type === 2) {
        goods.permission = matchPermission;
      }
    });
    // 整理課程權限
    let newArray = [];
    this.orderData.order_detail.forEach(function (item) {
      if (item.goods_type === 2) {
        newArray.push(item);
      }
    });
    this.courseList = newArray;

  },
  methods: {
    // 改變按鈕顏色
    changeButtonColor(nowbtn) {
      if (nowbtn === 2) {
        this.payProfile(nowbtn);
      }
      if (nowbtn === 3) {
        this.order.order_status = nowbtn;
        this.$inertia.get(route('payment.status'), { 'statusNum': nowbtn, 'orderId': this.orderData.id });
      }
      if (nowbtn === 4) {
        this.cancelFile(nowbtn);
      }
    },
    // 確認收款彈窗
    payProfile(paystatic) {
      Swal.fire({
        title: '是否確定收款?',
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
          this.order.order_status = paystatic;
          // 更改資料庫狀態
          Swal.fire({
            title: '訂單狀態更新成功',
            buttonsStyling: false,
            customClass: {
              popup: 'w-[300px]',
              title: 'font-JhengHei text-black border-0 pt-[20px]',
              actions: 'w-[40%] mt-2',
              confirmButton: 'swal-btn bg-dark-gray text-white border-2 border-dark-gray w-full',
            },
          });
          this.$inertia.get(route('payment.status'), { 'statusNum': 2, 'orderId': this.orderData.id });
        }
      });
    },
    // 取消訂單彈窗
    cancelFile(cancelstatic) {
      Swal.fire({
        title: '是否確定取消訂單?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[350px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
          cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.order.order_status = cancelstatic;
          // 跟後端修改資料狀態
          this.$inertia.get(route('payment.status'), { 'statusNum': 4, 'orderId': this.orderData.id });
        }
      });
    },
    // 課程權限按鈕
    changeMain(course) {
      this.editCourse = course.goods_id;
      if (course.permission.permission === 1) {
        Swal.fire({
          title: '是否開啟權限?',
          showCancelButton: true,
          cancelButtonText: '取消',
          confirmButtonText: '確定',
          buttonsStyling: false,
          customClass: {
            popup: 'w-[350px]',
            title: 'font-JhengHei text-black border-0 pt-[20px]',
            confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
            cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
          },
        }).then((result) => {
          if (result.isConfirmed) {
            course.permission.permission = 2;
            this.open = 2;
          }
        });
      } else {
        Swal.fire({
          title: '是否關閉權限?',
          showCancelButton: true,
          cancelButtonText: '取消',
          confirmButtonText: '確定',
          buttonsStyling: false,
          customClass: {
            popup: 'w-[350px]',
            title: 'font-JhengHei text-black border-0 pt-[20px]',
            confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
            cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
          },
        }).then((result) => {
          if (result.isConfirmed) {
            course.permission.permission = 1;
            this.open = 1;
          }
        });
      }
    },
    // 判斷類型來選擇渲染服務還是課程名稱
    orderDetail(goods) {
      return goods.goods_type === 1 ? goods.service.service_name : goods.course.course_name;
    },
    keywordSearch() {
      this.$inertia.get(route('backmember.search'), { keyword: this.keyword });
    },
    // 重置表單資料為更改前
    cancelEdit() {
      this.$inertia.get(route('payment.index'));
    },
    // 儲存匯款資料及權限
    saveItem() {
      Swal.fire({
        title: '是否確定儲存?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[350px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-dark-gray text-white border-0 order-2',
          cancelButton: 'swal-btn bg-white border-dark-gray text-dark-gray',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post(route('payment.saveItem'), {
            'orderId': this.orderData.id,
            'remittanceDate': this.date + ' 00:00:00',
            'remittancePrice': Number(this.total.replace(/,/g, '')),
            'lastNumber': this.lastNumber,
            'courseId': this.editCourse,
            'open': Number(this.open),
          }, {
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
  <Head title="後臺編輯付款紀錄"></Head>
  <BackendNav>
    <template v-slot:title>
      <!-- 最上層返回按鈕和頁面名稱 -->
      <div class="full-container h-[48px] flex justify-start items-center p-5">
        <Link :href="route('payment.index')" class="w-[88px] h-[40px] bg-dark-gray text-white text-center rounded flex justify-center items-center mr-5 mt-4">&lt;返回</Link>
        <h1 class="text-[24px] font-bold font-JhengHei mt-4">編輯付款記錄</h1>
      </div>
      <div class="w-full h-4 shadow-xl"></div>
    </template>
    <template v-slot:content>
      <main>
        <div class="full-container flex flex-col items-center bg-white">
          <div class="w-9/12 flex justify-around mt-5 p-5 mr-96">
            <!-- 會員資料表 -->
            <div class="w-[428px] h-[208px] bg-main-white mr-10">
              <h1 class="text-[32px] font-bold font-JhengHei px-5 pt-5 pb-2">會員資料</h1>
              <hr class="border-t border-light-gary  w-[90%] mx-auto">
              <div class="flex flex-col p-5 font-JhengHei">
                <span>{{ orderData.user.name }}</span>
                <span>{{ orderData.user.member.member_phone }}</span>
                <span>{{ orderData.user.email }}</span>
              </div>
            </div>
            <div class="flex flex-col justify-center items-center">
              <!-- 訂單資訊和狀態 -->
              <div class="w-[832px] h-[443px] bg-main-white">
                <div class="h-[208px] bg-main-white">
                  <h1 class="text-[32px] font-bold font-JhengHei px-5 pt-5 pb-2">訂單資訊</h1>
                  <hr class="border-t border-light-gary  w-[95%] mx-auto">
                  <div class="flex px-4 py-2 justify-around mt-5">
                    <div class="flex flex-col">
                      <span>訂單日期</span>
                      <label>
                        <input class="w-[240px] mt-2 bg-light-light-gary rounded" type="text" :value="orderData.created_at.split('T')[0].replace(/-/g, '/')" readonly>
                      </label>
                    </div>
                    <div class="flex flex-col">
                      <span>訂單狀態</span>
                      <label>
                        <input class="w-[240px] mt-2 bg-light-light-gary rounded" type="text" v-model="paymentStyle" readonly>
                      </label>
                    </div>
                    <div class="flex flex-col">
                      <span>購買金額總計</span>
                      <label>
                        <input class="w-[240px] mt-2 bg-light-light-gary rounded" type="text" :value="orderData.total.toLocaleString('zh-TW')" readonly>
                      </label>
                    </div>
                  </div>
                  <div class="flex px-4 py-2 justify-around">
                    <div class="flex flex-col">
                      <span>匯款日期</span>
                      <label>
                        <input type="date" class="w-[240px] mt-2 rounded" v-model="date">
                      </label>
                    </div>
                    <div class="flex flex-col">
                      <span>匯款金額</span>
                      <label>
                        <input class="w-[240px] mt-2 rounded" type="text" v-model="total">
                      </label>
                    </div>
                    <div class="flex flex-col">
                      <span>匯款帳號後五碼</span>
                      <label>
                        <input class="w-[240px] mt-2 rounded" type="text" v-model="lastNumber">
                      </label>
                    </div>
                  </div>
                  <hr class="border-t border-light-gary w-[95%] mx-auto mt-5">
                  <div class="flex mt-6">
                    <span class="text-[24px] font-bold font-JhengHei px-5 pt-5 pb-2">訂單狀態</span>
                    <div class="grid grid-cols-3 gap-4 mt-1">
                      <!-- 確認收款按鈕 -->
                      <button @click="changeButtonColor(2)" :class="{ 'active-1': orderData.order_status === 2, 'inactive': orderData.order_status === 4 }" type="button" class="border border-blue-green py-1 px-4 rounded text-blue-green text-[24px] hover:bg-blue-green hover:text-white duration-500" :disabled="(orderData.order_status === 4)">確認收款</button>
                      <!-- 尚未付款按鈕 -->
                      <button @click="changeButtonColor(3)" :class="{ 'active': orderData.order_status === 3, 'inactive': orderData.order_status === 4 || orderData.order_status === 2 }" type="button" class="border border-main-red py-1 px-4 rounded text-main-red text-[24px] hover:bg-main-red hover:text-white duration-500" :disabled="(orderData.order_status === 4 || orderData.order_status === 2)">尚未付款</button>
                      <!-- 訂單取消按鈕 -->
                      <button @click="changeButtonColor(4)" :class="{ 'active': orderData.order_status === 4 }" :disabled="(orderData.order_status === 4)" type="button" class="border border-main-red  py-1 px-4 rounded text-main-red text-[24px] hover:bg-main-red hover:text-white duration-500">訂單取消</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 購買明細 -->
              <div class="w-[832px] h-auto bg-main-white mt-2">
                <div class="p-6">
                  <h1 class="text-[32px] font-bold font-JhengHei px-5 pb-2">購買明細</h1>
                  <div class="w-[95%] mx-auto">
                    <div v-for="(detail, index) in orderData.order_detail" :key="index" class="flex  justify-between items-center text-[24px] font-JhengHei font-semibold text-dark-gray px-8 py-5 border-b pb-3.5 border-y border-light-gary">
                      <div class="">
                        <span>{{ index + 1 }}</span>
                        <span class="ml-28">{{ orderDetail(detail) }}</span>
                      </div>
                      <div class="">
                        <span>NT${{ detail.goods_price.toLocaleString('zh-TW') }}</span>
                        <span class="ml-11" v-if="detail.goods_type === 1">服務</span>
                        <span class="ml-11" v-if="detail.goods_type === 2">課程</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 課程權限 -->
              <div class="w-[832px] h-auto bg-main-white mt-2">
                <div class="p-6" id="permission-area">
                  <h1 class="text-[32px] font-bold font-JhengHei px-5 pb-2">課程權限</h1>
                  <div v-for="(course, index) in courseList" :key="index" class="w-[95%] mx-auto">
                    <div v-if="course.goods_type === 2" class="flex justify-between items-center text-[24px] font-JhengHei font-semibold text-dark-gray px-8 py-5 border-y border-light-gary">
                      <div>
                        <span>{{ index + 1 }}</span>
                        <span class="ml-28">{{ orderDetail(course) }}</span>
                      </div>
                      <div @click="changeMain(course)" v-if="course.permission">
                        <img v-if="course.permission.permission === 2" :src="OpenImg" alt="打開按鈕" class="w-[44px] h-[22px] cursor-pointer">
                        <img v-else :src=CloseImg alt="關閉按鈕" class="w-[44px] h-[22px] cursor-pointer">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 儲存按鈕 -->
              <div class="pt-6 self-start">
                <button type="button" @click="cancelEdit()"
                  class="!me-4 !border !border-main-red !text-main-red !rounded !px-3 !py-1 !cursor-pointer !w-[150px] !h-[40px] !text-[18px] !text-center !pt-1.5">
                  取消</button>
                <button type="button" @click="saveItem()"
                  class="!border !border-blue-green !text-white !bg-blue-green !rounded !px-3 !py-1 !cursor-pointer !w-[150px] !h-[40px] !text-[18px] !text-center !pt-1.5">
                  儲存</button>
              </div>
            </div>
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

    /* 確認收款button慢慢填充效果 */
    button {
      @apply relative overflow-visible z-[1];
    }

    button:hover::after {
      @apply w-full opacity-[1];
    }
    /* 按鈕未激活狀態 */
    button.inactive {
      @apply bg-light-light-gary text-dark-gray border-0;
    }
    .active{
      @apply bg-main-red text-white;
    }
    .active-1{
      @apply bg-blue-green text-white;
    }
</style>

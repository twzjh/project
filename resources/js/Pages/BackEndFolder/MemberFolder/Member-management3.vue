<script>
import BackendNav from '@/Components/BackendNav.vue';
import chevronLeft from '/images/BackEndIcon/chevron-left.svg';
import arrowLeft from '/images/BackEndIcon/Vector-3.png';
import chevronRight from '/images/BackEndIcon/chevron-right.svg';
import chevronDown from '/images/BackEndIcon/chevron-down.svg';
import clock from '/images/BackEndIcon/clock-regular.svg';
import calendar from '/images/BackEndIcon/calendar-days-solid.svg';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav,
    Link,
    Head,
  },
  props: {
    userData: Object,
  },
  data() {
    return {
      chevronLeft,
      chevronRight,
      chevronDown,
      clock,
      calendar,
      arrowLeft,
      // 保存初始資料
      initialFormData: {},
      memberForm: {
        id: this.userData.id,
        status: this.userData.member.member_status,
        email: this.userData.email,
        name: this.userData.name,
        phone: this.userData.member.member_phone,
        birthday: this.userData.member.member_birthday,
        birthTime: this.userData.member.member_birth_time,
        birthCity: this.userData.member.member_city,
        address: this.userData.member.member_address,
      },
    };
  },
  mounted() {
    // 保存表單初始數據
    this.initialFormData = Object.assign({}, this.memberForm);
  },
  methods: {
    // 重置表單資料為更改前
    resetForm() {
      this.memberForm = Object.assign({}, this.initialFormData);
    },
    // 儲存修改
    updateMember() {
      Swal.fire({
        title: '是否確定修改?',
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
          this.$inertia.post(route('backmember.editupdae'), this.memberForm,
            {
              onSuccess: (res) => {
                const msg = res.props.flash.message;
                Swal.fire({
                  title: `資料更新${msg}`,
                  buttonsStyling: false,
                  customClass: {
                    popup: 'w-[300px]',
                    title: 'font-JhengHei text-black border-0 pt-[20px]',
                    actions: 'w-[40%] mt-2',
                    confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
                  },
                });
                this.initialFormData = Object.assign({}, this.memberForm);
              },
            });
        }
      });
    },
    // 跳轉到購買紀錄頁
    recordPage(id) {
      this.$inertia.get(route('backmember.record'), { 'userId': id });
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Microsoft JhengHei';
}

body {
  /* display: flex; */
  /* justify-content: center; */
  /* align-items: center; */
  min-height: 100vh;
  flex-direction: column;
  gap: 30px;
  /* background: #121214; */
}

.inputBox {
  position: relative;
  width: 420px;
}

.inputBox input {
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
  /* border-left: 1px solid #000000; */
  /* border-right: 1px solid #000000; */
  letter-spacing: 0.2em;
}

/* .inputBox:nth-child(2) input:valid~span,
.inputBox:nth-child(2) input:focus~span {
  background: white;
  color: #121214;
  border-radius: 2px;
} */

.inputBox input:valid,
.inputBox input:focus {
  border: 1px solid #b5b5b5;
}

.inputBoxvalue~span {
  color: #b5b5b5;
  transform: translateX(14px) translateY(-7px);
  font-size: 0.8em;
  padding: 0;
  background: white;
  /* border-left: 1px solid #000000; */
  /* border-right: 1px solid #000000; */
  letter-spacing: 0.2em;
}

.inputBoxvalue2~span {
  color: #b5b5b5;
  transform: translateX(14px) translateY(-7px);
  font-size: 0.8em;
  padding: 0;
  background: white;
  /* border-left: 1px solid #000000; */
  /* border-right: 1px solid #000000; */
  letter-spacing: 0.2em;
}

.inputBoxvalue {
  background-color: #d9d9d9 !important;
}

.inputBox input {
  padding-left: 12px;
}
</style>

<template>
  <Head title="後臺會員個人資料"></Head>
  <BackendNav>
    <template v-slot:title>
      <h2 class="!pl-10 !pt-4 !font-JhengHei !text-2xl !font-bold !flex !leading-[40px]">
        <Link :href="route('member.manage')"
          class="relative !font-JhengHei !text-lg !bg-dark-dark-gary !w-[88px] !h-[40px] !rounded !text-white !cursor-pointer !mr-4 !pt-[6px] !text-center">
          <img :src="arrowLeft" class="absolute top-[14px] left-[12px]">
          &nbsp;返回</Link>會員管理<span class="text-light-gary">&nbsp;▸&nbsp;</span> {{ initialFormData.name }}
      </h2>
    </template>
    <template v-slot:content>
      <main class="!overflow-">
        <div class="!w-full !h-4 !shadow-xl !mb-5"></div>
        <div class="!flex">
          <div
            class="!ml-10 !text-2xl !font-JhengHei !p-3  !bg-dark-gray !w-[146px] !rounded  !mb-5 !text-center cursor-pointer !text-white">
            個人資料
          </div>
          <Link @click="recordPage(memberForm.id)"
            class="!ml-5 !text-2xl !font-JhengHei !p-3 !border-2 !border-dark-gray !w-[146px] !text-bg-dark-gray !rounded  !mb-5 !text-center !cursor-pointer text-dark-gray">
            購買紀錄
          </Link>
        </div>
        <div class="!w-[486px] !h-[643px] !border-2 !shadow-sm !ml-[40px] !bg-white !flex !flex-wrap !justify-center">
          <div class="!h-[64px] !text-[32px] !font-bold !pt-6 !font-JhengHei !mr-[290px]">會員資料</div>
          <form class="!w-[420px]" @submit.prevent="updateMember()">
            <div class="!flex !item-center !justify-between">
              <div class="inputBox !w-[120px]">
                <input type="text" required="required" value="1" class="inputBoxvalue !pl-3 !pt-3" readonly>
                <span>會員編號</span>
              </div>
              <div class="inputBox !w-[160px] ">
                <input type="text" required="required" value="2022/01/02" class="inputBoxvalue !pl-3 !pt-3" readonly>
                <span>創建日期</span>
              </div>
              <div class="relative">
                <span class="!absolute !text-[13px] !bg-white !left-3 !bottom-[35px] !text-light-gary">會員狀態</span>
                <select required="required" v-model="memberForm.status"
                  class="select2 !w-[120px] !h-[48px] !text-main-red !border-light-gary !rounded !cursor-pointer !pl-3 !pt-1">
                  <!-- <option value="inactive" disabled selected>會員狀態</option> -->
                  <option value="1" class="!text-light-gary !hover:text-black">使用中</option>
                  <option value="2" class="!text-light-gary !hover:text-black">停權</option>
                </select>
              </div>
            </div>
            <div class="!border-b !mt-4 !border-light-gary"></div>
            <div class="inputBox !my-4 ">
              <input type="text" required="required" v-model="memberForm.email">
              <span>帳號(E-mail)</span>
            </div>
            <div class="inputBox">
              <input type="text" required="required" v-model="memberForm.name">
              <span>姓名</span>
            </div>
            <div class="inputBox !mt-4">
              <input type="text" required="required" v-model="memberForm.phone">
              <span>手機號碼</span>
            </div>
            <div class="!flex !item-center !mt-4 ">
              <div class="inputBox !w-[200px] !mr-5">
                <input type="date" required="required" class="inputBoxvalue2 !pl-3 " v-model="memberForm.birthday">
                <span>出生日期</span>
                <!-- <img :src="calendar" alt="" class="h-[20px] w-[20px] absolute left-[170px] top-[13px]"> -->
              </div>
              <div class="inputBox !w-[200px]">
                <input type="time" required="required" class="inputBoxvalue2 !pl-3" v-model="memberForm.birthTime">
                <span>出生時間</span>
                <!-- <img :src="clock" alt="" class="h-[20px] w-[20px] absolute left-[170px] top-[13px]"> -->
              </div>
            </div>
            <div class="inputBox !my-4 ">
              <input type="text" required="required" v-model="memberForm.birthCity">
              <span>出生城市</span>
            </div>
            <div class="inputBox ">
              <input type="text" required="required" v-model="memberForm.address">
              <span>地址</span>
            </div>
            <div class="!border-b !mt-4 !border-light-gary"></div>
            <div class="!flex !mt-4 !justify-center !items-center !space-x-4">
              <button type="button" @click="resetForm()"
                class="!me-4 !border !border-main-red !text-main-red !rounded !px-3 !py-1 !cursor-pointer !w-[200px] !h-[40px] !text-[18px] !text-center !pt-1.5">
                取消</button>
              <button type="submit"
                class="!border !border-blue-green !text-white !bg-blue-green !rounded !px-3 !py-1 !cursor-pointer !w-[200px] !h-[40px] !text-[18px] !text-center !pt-1.5">
                儲存</button>
            </div>
          </form>
        </div>
      </main>
    </template>

  </BackendNav>
</template>

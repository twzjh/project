<script>
import clock from '/images/BackEndIcon/clock-regular.svg';
import calendar from '/images/BackEndIcon/calendar-days-solid.svg';
import eye_0 from '/images/BackEndIcon/eye-0.png';
import eye_1 from '/images/BackEndIcon/eye-1.png';

export default {
  props: {
    errors: Object,
  },
  data() {
    return {
      clock,
      calendar,
      eye_0,
      eye_1,
      passwordVisible: false,
      passwordVisible2: false,
      memberForm: {
        name: '',
        phone: '',
        birthday: '',
        birthTime: '',
        birthCity: '',
        address: '',
        email: '',
        password: '',
        confirmPassword: '',
      },
    };
  },
  computed: {
    eyeIcon() {
      return this.passwordVisible ? this.eye_0 : this.eye_1;
    },

    eyeIcon2() {
      return this.passwordVisible2 ? this.eye_0 : this.eye_1;
    },
  },
  methods: {
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },

    togglePasswordVisibility2() {
      this.passwordVisible2 = !this.passwordVisible2;
    },
    resetForm() {
      this.$inertia.get(route('member.manage'));
    },
    // 新增會員
    submitForm() {
      Swal.fire({
        title: '是否確定新增?',
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
          this.$inertia.post(route('member.addMember'), this.memberForm,
            {
              onSuccess: (res) => {
                const msg = res.props.flash.message;
                Swal.fire({
                  title: `會員新增${msg}`,
                  buttonsStyling: false,
                  customClass: {
                    popup: 'w-[300px]',
                    title: 'font-JhengHei text-black border-0 pt-[20px]',
                    actions: 'w-[40%] mt-2',
                    confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
                  },
                }).then((result) => {
                  if (result.isConfirmed) {
                    this.$inertia.get(route('member.manage'), { 'jumpNow': 0 });
                  }
                });
              },
              onError: () => {
                if (this.errors.email) {
                  this.$refs.emailInput.focus();
                }
                else if (this.errors.password) {
                  this.$refs.passwordInput.focus();
                }
                this.$refs.confirmPasswordInput.focus();
              },
            });
        }
      });
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

.inputBox input {
  padding-left: 12px;
}

.inputBoxvalue~span {
  color: #b5b5b5;
  transform: translateX(14px) translateY(-7px);
  font-size: 0.8em;
  padding: 0;
  background: white;
  letter-spacing: 0.2em;
}

.inputBoxvalue3~span {
  color: #b5b5b5 !important;
  transform: translateX(14px) translateY(-7px) !important;
  font-size: 0.8em !important;
  padding: 0 !important;
  background: white !important;
  letter-spacing: 0.2em !important;
}
.personal {
  @apply text-[32px] font-bold ml-4 mt-4
}
</style>

<template>
  <form class="!w-[578px] !h-auto bg-white !rounded-lg !pb-4" @submit.prevent="submitForm()">
    <div class="!h-[64px] !bg-dark-gray !text-white !text-[24px] !text-center !font-bold !pt-4 !rounded-t">新增會員</div>
    <div class="personal">個人資料</div>
    <div class="inputBox !ml-4 !my-4 ">
      <input type="text" required="required" v-model="memberForm.name">
      <span>姓名</span>
    </div>
    <div class="inputBox !ml-4">
      <input type="text" required="required" v-model="memberForm.phone">
      <span>手機號碼</span>
    </div>
    <div class="!flex !item-center !mt-4 !ml-4">
      <div class="inputBox !w-[200px] !mr-5">
        <input type="date" required="required" class="inputBoxvalue3 !pl-3" v-model="memberForm.birthday">
        <span>出生日期</span>
      </div>
      <div class="inputBox !w-[200px]">
        <input type="time" required="required" class="inputBoxvalue3 !pl-3" v-model="memberForm.birthTime">
        <span>出生時間</span>
      </div>
    </div>
    <div class="inputBox !ml-4 !my-4 ">
      <input type="text" required="required" v-model="memberForm.birthCity">
      <span>出生城市</span>
    </div>
    <div class="inputBox !ml-4">
      <input type="text" required="required" v-model="memberForm.address">
      <span>地址</span>
    </div>
    <div class="!border-b !mt-4 !ml-4 !border-light-gary !w-[90%]"></div>
    <div class="!text-[32px] !font-bold !ml-4 !mt-4">電子郵件</div>
    <div class="!text-[18px]  !ml-4 !mt-4 !text-light-gary">此信箱同時作為登入帳號使用。</div>
    <div v-if="errors.email" class="text-[18px] !ml-4 !mt-2 text-main-red">{{ errors.email }}</div>
    <div class="inputBox !ml-4 !mt-4 ">
      <input type="email" required="required" v-model="memberForm.email" ref="emailInput">
      <span>電子郵件</span>
    </div>
    <div class="!text-[32px] !font-bold !ml-4 !mt-4">密碼</div>
    <div v-if="errors.password" class="!text-[18px]  !ml-4 !mt-2 text-main-red">{{ errors.password }}</div>
    <div class="inputBox !ml-4 !my-4">
      <input :type="passwordVisible ? 'text' : 'password'" required="required" v-model="memberForm.password" ref="passwordInput">
      <span>密碼/至少6碼/英數混和</span>
      <img :src="eyeIcon" alt="" class="!h-[20px] !w-[20px] !absolute !left-[380px] !top-[13px]"
        @click="togglePasswordVisibility">
    </div>
    <div v-if="errors.confirmPassword" class="text-[18px] !ml-4 !mb-2 text-main-red">{{ errors.confirmPassword }}</div>
    <div class="inputBox !ml-4">
      <input :type="passwordVisible2 ? 'text' : 'password'" required="required" v-model="memberForm.confirmPassword" ref="confirmPasswordInput">
      <span>再次輸入密碼</span>
      <img :src="eyeIcon2" alt="" class="!h-[20px] !w-[20px] !absolute !left-[380px] !top-[13px]"
        @click="togglePasswordVisibility2">
    </div>
    <div class="!border-b !mt-4 !ml-4 !border-light-gary !w-[90%]"></div>
    <div class="!flex !mt-4 !justify-center !items-center">
      <button type="button" @click="resetForm()"
        class="!me-4 !border !border-main-red !text-main-red !rounded !px-3 !py-1 !cursor-pointer !w-[120px] !h-[40px] !text-[18px] !text-center !pt-1.5 !hover:bg-light-light-gary/50">
        取消
      </button>
      <button type="submit"
        class="!border !border-blue-green !text-white !bg-blue-green !rounded !px-3 !py-1 !cursor-pointer !w-[120px] !h-[40px] !text-[18px] !text-center !pt-1.5 !hover:bg-blue-green/90">
        新增
      </button>
    </div>
  </form>
</template>

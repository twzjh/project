<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import eye1 from '/images/BackEndIcon/eye-1.png';
import eye0 from '/images/BackEndIcon/eye-0.png';
import { Link, useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    Navbar,
    Footer,
    Link,
    Head,
  },

  data() {
    return {
      eye1,
      eye0,
      rule: 0,
      show: false,
      shows: false,
      showEye: eye1,
      showEyes: eye1,
      passwordType: 'password',
      passwordTypes: 'password',
      form: useForm({
        email: '',
        password: '',
        remember: false,
      }),
      registerForm: useForm({
        member_phone: '',
        member_birthday: new Date().toISOString().substr(0, 10),
        member_birth_time: new Date().toISOString(),
        member_city: '',
        member_address: '',
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        remember: false,
      }),
    };
  },

  methods: {
    login() {
      this.rule = 0;
    },

    register() {
      this.rule = 1;
    },
    openEye() {
      this.show = !this.show;

      if (this.show === true) {
        this.passwordType = 'text';
        this.showEye = eye0;
      } else {
        this.passwordType = 'password';
        this.showEye = eye1;
      }
    },
    openEyes() {
      this.shows = !this.shows;

      if (this.shows === true) {
        this.passwordTypes = 'text';
        this.showEyes = eye0;
      } else {
        this.passwordTypes = 'password';
        this.showEyes = eye1;
      }
    },
    submitBtn() {
      Swal.fire({
        title: '成功註冊!',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[360px]',
          title: 'font-JhengHei text-black border-0 font-bold text-[30px]',
          htmlContainer: 'font-JhengHei text-dark-gray m-0 pl-[25px] text-[24px] font-normal',
          actions: 'w-[88%] pt-[15px]',
          confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
        },
      });
    },
    submitForm() {
      this.form.post(route('login'), {
        onFinish: () => this.form.reset('password'),
      });
    },
    // 密碼判斷是否一致
    registerMember() {
      const password = this.registerForm.password;
      const password_confirmation = this.registerForm.password_confirmation;
      const hasLetterAndNumber = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
      if (password !== password_confirmation || !hasLetterAndNumber.test(password) || password.length < 8) {
        Swal.fire({
          icon: 'warning',
          title: '請重新確認密碼',
          text: '至少8碼 , 英數混合',
        });
        return;
      }
      this.submitBtn();
      this.registerForm.post(route('register'), {
        onFinish: () => this.registerForm.reset('password'),
      });
    },
  },
};
</script>

<template>
  <Head title="登入註冊"></Head>
  <Navbar></Navbar>
  <!-- //標題:登入註冊 -->
  <div class="!w-full !h-[444px] bg-black !pt-[224px] !pb-[128px] gap-4">
    <div class="w-full h-[100px] flex justify-center">
      <div class="w-[300px] h-[100px] border-b-2 text-center text-main-white">
        <span
          class="!font-NotoSerif !w-[260px] !h-[92px] !leading-[91.97px] !font-bold !text-[64px] !tracking-[0.02em] text-main-white">登入註冊</span>
      </div>
    </div>
  </div>
  <!-- //登入 -->
  <div class="!w-full !sm:h-[714px] !sm:mt-0 !sm:pt-[60px] !mt-[30px] !mb-16 sm:!mt-[60px] bg-main-white flex justify-center"
    v-if="rule === 0">
    <div class="sm:w-[472px] sm:h-[534px] w-[342px] h-[520px] bg-main-white">
      <div
        class="w-full font-JhengHei font-normal sm:text-[24px] text-[16px] text-lake-green flex sm:justify-between justify-around items-center">
        <button type="button"
          class="xl:w-[200px] sm:w-[200px] xl:h-[56px] sm:h-[56px] w-[147.5px] h-[44px] border border-lake-green rounded hover:bg-lake-green hover:text-[#FDFDFD]"
          :class="{ 'bg-color': rule === 0 }" @click="login()">登入</button>
        <div class="sm:h-[40px] sm:border-l sm:border-light-gary"></div>
        <button type="button"
          class="xl:w-[200px] sm:w-[200px] xl:h-[56px] sm:h-[56px] w-[147.5px] h-[44px] border border-lake-green rounded hover:bg-lake-green hover:text-[#FDFDFD]"
          :class="{ 'bg-color': rule === 1 }" @click="register()">註冊</button>
      </div>
      <div class="w-full h-[454px] !mt-[24px] border-2 rounded !p-[24px] shadow-main-white">
        <form class="font-JhengHei" @submit.prevent="submitForm">
          <div class="w-full grid gap-2 sm:!gap-4">
            <label class="leading-[42.56px] font-bold sm:text-[32px] text-[20px]" for="email">帳號</label>
            <div class="inputBox !w-full">
              <input type="email" v-model="form.email" id="email" required>
              <span class="sm:text-[18px] text-[12px]">帳號</span>
            </div>
          </div>
          <div class="w-full grid gap-2 sm:!gap-4 !pt-[24px] relative">
            <label class="leading-[42.56px] font-bold sm:text-[32px] text-[20px]" for="password">密碼</label>
            <div class="inputBox !w-full">
              <input :type="passwordType" v-model="form.password" id="password" required>
              <span class="sm:text-[18px] text-[12px]">密碼</span>
              <img :src="showEye" alt="眼睛" class="w-[18px] h-[18px] absolute bottom-[15px] right-[15px]"
                @click="openEye()">
            </div>
          </div>
          <div class="grid gap-6 !pt-[24px]">
            <div class="w-full h-[24px] font-JhengHei flex items-center">
              <label class="" for=""></label>
              <input class="sm:!w-[20px] sm:!h-[20px] w-[15px] h-[15px]" type="checkbox" name="Tick" required>&nbsp;
              <span class="ml-[4px] sm:text-[18px] text-[12px]">同意本站的</span>
              <Link href="/paymentTerms">
                <span class="text-blue-500 font-normal sm:text-[18px] text-[12px]">付款退款條款</span>
              </Link>
              <span class="font-normal sm:text-[18px] text-[12px]">與</span>
              <Link href="/privacy">
                <span class="text-blue-500 font-normal sm:text-[18px] text-[12px]">隱私權政策</span></Link>。
            </div>
            <span>
              <Link href="/forgot-password" class="text-dark-gray font-normal sm:text-[18px] text-[12px]">忘記密碼?</Link>
            </span>
            <button type="submit"
              class="sm:w-full sm:h-[48px] w-full h-[36px] bg-blue-green rounded-lg font-JhengHei font-normal sm:text-[24px] text-[16px] text-main-white">登入會員</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- //註冊 -->
  <div class="w-full h-[1079px] !pt-[60px] bg-main-white flex justify-center relative" v-if="rule === 1">
    <div class="sm:w-[472px] sm:h-[899px] w-[342px] h-[534px] grid gap-6 bg-main-white">
      <div
        class="sm:w-full sm:h-full h-[44px] w-[343px] font-JhengHei font-normal sm:text-[24px] text-[16px] text-lake-green flex sm:justify-between justify-around items-center">
        <button type="button"
          class="xl:w-[200px] sm:w-[200px] xl:h-[56px] sm:h-[56px] w-[147.5px] h-[44px] border border-lake-green rounded hover:bg-lake-green hover:text-[#FDFDFD]"
          :class="{ 'bg-color': rule === 0 }" @click="login()">登入</button>
        <div class="sm:h-[40px] sm:border-l sm:border-light-gary"></div>
        <button type="button"
          class="xl:w-[200px] sm:w-[200px] xl:h-[56px] sm:h-[56px] w-[147.5px] h-[44px] border border-lake-green rounded hover:bg-lake-green hover:text-[#FDFDFD]"
          :class="{ 'bg-color': rule === 1 }" @click="register()">註冊</button>
      </div>

      <div class="w-full h-[850px] grid gap-6 sm:!p-[24px] !px-4 border-2 rounded shadow-main-white">
        <div class="w-full h-[355px] !pt-[24px] sm:!pt-0 grid gap-4">
          <span class=" h-[43px] font-JhengHei font-bold sm:text-[32px] text-[20px]">個人資料</span>
          <form class="w-full h-[296px] font-JhengHei grid gap-4" @submit.prevent="registerMember">
            <div class="">
              <label class="" for="name"></label>
              <div class="inputBox !w-full">
                <input type="text" v-model="registerForm.name" id="name" required>
                <span class="sm:text-[18px] text-[12px]">姓名</span>
              </div>
            </div>

            <div class="">
              <label class="" for="member_phone"></label>
              <div class="inputBox !w-full">
                <input type="text" v-model="registerForm.member_phone" id="member_phone" required>
                <span class="sm:text-[18px] text-[12px]">手機號碼</span>
              </div>
            </div>

            <div class="sm:w-[420px] w-[311px] h-[48px] flex justify-between">
              <div>
                <label class="" for="member_birthday"></label>
                <input placeholder="出生日期"
                  class="sm:w-[200px] w-[145.5px] h-[48px] font-normal text-[14px] rounded placeholder-light-gary bg-white"
                  type="date" name="出生日期" v-model="registerForm.member_birthday" id="member_birthday" required>
              </div>
              <div>
                <label class="" for="member_birth_time"></label>
                <input placeholder="出生時間"
                  class="sm:w-[200px] w-[145.5px] h-[48px] font-normal text-[14px] rounded placeholder-light-gary bg-white"
                  type="time" name="出生時間" v-model="registerForm.member_birth_time" id="member_birth_time" required>
              </div>
            </div>

            <div class="">
              <label class="" for="member_city"></label>
              <div class="inputBox !w-full">
                <input type="text" v-model="registerForm.member_city" id="member_city" required>
                <span class="sm:text-[18px] text-[12px]">出生城市</span>
              </div>
            </div>

            <div class="">
              <label class="" for="member_address"></label>
              <div class="inputBox !w-full">
                <input type="text" v-model="registerForm.member_address" id="member_address" required>
                <span class="sm:text-[18px] text-[12px]">地址</span>
              </div>
            </div>

            <div class="grid gap-2 xl:mt-[13px]">
              <label class=" font-bold sm:text-[32px] text-[20px]" for="member-email">電子郵件</label>
              <h4 class="text-dark-gray font-normal sm:text-[18px] text-[12px]">此信箱同時作為登入帳號使用。</h4>
              <div class="inputBox !w-full">
                <input type="email" v-model="registerForm.email" id="member-email" required>
                <span class="sm:text-[18px] text-[12px]">電子郵件</span>
              </div>
            </div>

            <div class="grid gap-3 xl:mt-[15px]">
              <label class=" font-bold sm:text-[32px] text-[20px]" for="member-password">密碼</label>
              <div class="inputBox !w-full">
                <input :type="passwordType" v-model="registerForm.password" id="member-password" required>
                <span class="sm:text-[18px] text-[12px]">密碼/至少8碼/英數混合</span>
                <img :src="showEye" alt="眼睛" class="w-[18px] h-[18px] absolute bottom-[15px] right-[15px]"
                  @click="openEye()">
              </div>
              <label for="confirm-password"></label>
              <div class="inputBox !w-full">
                <input :type="passwordTypes" v-model="registerForm.password_confirmation" id="confirm-password"
                  required>
                <span class="sm:text-[18px] text-[12px]">請再次輸入密碼</span>
                <img :src="showEyes" alt="眼睛" class="w-[18px] h-[18px] absolute bottom-[15px] right-[15px]"
                  @click="openEyes()">
              </div>

              <div class="w-full h-[24px] font-JhengHei flex items-center">
                <label class="" for=""></label>
                <input class="sm:w-[20px] sm:h-[20px] w-[15px] h-[15px]" type="checkbox" name="Tick" required>&nbsp;
                <span class="ml-[4px] sm:text-[18px] text-[12px]">同意本站的</span>
                <Link href="/paymentTerms">
                  <span class="text-blue-500 font-normal sm:text-[18px] text-[12px]">付款退款條款</span></Link>
                <span class="font-normal sm:text-[18px] text-[12px]">與</span>
                <Link href="/privacy">
                  <span class="text-blue-500 font-normal sm:text-[18px] text-[12px]">隱私權政策</span></Link>。
              </div>
              <button type="submit"
                class="sm:w-full sm:h-[48px] w-[311px] h-[36px] bg-blue-green rounded-lg font-JhengHei font-normal sm:text-[24px] text-[16px] text-main-white">註冊會員</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Microsoft JhengHei';
}

body {
  min-height: 100vh;
  flex-direction: column;
  gap: 30px;
}

.inputBox {
  position: relative;
  width: 100%;
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
  color: #b5b5b5;
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
}

.inputBox input:valid,
.inputBox input:focus {
  border: 1px solid #b5b5b5;
}

.inputBox input {
  padding-left: 12px;
}

.bg-color {
  @apply bg-lake-green text-[#FDFDFD];
}
</style>

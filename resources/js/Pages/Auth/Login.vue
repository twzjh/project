<script>
import logo from '/images/BackEndIcon/Logo.png';
import eye1 from '/images/BackEndIcon/eye-1.png';
import eye0 from '/images/BackEndIcon/eye-0.png';
import { Link, useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

// 後台登入頁面(已由Backlogin移過來)
export default {
  components: {
    Head,
    Link,
  },

  data() {
    return {
      logo: logo,
      eye1,
      eye0,
      rule: 0,
      show: false,
      showEye: eye1,
      passwordType: 'password',
      form: useForm({
        email: '',
        password: '',
        from: 'admin',
        remember: false,
      }),
    };
  },
  methods: {
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
    submitForm() {
      this.form.post(route('login'), {
        onFinish: () => this.form.reset('password'),
      });
    },
  },
};

</script>

<template>

  <Head title="後台登入"></Head>
  <div class="w-full h-[945px] bg-white font-JhengHei flex justify-center items-center relative">
    <div
      class="w-full h-20 bg-light-light-gary p-3 flex text-center items-center text-main-black font-bold text-3xl font-JhengHei absolute top-0">
      <img :src="logo" alt="" class="w-[44px] me-3 ml-10">
      <span>五術研究社 後台管理</span>
    </div>
    <div class="w-[468px] h-[400px] grid gap-6 p-[24px] border-2 rounded shadow-main-white bg-main-white">
      <form class="w-[420px] h-[238px] font-JhengHei grid gap-6" @submit.prevent="submitForm">
        <div class="w-[420px] h-[107px] grid gap-4">
          <label class="leading-[42.56px] font-bold text-[32px]" for="email">帳號</label>
          <input placeholder="帳號"
            class="placeholder-light-gary w-[420px] h-[48px] font-normal text-[18px] rounded-md bg-white" type="email"
            name="email" id="email" required v-model="form.email">
        </div>
        <div class="w-[420px] h-[107px] grid gap-4 relative">
          <label class="leading-[42.56px] font-bold text-[32px]" for="password">密碼</label>
          <img :src="showEye" alt="眼睛" class="w-[18px] h-[18px] absolute bottom-[15px] right-[15px]" @click="openEye()">
          <input placeholder="密碼"
            class="placeholder-light-gary w-[420px] h-[48px] font-normal text-[18px] rounded-md bg-white"
            :type="passwordType" name="" id="" required v-model="form.password">
          <span>
            <Link href="/back_forget" class="text-dark-gray font-normal sm:text-[18px] text-[12px]">忘記密碼?</Link>
          </span>
          <button type="submit"
            class="w-[420px] h-[48px] bg-blue-green rounded-lg font-JhengHei font-normal text-[24px] text-main-white">登入</button>
        </div>
      </form>
    </div>
  </div>
</template>

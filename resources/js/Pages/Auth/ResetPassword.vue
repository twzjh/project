<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

// 修改密碼(原生改)
const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const confirmDialog = () => {
  const password = form.password;
  const password_confirmation = form.password_confirmation;
  const hasLetterAndNumber = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
  if (password === password_confirmation && hasLetterAndNumber.test(password) && password.length >= 8) {
    Swal.fire({
      title: '密碼修改成功!',
      text: '請以新密碼重新登入',
      icon: 'success',
      buttonsStyling: false,
      customClass: {
        popup: 'w-[360px]',
        title: 'font-JhengHei text-black border-0 font-bold text-[32px]',
        htmlContainer: 'font-JhengHei text-dark-gray text-start m-0 pl-[25px] text-[24px] font-normal',
        actions: 'w-[88%] pt-[15px]',
        confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full text-[18px]',
      },
      confirmButtonText: 'OK',
    });
  } else {
    Swal.fire({
      icon: 'warning',
      title: '請確認輸入是否相同',
    });
    return 'error';
  }
};

const submit = () => {
  const mes = confirmDialog();
  if (mes === 'error') {
    Swal.fire({
      icon: 'warning',
      title: '至少8個字元，不可有空白與特殊符號，需英數混和',
    });
    return;
  }
  form.post(route('password.store'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    },
  });
};

</script>

<template>
  <Navbar></Navbar>
  <div
    class="w-full xl:h-[444px] sm:h-[323px] h-[234px]  bg-black xl:pt-[224px] xl:pb-[120px] sm:pt-[160px] sm:pb-[80px] pt-[120px] pb-[60px] gap-4">
    <div class="w-full xl:h-[100px] sm:h-[83px] h-[54px] flex justify-center gap-2">
      <div
        class="xl:w-[300px] xl:h-[100px] sm:w-[300px] sm:h-[90px] w-[120px] h-[75px] border-b-2 text-center text-main-white">
        <span
          class="font-NotoSerif leading-[91.97px] font-bold xl:text-[64px] sm:text-[52px] text-[29px] tracking-[0.02em] text-main-white">修改密碼</span>
      </div>
    </div>
  </div>

  <div class="w-full sm:pt-[60px] sm:pb-[120px]  bg-main-white flex justify-center">
    <form
      class="xl:w-[468px] sm:w-[468px] w-full grid gap-6 p-6 border-2 rounded font-JhengHei shadow-main-white"
      @submit.prevent="submit">
      <div>
        <div class="mb-6">
          <label class="leading-[23.94px] font-normal xl:text-[18px] sm:text-[18px] text-[12px]"
            for="password" value="Password">至少8個字元，不可有空白與特殊符號，需英數混和</label>
          <input placeholder="輸入新密碼"
            class="placeholder-light-gary w-full h-[48px] font-normal xl:text-[18px] sm:text-[18px] text-[12px] rounded-md bg-white mt-4"
            id="password"
            type="password" v-model="form.password" required>
        </div>
        <div class="pb-6">
          <label class="leading-[23.94px] font-normal text-[18px]" for="password_confirmation" value="Confirm Password"></label>
          <input placeholder="再次輸入密碼"
            class="placeholder-light-gary w-full h-[48px] font-normal xl:text-[18px] sm:text-[18px] text-[12px] rounded-md bg-white"
            id="password_confirmation"
            type="password" v-model="form.password_confirmation"
            required>
          <InputError class="" :message="form.errors.password" />
        </div>
        <button type="submit" class="w-full h-[48px] bg-blue-green rounded-lg font-normal text-[24px] text-main-white">確定</button>
      </div>
    </form>
  </div>
  <Footer></Footer>
</template>

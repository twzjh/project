<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import logo from '/images/BackEndIcon/Logo.png';

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
      router.push({ path: 'login' });
    },
  });
};

</script>

<template>
  <div class="w-full h-[945px] bg-white font-JhengHei flex justify-center items-center">
    <div
      class="w-full h-20 bg-light-light-gary p-3 flex text-center items-center text-main-black font-bold text-3xl font-JhengHei absolute top-0">
      <img :src="logo" alt="" class="w-[44px] me-3 ml-10">
      <span>五術研究社 後台管理</span>
    </div>
    <div class="w-[468px] h-[280px] grid gap-6 p-[24px] border-2 rounded shadow-main-white bg-main-white">
      <form @submit.prevent="submit">
        <div class="w-[420px] h-[88px] grid gap-6">
          <div class="grid gap-4">
            <label class="leading-[23.94px] font-normal text-[18px]" for="password"
              value="Password">至少8個字元，不可有空白與特殊符號，需英數混和</label>
            <input placeholder="輸入新密碼"
              class="placeholder-light-gary w-[420px] h-[48px] font-normal text-[18px] rounded-md bg-white"
              id="password" type="password" v-model="form.password" required>
          </div>
          <div class="">
            <label class="leading-[23.94px] font-normal text-[18px]" for="password_confirmation"
              value="Confirm Password"></label>
            <input placeholder="再次輸入密碼"
              class="placeholder-light-gary w-[420px] h-[48px] font-normal text-[18px] rounded-md bg-white"
              id="password_confirmation" type="password" v-model="form.password_confirmation" required>
            <InputError class="" :message="form.errors.password" />
          </div>
          <button type="submit"
            class="w-[420px] h-[48px] bg-blue-green rounded-lg font-normal text-[24px] text-main-white">確定</button>
        </div>
      </form>

    </div>
  </div>
</template>

<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    PrimaryButton,
    Navbar,
    Footer,
    InputError,
    Head,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      form: {
        email: '',
      },
    };
  },
  methods: {
    submit() {
      this.$inertia.post(route('password.email'), this.form,
        {
          preserveScroll: true,
          onSuccess: () => {
            Swal.fire({
              title: '重設密碼信件已寄送',
              text: '請前往您的E-mail重設密碼',
              buttonsStyling: false,
              customClass: {
                popup: 'w-[360px]',
                title: 'font-JhengHei text-black border-0 font-bold text-[32px]',
                htmlContainer: 'font-JhengHei text-dark-gray text-start m-0 pl-[25px] text-[24px] font-normal',
                actions: 'w-[88%] pt-[15px]',
                confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full text-[18px]',
              },
              confirmButtonText: 'OK',
            }).then((result) => {
              if (result.isConfirmed) {
                const inputElement = document.getElementById('email');
                if (inputElement) {
                  inputElement.value = '';
                }
              }
            });
          },
          onError: () => {
            if (this.errors.email) {
              this.$refs.emailInput.focus();
            }
          },
        });
    },
  },
};
</script>

<template>
  <Head title="忘記密碼"></Head>
  <Navbar></Navbar>
  <div
    class="w-full xl:h-[444px] sm:h-[323px] h-[234px]  bg-black xl:pt-[224px] xl:pb-[120px] sm:pt-[160px] sm:pb-[80px] pt-[120px] pb-[60px] gap-4">
    <div class="w-full xl:h-[100px] sm:h-[83px] h-[54px] flex justify-center gap-2">
      <div
        class="xl:w-[300px] xl:h-[100px] sm:w-[300px] sm:h-[90px] w-[120px] h-[75px] border-b-2 text-center text-main-white">
        <span
          class="font-NotoSerif leading-[91.97px] font-bold xl:text-[64px] sm:text-[52px] text-[29px] tracking-[0.02em] text-main-white">忘記密碼</span>
      </div>
    </div>
  </div>
  <div class="w-full xl:pt-[60px] sm:pt-[60px] sm:pb-[120px] bg-main-white flex justify-center">
    <form class="xl:w-[468px] sm:w-[468px] w-full grid gap-6 p-6 border-2 rounded-md font-JhengHei shadow-main-white"
      @submit.prevent="submit">
      <div class="grid">
        <label class="leading-[23.94px] font-normal text-[18px]" for="email" value="Email">請輸入您註冊時填寫的Email</label>
        <input placeholder="電子郵件/帳號"
          class="placeholder-light-gary  font-normal xl:text-[18px] sm:text-[18px] text-[12px] rounded bg-white mt-4"
          type="email" name="email" id="email" v-model="form.email" ref="emailInput" required>
        <InputError :message="errors.email" class="mt-1" />
      </div>
      <div class="flex items-center justify-end">
        <PrimaryButton :class="{ form, processing }" :disabled="form.processing">
          送出
        </PrimaryButton>
      </div>
    </form>
  </div>
  <Footer></Footer>
</template>

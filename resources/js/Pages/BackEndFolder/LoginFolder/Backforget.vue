<script>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import logo from '/images/BackEndIcon/Logo.png';

export default {
  components: {
    PrimaryButton,
    InputError,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      logo,
      form: {
        email: '',
      },
    };
  },
  // export default {
  //   data() {
  //     return {
  //       logo: logo,
  //     };
  //   },
  //   methods: {
  //     submitBtn() {
  //       Swal.fire({
  //         title: '重設密碼信件已寄送',
  //         text: '請前往您的E-mail重設密碼',
  //         buttonsStyling: false,
  //         customClass: {
  //           popup: 'w-[360px]',
  //           title: 'font-JhengHei text-black border-0 font-bold text-[32px]',
  //           htmlContainer: 'font-JhengHei text-dark-gray text-start m-0 pl-[25px] text-[24px] font-normal',
  //           actions: 'w-[88%] pt-[15px]',
  //           confirmButton: 'swal-btn bg-dark-gray text-white order-2 w-full',
  //         },
  //       });
  //     },
  //   },
  // };
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
  <div class="w-full h-[945px] bg-white font-JhengHei flex justify-center items-center">
    <div
      class="w-full h-20 bg-light-light-gary p-3 flex text-center items-center text-main-black font-bold text-3xl font-JhengHei absolute top-0">
      <img :src="logo" alt="" class="w-[44px] me-3 ml-10">
      <span>五術研究社 後台管理</span>
    </div>
    <div class="w-[468px] h-[208px] grid gap-6 p-[24px] border-2 rounded shadow-main-white bg-main-white">
      <form @submit.prevent="submit">
        <div class="w-[420px] h-[88px] grid gap-4">
          <label class="leading-[23.94px] font-normal text-[18px]" for="email" value="Email">請輸入您註冊時填寫的Email</label>
          <input placeholder="電子郵件/帳號"
            class="placeholder-light-gary w-[420px] h-[48px] font-normal text-[18px] rounded bg-white" type="email"
            name="email" id="email" v-model="form.email" ref="emailInput" required>
          <InputError :message="errors.email" class="mt-1" />
          <div class="flex items-center justify-end">
            <PrimaryButton :class="{ form, processing }" :disabled="form.processing">
              送出
            </PrimaryButton>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import InputError from '@/Components/InputError.vue';

export default {
  components: {
    InputError,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      passwordForm: {
        password: '',
        confirmPassword: '',
      },
    };
  },
  methods: {
    updatePassword() {
      this.$inertia.post(route('member.passwordEdit'), this.passwordForm,
        {
          preserveScroll: true,
          onSuccess: (res) => {
            const msg = res.props.flash.message;
            const textContent = msg === '成功' ? '下次登入請輸入新密碼' : '請重新嘗試修改';
            Swal.fire({
              title: `密碼修改${msg}`,
              text: textContent,
              buttonsStyling: false,
              customClass: {
                popup: 'w-[350px] justify-start',
                title: 'font-JhengHei text-black border-0 text-start pt-[20px] pl-[25px]',
                htmlContainer: 'font-JhengHei text-dark-gray text-start m-0 pl-[25px] font-size:24px text-[24px]',
                actions: 'w-[88%] pt-[15px]',
                confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
              },
            });
            // 清空
            for (let key in this.passwordForm) {
              this.passwordForm[key] = '';
            }
          },
          onError: () => {
            if (this.errors.password) {
              this.$refs.passwordInput.focus();
            }
            this.$refs.confirmPasswordInput.focus();
          },
        });
    },
  },
};
</script>

<template>
  <section>
    <form @submit.prevent="updatePassword" class="p-6 px-8 sm:min-w-[468px] shadow-cardShadow flex flex-col gap-y-6 xl:gap-y-4 w-11/12 sm:w-7/12 xl:w-[468px] m-auto">
      <h3>修改密碼</h3>
      <span class="text-dark-gray mb-1">至少8個字元，不可有空白與特殊符號，需英數混和</span>

      <div>
        <input
          id="password"
          ref="passwordInput"
          v-model="passwordForm.password"
          type="password"
          class="mt-1 block w-full"
          placeholder="輸入新密碼"
          required
        >
        <InputError :message="errors.password" class="mt-2" />
      </div>

      <div>
        <input
          id="password_confirmation"
          ref="confirmPasswordInput"
          v-model="passwordForm.confirmPassword"
          type="password"
          class="mt-1 block w-full"
          placeholder="再次輸入新密碼"
          required
        >
        <InputError :message="errors.confirmPassword" class="mt-2" />
      </div>

      <button type="submit" class="w-full bg-blue-green text-white text-[16px] sm:text-[24px] py-2 font-JhengHei rounded-md hover:bg-blue-green/95">確定修改</button>
    </form>
  </section>
</template>

<style scoped>
  h2{
    @apply font-NotoSerif text-white text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider border-b-4 p-0 pb-2 sm:mb-[40px] mb-[16px] xl:mb-[16px]
  }
  h3{
    @apply font-JhengHei text-[20px] sm:text-[32px] font-bold
  }
  input[type='password'] {
    @apply w-full py-[12px] border-light-gary rounded-md
  }
</style>

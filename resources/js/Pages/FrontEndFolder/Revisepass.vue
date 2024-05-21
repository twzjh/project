<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

export default {
  components: {
    Navbar,
    Footer,
  },
  methods: {
    submitBtn() {
      Swal.fire({
        title: '密碼修改成功!',
        text: '請以新密碼重新登入',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[360px]',
          title: 'font-JhengHei text-black border-0 font-bold text-[32px]',
          htmlContainer: 'font-JhengHei text-dark-gray text-start m-0 pl-[25px] text-[24px] font-normal',
          actions: 'w-[88%] pt-[15px]',
          confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
        },
        confirmButtonText: 'OK',
        preConfirm: () => {
          this.$inertia.get(route('mainlogin'));
        },
      });
    },
  },
};
</script>

<template>
  <Navbar></Navbar>
  <!-- //標題:修改密碼 -->
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
  <!-- //輸入內容 -->
  <div class="w-full xl:h-[381px] sm:h-[482px] xl:pt-[60px] sm:pt-[60px] bg-main-white flex justify-center">
    <form
      class="xl:w-[468px] sm:w-[468px] xl:h-[280px] sm:h-[280px] w-full h-[302px] grid gap-6 p-6 border-2 rounded font-JhengHei shadow-main-white"
      @submit.prevent="submitBtn">
      <div class="grid gap-6">
        <div class="grid gap-4">
          <label class="leading-[23.94px] font-normal xl:text-[18px] sm:text-[18px] text-[12px]"
            for="">至少6個字元，不可有空白與特殊符號，需英數混和</label>
          <input placeholder="輸入新密碼"
            class="placeholder-light-gary w-full h-[48px] font-normal xl:text-[18px] sm:text-[18px] text-[12px] rounded-md bg-white"
            required type="text" name="密碼" id="">
        </div>
        <div class="">
          <label class="leading-[23.94px] font-normal text-[18px]" for=""></label>
          <input placeholder="再次輸入密碼"
            class="placeholder-light-gary w-full h-[48px] font-normal xl:text-[18px] sm:text-[18px] text-[12px] rounded-md bg-white"
            required type="text" name="" id="">
        </div>
        <button type="submit" class="w-full h-[48px] bg-blue-green rounded-lg font-normal text-[24px] text-main-white"
          @click="submit()">確定</button>
      </div>
    </form>
  </div>
  <Footer></Footer>
</template>

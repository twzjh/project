<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    Navbar,
    Footer,
    Head,
  },
  props: {
    errors: Object,
  },
  data() {
    return {
      formData: {
        name: '',
        tel: '',
        email: '',
        main: '',
        content: '',
      },
    };
  },
  methods: {
    submitForm() {
      Swal.fire({
        title: '是否確定送出?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[360px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-blue-green text-white order-2',
          cancelButton: 'swal-btn bg-white',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // 發送請求
          this.$inertia.post('/add-connection', this.formData, {
            preserveScroll: true,
            onSuccess: (res) => {
              const msg = res.props.flash.message;
              Swal.fire(msg);
              for (let key in this.formData) {
                this.formData[key] = '';
              }
            },
            onError: () => {
              if (this.errors.name) {
                this.$refs.nameinput.focus();
              } else if (this.errors.tel) {
                this.$refs.telinput.focus();
              } else if (this.errors.email) {
                this.$refs.emailinput.focus();
              } else if (this.errors.main) {
                this.$refs.maininput.focus();
              } this.$refs.contentinput.focus();
            },
          });
        }
      });
    },
  },
};
</script>

<style scoped>
body {
  min-height: 100vh;
  flex-direction: column;
  gap: 30px;
}

.inputBox {
  position: relative;
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
  transform: translateX(14px) translateY(-7px) ;
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
</style>

<template>
  <Head title="聯絡我們"></Head>
  <Navbar></Navbar>
  <!-- //標題:聯絡我們 -->
  <div
    class="w-full xl:h-[503px] sm:h-[400px] h-[266px]  bg-black xl:pt-[224px] xl:pb-[120px] sm:pt-[160px] sm:pb-[80px] pt-[120px] pb-[60px] gap-4">
    <div class="w-full xl:h-[100px] sm:h-[83px] h-[54px] flex justify-center gap-2">
      <div
        class="xl:w-[300px] xl:h-[100px] sm:w-[300px] sm:h-[90px] w-[120px] h-[75px] border-b-2 text-center text-main-white">
        <span
          class="font-NotoSerif leading-[91.97px] font-bold xl:text-[64px] sm:text-[52px] text-[29px] tracking-[0.02em] text-main-white">聯絡我們</span>
      </div>
    </div>
    <span
      class="flex justify-center xl:font-bold sm:font-bold font-normal font-JhengHei xl:text-[32px] sm:text-[28px] text-[12px] xl:pt-[10px] sm:pt-[43px] pt-[35px] text-main-white">請如實填寫</span>
  </div>
  <!-- //輸入內容 -->
  <div class="w-full sm:pt-[60px] xl:pb-[120px] pt-[30px] pb-[60px] bg-main-white flex justify-center relative">
    <div class="xl:w-[486px] sm:w-[486px] w-[375px] px-6">
      <form @submit.prevent="submitForm()">
        <span class="font-bold font-JhengHei xl:text-[32px] sm:text-[32px] text-[20px]">個人資料</span>
        <div class="xl:w-full sm:w-full">
          <div class="grid gap-2">
            <label class="" for="name"></label>
            <div class="inputBox inputBox2 w-full">
              <input v-model="formData.name" type="text" id="name" ref="nameinput" required="required">
              <span class="sm:text-[18px] text-[12px]">姓名</span>
              <div v-if="errors.name" class="text-[16px] text-main-red">{{ errors.name }}</div>
            </div>
            <label class="" for="tel"></label>
            <div class="inputBox w-full">
              <input v-model="formData.tel" type="tel" id="tel" ref="telinput" required="required">
              <span class="sm:text-[18px] text-[12px]">手機號碼</span>
              <div v-if="errors.tel" class="text-[16px] text-main-red">{{ errors.tel }}</div>
            </div>
            <label class="" for="email"></label>
            <div class="inputBox w-full">
              <input v-model="formData.email" type="text" id="email" ref="emailinput" required="required">
              <span class="sm:text-[18px] text-[12px]">電子郵件</span>
              <div v-if="errors.email" class="text-[16px] text-main-red">{{ errors.email }}</div>
            </div>
          </div>
        </div>
        <div class="pt-[20px] grid gap-2">
          <span class="font-bold font-JhengHei xl:text-[32px] sm:text-[32px] text-[20px]">主旨</span>
          <div>
            <label class="" for="main"></label>
            <div class="inputBox w-full">
              <input v-model="formData.main" type="text" id="main" ref="maininput" required="required">
              <span class="sm:text-[18px] text-[12px]">主旨(限20字內)</span>
              <div v-if="errors.main" class="text-[16px] text-main-red">{{ errors.main }}</div>
            </div>
          </div>
          <span class="font-bold font-JhengHei xl:text-[32px] sm:text-[32px] text-[20px]">內容</span>
          <div>
            <label class="" for="content"></label>
            <textarea v-model="formData.content"
              class="w-full h-[113px] font-normal text-[18px] rounded placeholder-light-gary bg-white resize-none"
              name="" id="" ref="contentinput" required="required">
              </textarea>
            <div v-if="errors.content" class="text-[16px] text-main-red">{{ errors.content }}</div>
          </div>
        </div>
        <div class="pt-[20px] w-full grid gap-6">
          <span
            class="font-JhengHei font-normal xl:text-[18px] sm:text-[18px] text-[12px] text-dark-gray">謝謝您的詢問，按下送出後，將盡速回覆至您的信箱，請耐心等候。</span>
          <button type="submit"
            class="w-full xl:h-[48px] sm:h-[48px] h-[36px] bg-blue-green rounded-lg font-normal text-[24px] text-main-white">送出</button>
        </div>
      </form>
    </div>
  </div>
  <Footer></Footer>
</template>

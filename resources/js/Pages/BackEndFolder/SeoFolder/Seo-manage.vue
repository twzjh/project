<script>
import BackendNav from '@/Components/BackendNav.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    BackendNav, Head,
  },
  props: {
    seo: Object,
  },
  data() {
    return {
      form: {
        seo_title: this.seo ? this.seo.seo_title : '',
        seo_keyword: this.seo ? this.seo.seo_keyword : '',
        seo_description: this.seo ? this.seo.seo_description : '',
      },
    };
  },
  methods: {
    goback() {
      this.$inertia.get(route('payment.index'));
    },
    addSeo() {
      if (this.form.seo_title === '' || this.form.seo_keyword === '' || this.form.seo_description === '') {
        Swal.fire({
          title: '請輸入完整資料',
          showConfirmButton: false,
          icon: 'error',
          timer: 1500,
        });
      } else {
        Swal.fire({
          title: '確定要儲存嗎?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '確定',
          cancelButtonText: '取消',
        }).then((result) => {
          if (result.isConfirmed) {
            this.$inertia.post(route('seo.store'), this.form, {
              onSuccess: (res) => {
                const msg = res.props.flash.message;
                Swal.fire(msg);
              },
            });
          }
        });
      }
    },
  },
};
</script>

<template>
  <Head title="後臺Seo管理"></Head>
  <BackendNav>
    <template v-slot:title>
      <header class="w-[100%] font-bold text-[24px] pt-3 pl-10">SEO管理</header>
      <div class="w-full h-4 shadow-xl"></div>
    </template>
    <template v-slot:content>
      <main class="w-[100%] h-[800px] flex flex-wrap justify-center items-center">
        <form @submit.prevent="saveData">
          <div class="box-1 w-[1440px] h-[188px] border-2  mb-4 rounded">
            <div class="w-[100%] h-[48px] bg-dark-gray text-white font-bold text-[24px]  text-center pt-1">Page tittle
            </div>
            <div class="flex justify-center items-center pt-4">
              <label for="pagetitle"></label>
              <textarea id="pagetitle" v-model="form.seo_title"
                class="w-[1416px] h-[106px] border border-dark-gray text-[24px] pl-4 pt-4"></textarea>
            </div>
          </div>
          <div class="box-2 w-[1440px] h-[408px] border-2  rounded flex">
            <div class="w-[50%] h-[408px] border-r ">
              <div class="w-[100%] h-[48px] bg-dark-gray text-white font-bold text-[24px]  text-center pt-1">Keywords
              </div>
              <div class="flex justify-center items-center pt-2.5">
                <label for="Keyword"></label>
                <textarea id="Keyword" v-model="form.seo_keyword"
                  class="w-[696px] h-[336px] border border-dark-gray text-[24px] p-4 "></textarea>
              </div>
            </div>
            <div class="w-[50%] h-[408px] border-l">
              <div class="w-[100%] h-[48px] bg-dark-gray text-white font-bold text-[24px]  text-center pt-1">Description
              </div>
              <div class="flex justify-center items-center pt-2.5 ">
                <label for="Description"></label>
                <textarea v-model="form.seo_description" id="Description"
                  class="w-[696px] h-[336px] border border-dark-gray text-[24px] p-4 ">
                </textarea>
              </div>
            </div>
          </div>
        </form>
        <div>
          <button type="button"
            class="w-[120px] h-[40px] font-JhengHei border border-rose-500 text-rose-500 rounded mr-4" @click="goback">
            取消
          </button>
          <button type="button" @click="addSeo"
            class="w-[120px] h-[40px] font-JhengHei text-white bg-blue-green rounded">
            儲存
          </button>
        </div>
      </main>
    </template>
  </BackendNav>

</template>

<style scoped>
textarea {
  resize: none;
}
</style>

<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import MemberNavbar from '@/Components/MemberNavbar.vue';
import Input from '@/Components/Input.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    UpdatePasswordForm, Input, MemberNavbar, Navbar, Footer, Head,
  },
  props: {
    mustVerifyEmail: Boolean,
    status: String,
    userData: Object,
    errors: Object,
  },
  data() {
    return {
      page: 1,
      formData: {
        id: this.userData.id,
        name: this.userData.name,
        phone: this.userData.member.member_phone,
        birthday: this.userData.member.member_birthday,
        birthTime: this.userData.member.member_birth_time,
        birthCity: this.userData.member.member_city,
        address: this.userData.member.member_address,
        email: this.userData.email,
      },
    };
  },
  methods: {
    updateProfile() {
      Swal.fire({
        title: '是否確定修改?',
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonText: '確定',
        buttonsStyling: false,
        customClass: {
          popup: 'w-[300px]',
          title: 'font-JhengHei text-black border-0 pt-[20px]',
          confirmButton: 'swal-btn bg-blue-green text-white order-2',
          cancelButton: 'swal-btn bg-white',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post('member/profileEdit', this.formData,
            {
              onSuccess: (res) => {
                const msg = res.props.flash.message;
                Swal.fire({
                  title: `資料更新${msg}`,
                  buttonsStyling: false,
                  customClass: {
                    popup: 'w-[300px]',
                    title: 'font-JhengHei text-black border-0 pt-[20px]',
                    actions: 'w-[40%] mt-2',
                    confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
                  },
                });
              },
            });
        }
      });
    },
  },
};
</script>

<template>
  <Head title="個人資料"></Head>
  <Navbar />
  <MemberNavbar :nowpage="1" />
  <main class="flex flex-col items-center w-full mt-[30px] sm:mt-[60px] mb-[60px] sm:mb-[80px] xl:mb-[120px]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <!-- 會員資料表單 -->
      <form class="p-6 px-8 sm:min-w-[468px] shadow-cardShadow flex flex-col gap-y-6 xl:gap-y-4 mb-6 w-11/12 sm:w-7/12 xl:w-[468px] m-auto"
        @submit.prevent="updateProfile()"
      >
        <h3>個人資料</h3>
        <span class="text-dark-gray mb-1">{{ formData.email }}</span>
        <Input
          title='姓名' type="text" name="name"
          :value-data="formData.name"
          @update="(value) => formData.name = value"
        />
        <Input
          title='手機號碼' type="tel" name="tel"
          :value-data="formData.phone"
          @update="(value) => formData.phone = value"
        />
        <div class="flex gap-x-[20px] flex-wrap gap-y-6 sm:flex-nowrap sm:gap-y-0">
          <Input
            title='出生日期' type="date" name="birthday"
            :value-data="formData.birthday"
            @update="(value) => formData.birthday = value"
          />
          <Input
            title='出生時間' type="time" name="birthTime"
            :value-data="formData.birthTime"
            @update="(value) => formData.birthTime = value"
          />
        </div>
        <Input
          title='出生城市' type="text" name="city"
          :value-data="formData.birthCity"
          @update="(value) => formData.birthCity = value"
        />
        <Input
          title='地址' type="text" name="address"
          :value-data="formData.address"
          @update="(value) => formData.address = value"
        />
        <button type="submit" class="w-full bg-blue-green text-white text-[16px] sm:text-[24px] py-2 font-JhengHei rounded-md hover:bg-blue-green/95">儲存</button>
      </form>

      <!-- 修改密碼表單 -->
      <UpdatePasswordForm class="max-w-xl" :errors="errors"></UpdatePasswordForm>

    </div>
  </main>
  <Footer />
</template>

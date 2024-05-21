<script>
import Cart from '/images/FrontEndIcon/white-cart.png';
export default {
  props: {
    serviceData: Object,
    boughtService: Array ?? [],
  },
  data() {
    return {
      cart: Cart,
      cartForm: {},
    };
  },
  // 添加開關key
  mounted() {
    this.serviceData.forEach(service => {
      service.open = false;
    });
  },
  methods: {
    toggleCard(service) {
      service.open = !service.open;
    },
    addCart(id) {
      // 買過的課程不能買
      if (this.boughtService.includes(id)) {
        return;
      }
      this.cartForm.id = id;
      this.cartForm.type = 1;
      this.$inertia.post('/addCart', this.cartForm,
        {
          preserveState: false,
          preserveScroll: true,
          onSuccess: (res) => {
            const msg = res.props.flash.message;
            Swal.fire({
              title: msg,
              buttonsStyling: false,
              customClass: {
                popup: 'w-[330px]',
                title: 'font-JhengHei text-black border-0 pt-[20px] pb-4',
                actions: 'w-[40%] mt-2',
                confirmButton: 'swal-btn bg-blue-green text-white order-2 w-full',
              },
            });
          },
        });
    },
  },
};
</script>

<template>
  <!-- 第二頁上面可以開闔的長卡條 -->
  <div class="service-card" @click="toggleCard(service)" :class="{ 'bg-light-light-gary': service.open, 'close': !service.open }" v-for="service in serviceData" :key="service.id">
    <div class="toggle min-w-[20px] h-[20px] relative">
      <span class="bg-lake-green w-[20px] h-[4px] absolute"></span>
      <span class="bg-lake-green w-[20px] h-[4px] absolute transition-transform ease-in-out duration-300 " :class="{ 'rotate-90': !service.open }"></span>
    </div>

    <div class="font-bold ml-6 w-4/6 sm:w-auto">
      <h3 class="title">{{ service.service_name }}</h3>
      <span class="price text-blue-green">NT${{ service.service_price.toLocaleString() }}</span>
    </div>
    <div class="px-3 py-3 sm:px-6 sm:py-2 rounded-full ml-auto text-white flex sm:w-auto canBuy"
      @click="addCart(service.id)" :class="{ 'bought': boughtService?.includes(service.id) }"
    >
      <img :src="cart" class="w-[16px] sm:w-[24px] mr-0 cart:mr-2 h-full">
      <span class="text-[18px] hidden cart:flex select-none">加入購物車</span>
    </div>
    <p class="border-t border-black w-full mt-4 py-2 text-[16px] sm:text-[24px] leading-7 sm:leading-10" v-show="service.open">
      {{ service.service_introduce }}
    </p>
  </div>
</template>

<style scoped>
.close {
  height: 110px;
  transition: height 0.3s ease-in-out;
  overflow: hidden;
}
.title {
  @apply text-[20px] sm:text-[28px] xl:text-[32px]
}
.price {
  @apply text-[16px] sm:text-[24px]
}
.service-card{
  @apply flex shadow-cardShadow p-[16px] my-2 sm:my-[12px] items-center flex-wrap transition-all ease-in-out duration-300 w-full xl:w-8/12 font-JhengHei cursor-pointer
}
.canBuy{
  @apply bg-blue-green hover:bg-lake-green cursor-pointer
}
.bought{
  @apply bg-light-gary hover:bg-light-gary cursor-default
}
</style>

<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';

export default {
  components: {
    Navbar, Footer, Head,
  },
};
</script>

<template>
  <Head title="付款與退款政策"></Head>
  <Navbar />
  <header class="header">
    <h2>付款與退款政策</h2>
  </header>
  <main class="flex flex-col items-center w-full">
    <section class="flex flex-col items-start w-11/12 xl:w-7/12 mb-[60px] sm:mb-[80px] xl:mb-[120px] mt-[30px] sm:mt-[60px]">
      <h3 class="font-bold text-blue-green title mb-[30px] ">付款政策：</h3>
      <ol>
        <li>所有課程及服務費用均以新台幣計算。</li>
        <li>最終售價將以下單時的顯示為準。</li>
        <li>我們接受匯款、線上轉帳的方式付款，會在下單後提供您匯款帳戶。</li>
        <li>下單課程並匯款之後，我們會在24小時內核對訂單和款項，確認無誤後會開啟權限。若金額有誤或其他狀況，會寄Email聯繫。若24小時後，課程權限未開啟也未收到我們的Email，請聯繫我們，謝謝。</li>
        <li>下單服務後，我們會在24小時內聯繫您，並和您確認服務細節和費用，確認收到款項後才算是完成預約。</li>
        <li>對有關銀行於處理交易時所發生的故障而導致之損失，本網站將不承擔任何責任。</li>
      </ol>
      <h3 class="font-bold text-blue-green title mb-[30px] mt-6">退款政策：</h3>
      <ol>
        <li>實體或線上直播課程，於開課日前申請退款，將全額退還該課程您所支付之金額；開課日後，則不接受退款申請，該課程您所支付之金額將不予退還。</li>
        <li>錄影課程、商品和服務恕無法辦理退款。</li>
        <li>我們將以轉帳方式進行退款，請提供正確的匯款帳號，以利完成退款手續。款項將會在7個工作天內退還至您提供的帳戶。</li>
      </ol>
    </section>
  </main>
  <Footer />
</template>

<style scoped>
.header{
  @apply bg-black w-full flex flex-col justify-center items-center pt-[120px] sm:pt-[160px] xl:pt-[224px]
}
h2{
  @apply font-NotoSerif text-white text-[32px] sm:text-[52px] xl:text-[64px] font-bold tracking-wider border-b-2 p-0 pb-2 mb-[60px] sm:mb-[80px] xl:mb-[120px]
}
.title{
@apply text-[20px] sm:text-[28px] xl:text-[32px]
}
ol{
  list-style: decimal;
  @apply text-[16px] sm:text-[24px] font-JhengHei flex flex-col sm:gap-y-[10px]
}
li{
  @apply leading-10 ml-[30px] tracking-wide
}
</style>

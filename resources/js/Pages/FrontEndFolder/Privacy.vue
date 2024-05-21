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
  <Head title="隱私權政策"></Head>
  <Navbar />
  <header class="header">
    <h2>隱私權政策</h2>
  </header>
  <main class="flex flex-col items-center w-full">
    <section class="flex flex-col items-start w-11/12 xl:w-7/12 mb-[60px] sm:mb-[80px] xl:mb-[120px] mt-[30px] sm:mt-[60px]">
      <h3 class="font-bold text-blue-green title mb-[30px] ">隱私權政策：</h3>
      <ol>
        <li>隱私政策內容，包括本網站如何處理在您使用網站服務時收集到的個人識別資料。</li>
        <li>當您造訪本網站或使用本網站所提供之功能服務時，將請您提供必要的個人資料，並在該特定目的範圍內處理及利用您的個人資料；非經您同意，本網站不會將個人資料用於其他用途。</li>
        <li>本網站在您使用服務信箱、問卷調查等互動性功能時，會保留您所提供之姓名、電子郵件、聯絡方式等。</li>
        <li>為提供精確的服務，我們會將收集的問卷調查內容進行統計與分析，分析結果之統計數據或說明文字呈現，除供內部研究外，我們會視需要公佈統計數據及說明文字，但不涉及特定個人之資料。</li>
        <li>您可以隨時向我們提出請求，以更正或刪除您的帳戶或本網站所蒐集的個人資料等隱私資訊。</li>
        <li>本網站絕不會提供、交換、出租或出售任何您的個人資料給其他個人、團體、私人企業或公務機關，但有法律依據或合約義務者，不在此限。</li>
        <li>本網站隱私權保護政策將因應需求隨時進行修正，修正後的條款將刊登於網站上。</li>
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
  @apply text-[16px] sm:text-[24px] font-JhengHei flex flex-col gap-y-[20px] sm:gap-y-[40px]
}
li{
  @apply leading-10 ml-[30px] tracking-wide
}
</style>

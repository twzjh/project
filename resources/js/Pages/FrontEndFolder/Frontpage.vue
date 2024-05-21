<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import GoTop from '@/Components/GoTop.vue';
import oneBg from '/images/pixta_5.jpg';
import twoBg from '/images/astrology.png';
import hotBg1 from '/images/pixta_3.jpg';
import hotBg2 from '/images/pixta_2.jpg';
import aboutBg from '/images/pixta.jpg';
import historyBg from '/images/pixta_4.jpg';
import { Link, router } from '@inertiajs/vue3';

export default {
  components: {
    Navbar,
    Footer,
    GoTop,
    Link,
  },
  props: {
    coursesData: Object,
    chapterCount: Object,
    courseMain: Object,
  },
  data() {
    return {
      oneBg,
      twoBg,
      hotBg1,
      hotBg2,
      aboutBg,
      historyBg,
      changeBg: 'bg-class-img',
      activeTab: '',
    };
  },
  computed: {
    // 換前後頁碼
    pagination() {
      const pagination = this.coursesData.links.map(page => {
        page.label = page.label.replace('&laquo; Previous', '&lsaquo;').replace('Next &raquo;', '&rsaquo;');
        return page;
      });
      return pagination;
    },
  },
  mounted() {
    this.activeTab = 1;
    this.changeBg = 'bg-class-img';
  },
  methods: {
    // 頁籤切換時,背景圖片更改
    changepic(tab, bgClass) {
      if (this.activeTab !== tab) {
        this.activeTab = tab;
      }
      if (this.activeTab === tab) {
        this.changeBg = bgClass;
      }
      this.$inertia.get(route('frontpage'), { 'tab': tab }, {
        preserveState: true,
        preserveScroll: true,
      });
    },
    // 主打課程
    courseType(type) {
      switch (type) {
      case 1:
        return '占星';
      case 2:
        return '中醫';
      case 3:
        return '魔法';
      case 4:
        return '其他';
      }
    },
    // 點擊主打課程跳轉到指定課程
    goPage(id) {
      this.$inertia.get('/coursecontent', { 'courseId': id });
    },
    // 開立課程分頁器點選
    paginationPgae(url) {
      router.visit(url, {
        method: 'get',
        data: {},
        preserveState: true,
        preserveScroll: true,
      });
    },
  },
};
</script>

<template>
  <Navbar />
  <div class="bg-front-background">
    <!-- 背景圖片 -->
    <div class="relative">
      <img class="bg" :src="oneBg" alt="背景圖片">
      <div class="absolute inset-0 bg-black opacity-20"></div>
    </div>
    <!-- 主打課程 -->
    <div class="w-full flex justify-center">
      <div class="px-10 w-11/12 max-xl:px-[5%] my-[120px] max-xl:my-[80px] max-sm:my-[60px]">
        <div class="flex justify-center mb-20 max-xl:mb-10 max-sm:mb-6">
          <div class="title relative">主打課程</div>
        </div>
        <div class="flex gap-x-[20px] justify-center items-center max-xl:flex-col max-xl:gap-y-10 max-sm:gap-y-4">
          <Link href="/coursecontent" class="flex flex-col max-w-[640px] min-w-[300px] w-[50%] max-xl:w-full" v-for="course in courseMain" :key="course.id" @click="goPage(course.id)">
            <div class="relative">
              <img class="object-cover aspect-video max-h-[360px]" :src="course.course_image" alt="主打課程">
              <div class="absolute inset-0 bg-black opacity-20"></div>
            </div>
            <div class="hottitle">{{ course.course_name }}</div>
            <div class="flex gap-2 items-center">
              <span
                class="text-white bg-main-red text-[18px] py-2 px-4 rounded-full font-JhengHei max-sm:text-[12px]" :class="courseType(course.course_type)">
                {{ courseType(course.course_type) }}
              </span>
              <span class="hottext">NT${{ course.course_price.toLocaleString() }}</span>
            </div>
          </Link>
        </div>
      </div>
    </div>
    <!-- 開立課程 -->
    <div class="w-full py-[120px] px-[10.5%] bg-main-black bg-no-repeat max-xl:flex-col max-xl:py-[80px] max-xl:px-[5%]" :class="changeBg">
      <div class="w-full flex justify-between max-xl:flex-col">
        <div class="flex justify-center max-xl:flex-col max-xl:items-center max-xl:w-full">
          <div class="max-xl:mb-10">
            <div class="text-[64px] font-bold text-white font-NotoSerif break-keep max-xl:text-[52px]">開立課程</div>
            <div class="border-b-2 border-white w-[92%] pt-2 max-xl:m-auto"></div>
            <div class="pt-4 max-xl:pt-2 max-xl:flex max-xl:justify-center">
              <button type="button"
                class="text-[24px] text-main-white font-normal font-JhengHei rounded-md bg-blue-green px-[24px] py-[8px] hover:bg-lake-green">
                <Link href="/services">了解更多</Link>
              </button>
            </div>
          </div>
        </div>
        <div class="w-[68%] max-xl:w-full max-xl:pt-10 max-sm:px-0">
          <div class="flex max-sm:overflow-x-auto">
            <button type="button" class="classlist" :class="{ 'focus': activeTab === 1 }" @click="changepic(1, 'bg-class-img')">吠陀占星</button>
            <button type="button" class="classlist" :class="{ 'focus': activeTab === 2 }" @click="changepic(2, 'bg-class2-img')">中醫</button>
            <button type="button" class="classlist" :class="{ 'focus': activeTab === 3 }" @click="changepic(3, 'bg-class-img')">古典魔法</button>
            <button type="button" class="classlist" :class="{ 'focus': activeTab === 4 }" @click="changepic(4, 'bg-class3-img')">其它術數</button>
          </div>
          <div class="h-[487px] max-sm:h-[750px] my-6">
            <div
              class="flex abc border-t border-dashed py-4 max-sm:flex-col justify-between max-xl:gap-x-8 max-sm:gap-y-2"
              v-for="tab in coursesData.data" :key="tab.id">
              <div
                class="text-[32px] font-JhengHei font-bold text-main-white col-span-3 max-xl:text-[28px]  max-sm:text-[20px] truncate">
                {{ tab.course_name }}
              </div>
              <div class="flex gap-x-10 justify-center items-center max-sm:justify-between max-xl:gap-x-6">
                <div class="rounded-[50px] text-[24px] leading-[32px] font-JhengHei font-bold text-main-white py-[8px] px-[20px] bg-blue-green break-keep max-sm:text-[16px]">
                  {{ tab.chapterCount }}堂課
                </div>
                <div
                  class="text-[24px] max-sm:text-[16px] font-JhengHei font-bold text-light-gary text-right break-keep">
                  {{ tab.course_hour }}小時/堂</div>
                <div class="text-[24px] max-sm:text-[16px] font-JhengHei font-bold text-blue-green text-right">
                  NT${{ tab.course_price.toLocaleString() }}
                </div>
              </div>
            </div>
          </div>
          <!-- 分頁器 -->
          <div class="pagination" v-if="pagination.length >= 4">
            <div v-for="(link, index) in pagination" :key="index">
              <button type="button" v-if="link.url" @click="paginationPgae(link.url)" class="page" :class="{ 'nowpage': link.active }">
                <span v-html="link.label"></span>
              </button>
              <button type="button" v-else @click="paginationPgae(link.url)" class="none">
                <span v-html="link.label"></span>
              </button>
            </div>
          </div>
          <div v-else class="h-[35px]"></div>
        </div>
      </div>
    </div>
    <!-- 關於站主 -->
    <div class="w-full flex justify-center">
      <div
        class="w-[80%] max-xl:w-[95%] mt-[113px] max-xl:mt-20 max-sm:my-[60px]">
        <div class="empty" id="about"></div>
        <div class="flex justify-center">
          <div class="title relative">關於站主</div>
        </div>
        <div class="flex mt-20 gap-x-[42px] max-xl:flex-col max-xl:items-center max-xl:mt-10 max-sm:mt-[24px]">
          <div class="about leading-10 text-justify w-full max-xl:mb-10">
            <p>
              文老師自學生時期便開始學習五術，致力於五術教學十餘年。中醫醫術－針灸傳承自古法針灸、董氏奇穴和山西派鍼法；脈學傳承自萬氏的太素脈學；內科傳承各家如經方、溫病、伏氣學派等多位老師；祝由傳承自西河派和軒轅派。
            </p>
            <br>
            <p>
              命學目前以吠陀占星Jyotish為主，師從Komilla、Joni patry、Marc Boney
              等國際大家還有十數位印度吠陀占星大師；風水承襲自蔣氏三元玄空風水、吠陀Vastu和龍門八局，亦通道家奇門遁甲、大六壬、太乙神數三式之學、梅花易數，以及是為熊氏太極拳傳人及華佗門第八十代傳人。
            </p>
            <br>
            <p>
              另外西方之學尚有西洋古典行星護符魔法、北歐魔法等皆是師從大家。
            </p>
          </div>
          <div class="relative">
            <img class="object-cover" :src="aboutBg" alt="關於站主">
            <div class="absolute inset-0 bg-black opacity-20"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- 創立沿革 -->
    <div class="flex my-[120px] max-xl:hidden">
      <div class="w-[53.5%] h-[760px] relative">
        <img class="object-cover h-full" :src="historyBg" alt="創立沿革">
        <div class="absolute inset-0 bg-black opacity-20"></div>
      </div>
      <div class="w-[46.5%]">
        <div class="w-[500px] mb-[70px]">
          <div class="history_title ml-[60px]">學會創立沿革</div>
          <div class="w-[382px] ml-[60px] border-b-2 border-black"></div>
        </div>
        <div class="bg-light-light-gary px-[60px]">
          <div class="max-w-[628px] pt-20 pb-5 text-[22px] font-normal leading-10">
            <span class="text-[40px] font-normal">2008</span>
            年，當時文老師在內湖高中任教，部分同事和學生知曉文老師傳承自古老的醫術，便欲向其學習，但老師當時並未想開課授徒，一方面是其老師們尚在世，二方面是覺得自己尚未成熟，故以五術研究社這種讀書會模式帶領眾人學習，不收學費為眾人解惑。
            <br>
            <br>
            直到2014在湖南攻讀中醫內科學研究所，同儕紛紛希望向文老師學習師承，加上傳授針灸和內科給文老師的老師們都過世了，文老師才開始決定開課陸續至今。
          </div>
        </div>
      </div>
    </div>
    <!-- 創立沿革寬度為1270px以下時出現 -->
    <div class="w-full flex justify-center max-xl:block hidden">
      <div class="my-20 max-sm:my-0">
        <div class="flex justify-center">
          <div class="history_title1 relative">學會創立沿革</div>
        </div>
        <div class="flex-col items-center px-6 max-sm:p-4">
          <div class="relative my-10 max-sm:my-4">
            <img class="object-cover object-top" :src="historyBg" alt="創立沿革">
            <div class="absolute inset-0 bg-black opacity-20"></div>
          </div>
          <div class="bg-light-light-gary  text-justify p-6 max-sm:bg-transparent max-sm:p-0">
            <span class="text-[24px] font-normal max-sm:text-[16px]">
              2008
            </span>
            <span class="text-[24px] font-normal leading-10 max-sm:text-[16px]">
              年，當時文老師在內湖高中任教，部分同事和學生知曉文老師傳承自古老的醫術，便欲向其學習，但老師當時並未想開課授徒，一方面是其老師們尚在世，二方面是覺得自己尚未成熟，故以五術研究社這種讀書會模式帶領眾人學習，不收學費為眾人解惑。
              <br>
              <br>
              直到2014在湖南攻讀中醫內科學研究所，同儕紛紛希望向文老師學習師承，加上傳授針灸和內科給文老師的老師們都過世了，文老師才開始決定開課陸續至今。
            </span>
          </div>
        </div>
      </div>
    </div>
    <Footer />
    <GoTop />
  </div>
</template>

<style scoped>
.bg {
  @apply w-[1903px] h-[920px] object-center object-cover;
}

.title {
  @apply text-[64px] font-bold font-NotoSerif h-[100px];
}

.hottitle {
  @apply text-[48px] font-bold font-NotoSerif;
}

.hottext {
  @apply text-[32px] font-bold font-JhengHei;
}

.about_title {
  @apply text-[64px] font-bold font-NotoSerif;
}

.about {
  @apply text-[24px] font-normal font-JhengHei;
}

.history_title {
  @apply text-[64px] font-bold font-NotoSerif;
}

.classlist {
  @apply text-light-gary font-JhengHei text-[32px] border-b border-light-gary font-bold px-[24px] py-[8px] h-[65px] min-w-[112px] break-keep;
}

.classlist:hover {
  @apply text-lake-green border-lake-green border-b-2;
}

.classlist.focus {
  @apply text-lake-green border-lake-green border-b-2;
}

.abc:last-child {
  @apply border-b border-dashed;
}
.grid-container {
  display: grid;
  grid-template-columns: 4fr 1fr 1fr 1fr;
}
.empty {
  display: block;
  height: 100px;
  margin-top: -100px;
  visibility: hidden;
}

/* 寬度為1270px以下 */
@media screen and (max-width: 1269px) {
  .bg {
    @apply h-[800px];
  }

  .title {
    @apply text-[52px] h-[83px];
  }

  .history_title {
    @apply text-[52px] h-[83px];
  }

  .history_title1 {
    @apply text-[52px] font-bold font-NotoSerif;
  }

  .hottitle {
    @apply text-[42px];
  }

  .hottext {
    @apply text-[28px];
  }

  .classlist {
    @apply text-light-gary font-JhengHei text-[28px] font-bold px-[24px] py-[8px];
  }

  .pagination{
    @apply justify-center;
  }
  .empty {
  height: 80px;
  margin-top: -80px;
  }
}

/* 寬度為600px以下 */
@media screen and (max-width: 599px) {
  .bg {
    @apply h-[524px];
  }

  .title {
    @apply text-[32px] h-[54px];
  }

  .hottitle {
    @apply text-[24px];
  }

  .history_title1 {
    @apply text-[32px];
  }

  .hottext {
    @apply text-[20px];
  }

  .about {
    @apply text-[16px];
  }

  .classlist {
    @apply text-light-gary font-JhengHei text-[20px] font-bold px-[16px] py-[8px];
  }
  .empty {
  height: 60px;
  margin-top: -60px;
  }
}

.title::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 4%;
  width: 92%;
  height: 2px;
  background-color: black;
}
.history_title1::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 20%;
  width: 60%;
  height: 2px;
  background-color: black;
}
.pagination{
  @apply flex text-dark-gray select-none gap-x-1 text-[18px];
}
.page{
  @apply px-[10px] py-1 cursor-pointer;
}
.none{
  @apply px-[10px] py-1 select-none text-light-gary cursor-default;
}
.nowpage{
  @apply bg-blue-green text-white rounded;
}

</style>

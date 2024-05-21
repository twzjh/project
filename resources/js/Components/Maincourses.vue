<script>
import Lock from '/images/FrontEndIcon/lock.png';
import Play from '/images/FrontEndIcon/white-play.png';
import addvideo from '@/Components/video.vue';

export default {
  components: {
    addvideo,
  },
  props: {
    coursedata: Object,
    chapterdata: Object,
  },
  data() {
    return {
      open: false,
      Lock,
      Play,
      jumpAdd: 0,
      hasPermission: this.chapterdata[0]?.permission,
    };
  },
  methods: {
    toggleCard(chapter) {
      chapter.open = !chapter.open;
    },
    toggleAddVideo() {
      if (this.jumpAdd === 0) {
        this.jumpAdd = 1;
      } else {
        this.jumpAdd = 0;
      }
    },
  },
};
</script>

<template>
  <!-- 第二頁上面可以開闔的長卡條 -->
  <div class="service-card" @click="toggleCard(chapter)"
    :class="{ 'bg-light-light-gary': chapter.open, 'close': !chapter.open }" v-for="chapter in coursedata.chapter"
    :key="chapter.id">
    <div class="toggle min-w-[20px] h-[6px] relative">
      <span class="bg-lake-green w-[20px] h-[4px] absolute"></span>
      <span class="bg-lake-green w-[20px] h-[4px] absolute transition-transform ease-in-out duration-300 "
        :class="{ 'rotate-90': !chapter.open }"></span>
    </div>

    <div class="font-bold ml-6 w-4/6 sm:w-auto">
      <h3 class="title">{{ chapter.chapter_name }}</h3>
    </div>
    <div v-if="hasPermission === 2" class="px-4 py-1 z-[5] sm:px-6 sm:py-2 rounded-full ml-auto flex sm:w-auto bg-blue-green text-white" @click="toggleAddVideo">
      <img :src="Play" class="w-[16px] sm:w-[24px] mr-0 cart:mr-2 h-max">
      <button type="button" class="text-[12px] sm:text-[18px]">課程影片</button>
    </div>
    <div v-else class="px-4 py-1 z-[5] sm:px-6 sm:py-2 rounded-full ml-auto flex sm:w-auto bg-dark-gray text-white">
      <img :src="Lock" class="w-[16px] sm:w-[24px] mr-0 cart:mr-2 h-max">
      <button type="button" class="text-[12px] sm:text-[18px]">課程影片</button>
    </div>
    <p class="border-t border-black w-full mt-4 py-2 text-[16px] sm:text-[24px] leading-7 sm:leading-10"
      v-show="chapter.open">{{ chapter.chapter_introduce }}</p>
  </div>
  <div v-if="jumpAdd === 1" class="absolute top-0 left-0 z-50">
    <div class="bg-black h-[100%] w-[100%] bg-opacity-50 fixed">
      <div
        class="bg-red-500 text-white w-[35px] px-3 py-1 text-center rounded absolute top-[10%] right-[6%] border border-gray-500" @click="jumpAdd = 0">X</div>
      <div class="absolute top-[14%] left-[50%] translate-x-[-50%]  rounded" v-for="chapter in coursedata.chapter" :key="chapter.id">
        <addvideo :video="chapter.chapter_video"></addvideo>
      </div>
    </div>
  </div>
</template>

<style scoped>
.close {
  height: 110px;
  transition: height 0.3s ease-in-out;
  overflow: hidden;
}

.title {
  @apply text-[16px] sm:text-[24px]
}

.service-card {
  @apply flex shadow-cardShadow p-[16px] my-2 sm:my-[12px] items-center flex-wrap transition-all ease-in-out duration-300 w-full font-JhengHei cursor-pointer
}
</style>

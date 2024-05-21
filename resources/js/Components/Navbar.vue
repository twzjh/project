<script>
import Logo from '/images/FrontEndIcon/Logo.png';
import blkSearch from '/images/FrontEndIcon/blk-search.png';
import blueSearch from '/images/FrontEndIcon/blue-search.png';
import blkCart from '/images/FrontEndIcon/blk-cart.png';
import blueCart from '/images/FrontEndIcon/blue-cart.png';
import blkUser from '/images/FrontEndIcon/blk-user.png';
import blueUser from '/images/FrontEndIcon/blue-user.png';
import blkhum from '/images/FrontEndIcon/hamburger.png';
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link,
  },
  data() {
    return {
      Logo,
      blkhum,
      blkSearch,
      blkCart,
      blueCart,
      blkUser,
      blueUser,
      blueSearch,
      isHoversearch: false,
      isHovercart: false,
      isHoveruser: false,
      showSearch: false,
      isSidebarOpen: false,
      keyword: '',
      userName: '',
      identify: null,
      count: 0,
    };
  },
  mounted() {
    // 登入時，登入註冊時改變會員中心
    this.identify = this.$page.props.auth.user?.identify;
    if (this.$page.props.auth.user && this.identify === 2) {
      this.userName = '會員中心';
    } else if (this.$page.props.auth.user && this.identify === 1) {
      this.userName = '後台管理';
    }
    // 購物車數量
    this.count = this.$page.props.cart.count ?? 0;
  },
  methods: {
    // 搜尋欄打開關閉
    toggleSearch() {
      this.showSearch = !this.showSearch;
    },
    // 打開漢堡條時,捲動軸hidden
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
      document.documentElement.style.overflow = this.isSidebarOpen ? 'hidden' : 'auto';
    },
    // 點擊漢堡條內容後,捲動軸auto
    closeSidebar() {
      this.isSidebarOpen = false;
      document.documentElement.style.overflow = 'auto';
    },
    // 搜尋關鍵字
    keywordSearch() {
      this.$inertia.get('/search', { keyword: this.keyword });
    },
  },
};
</script>

<template>
  <div class="fixed pt-[24px] z-10 w-full flex justify-center xl">
    <nav
      class="h-[80px] flex justify-around text-center rounded-full bg-main-white bg-opacity-75 backdrop-blur-[2px] w-[94%] xl1 sm1 relative shadow-[0_0_4px_0_rgba(0,0,0,0.25)]">
      <Link href="/" class="flex items-center justify-center title gap-[8px] titleCxl">
        <img :src="Logo" alt="logo" class="min-w-10 mr-1">
        <a class="sm">五術研究社</a>
      </Link>
      <div class="flex items-center justify-center gap-[24px] titleA titleAxl ml-20">
        <Link href="/#about" class="hover:text-lake-green">關於站主</Link>
        <Link href="/services" class="hover:text-lake-green">服務與課程</Link>
      </div>
      <div class="flex items-center justify-center titleB gap-x-6 titleDxl max-xl:gap-x-4">
        <!-- 搜尋框 -->
        <div class="w-[150px] flex justify-end sm">
          <div v-if="showSearch">
            <div class="flex items-center rounded-full border px-2 bg-main-white">
              <img :src="blueSearch" class="w-[24px] h-[24px] cursor-pointer" @click="keywordSearch()">
              <input type="search" placeholder="關鍵字" class="border-none bg-transparent truncate"
                @keyup.enter="keywordSearch()" v-model="keyword">
            </div>
          </div>
          <span v-else @click="toggleSearch" class="cursorpointer " @mouseover="isHoversearch = true"
            @mouseleave="isHoversearch = false">
            <img :src="isHoversearch ? blueSearch : blkSearch" alt="">
          </span>
        </div>
        <!-- 手機板搜尋框 -->
        <div class="w-[159px] justify-end abc hidden">
          <div>
            <div class="flex items-center rounded-full border px-2 bg-main-white">
              <img :src="blueSearch" class="w-[24px] h-[24px] cursor-pointer" @click="keywordSearch()">
              <input type="search" placeholder="關鍵字" class="border-none bg-transparent truncate"
                @keyup.enter="keywordSearch()" v-model="keyword">
            </div>
          </div>
        </div>
        <Link href="/shopping" class="cursorpointer" @mouseover="isHovercart = true"
          @mouseleave="isHovercart = false">
          <img :src="isHovercart ? blueCart : blkCart" alt="購物車" class="min-w-8">
          <span class="cartNum" :class="{ 'bgHover ': isHovercart }" v-if="count >= 1">{{ count }}</span>
        </Link>
        <Link href="/member"
          class="flex justify-between items-center titleC w-[108px] hover:text-lake-green cursorpointer titleAxl"
          @mouseover="isHoveruser = true" @mouseleave="isHoveruser = false">
          <img :src="isHoveruser ? blueUser : blkUser" alt="user">
          <span v-if="!userName">登入註冊</span>
          <span v-else>{{ userName }}</span>
        </Link>
        <div class="hidden max-xl:block">
          <!-- 漢堡條 -->
          <div @click="toggleSidebar" class="hamburger" :class="{ 'open': isSidebarOpen }">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
          </div>
          <div name="sidebar">
            <div v-if="isSidebarOpen" class="sidebar">
              <ul class="text-[24px] font-JhengHei font-normal text-main-black max-sm:text-[16px]">
                <Link href="/#about" @click="closeSidebar">
                  <li class=" hover:bg-dark-gray hover:text-main-white py-3 px-4">關於站主</li>
                </Link>
                <Link href="/services" @click="closeSidebar">
                  <li class=" hover:bg-dark-gray hover:text-main-white py-3 px-4">服務與課程</li>
                </Link>
                <Link href="/member" @click="closeSidebar">
                  <li v-if="!userName" class=" hover:bg-dark-gray hover:text-main-white py-3 px-4">登入註冊</li>
                  <li v-else class=" hover:bg-dark-gray hover:text-main-white py-3 px-4">
                    {{ userName }}
                  </li>
                </Link>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<style scoped>
.title {
  @apply text-[32px] font-bold font-JhengHei;
}

.titleA {
  @apply text-[24px] font-bold font-JhengHei;
}

.titleB {
  @apply text-[18px] font-bold font-JhengHei;
}

.titleC {
  @apply text-[18px] font-normal font-JhengHei;
}

.cursorpointer {
  @apply cursor-pointer;
}

input[type="search"]:focus {
  outline: none !important;
  border: 0;
  box-shadow: none;
}

/* 漢堡條 */
.hamburger {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 32px;
  height: 32px;
  cursor: pointer;
}

/* 漢堡條hover效果 */
.hamburger:hover .line {
  background-color: #518c95;
}

.line {
  width: 100%;
  height: 5px;
  border-radius: 50px;
  background-color: black;
}

.cartNum {
  @apply w-[20px] h-[20px] absolute bg-rose-800 rounded-full text-white flex justify-center items-center text-[12px] top-[20px] translate-x-[17px] xl:translate-x-[20px]
}
.bgHover {
  @apply bg-rose-700
}

.sidebar {
  position: absolute;
  top: 100%;
  left: -1px;
  width: calc(100% + 2px);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
  text-align: left;
}
.sidebar::before {
  content: "";
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: -1;
  display: block;
}

input[type="search"]::-webkit-search-cancel-button{
  -webkit-appearance: none;
  content: url('/resources/images/FrontEndIcon/close.svg');
  cursor: pointer;
  transform: translateX(10px);
  @apply hover:opacity-80
}

.hamburger.open .line:nth-child(1) {
  transform: translateY(12px) rotate(45deg);
}

.hamburger.open .line:nth-child(2) {
  opacity: 0;
}

.hamburger.open .line:nth-child(3) {
  transform: translateY(-9px) rotate(-45deg);
}

/* 寬度為1270以下時 */
@media (max-width:1269px) {
  .xl1 {
    @apply h-[76px] w-full rounded-none justify-between
  }

  .titleAxl {
    @apply hidden
  }

  .titleBxl {
    @apply block
  }

  .xl {
    @apply pt-0
  }

  .titleCxl {
    @apply ml-6 text-[28px]
  }

  .titleDxl {
    @apply mr-10
  }
}

/* 寬度為600以下時 */
@media (max-width:599px) {
  .sm {
    @apply hidden
  }

  .sm1 {
    @apply justify-between h-[60px]
  }

  .titleDxl {
    @apply mr-8
  }
  .abc {
    @apply block
  }
}
</style>

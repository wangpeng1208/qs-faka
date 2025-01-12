<template>
  <div v-if="layout === 'side'" class="header-menu-search">
    <l-breadcrumb v-if="settingStore.showBreadcrumb" />

    <div class="announcement" :class="['header-search', { 'hover-active': isSearchFocus }]">
      <div class="textBox" style="flex: 10">
        <t-swiper direction="vertical" animation="fade" :height="22" autoplay :interval="5000" :navigation="{ showSlideBtn: 'never' }">
          <t-swiper-item v-for="(item, index) in noticeList" :key="index">
            <div class="text" @click="router.push(`/merchant/user/news/detail/${item.id}`)">
              <span style="color: #bbb; padding-right: 10px">
                {{ item.cate_name }}
              </span>
              {{ item.title }}
            </div>
          </t-swiper-item>
        </t-swiper>
      </div>
      <!-- <div style="flex: 2" @click="router.push('/merchant/user/news')">查看全部</div> -->
    </div>
    <!-- <t-input :class="['header-search', { 'hover-active': isSearchFocus }]" placeholder="请输入搜索内容" @blur="changeSearchFocus(false)" @focus="changeSearchFocus(true)">
      <template #prefix-icon>
        <t-icon class="icon" name="search" size="16" />
      </template>
    </t-input> -->
  </div>

  <div v-else class="header-menu-search-left">
    <t-button :class="{ 'search-icon-hide': isSearchFocus }" theme="default" shape="square" variant="text" @click="changeSearchFocus(true)">
      <t-icon name="search" />
    </t-button>
    <t-input v-model="searchData" :class="['header-search', { 'width-zero': !isSearchFocus }]" placeholder="输入要搜索内容" :autofocus="isSearchFocus" @blur="changeSearchFocus(false)">
      <template #prefix-icon>
        <t-icon name="search" size="16" />
      </template>
    </t-input>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { notice } from '@/api/merchant/workbench';
import { useSettingStore } from '@/store';

import LBreadcrumb from '../Breadcrumb.vue';

const settingStore = useSettingStore();
const router = useRouter();
const noticeList = ref([]);
const initNotice = async () => {
  const { data } = await notice();
  noticeList.value = data;
};
initNotice();
defineProps({
  layout: String,
});

const isSearchFocus = ref(false);
const searchData = ref('');
const changeSearchFocus = (value: boolean) => {
  if (!value) {
    searchData.value = '';
  }
  isSearchFocus.value = value;
};
</script>
<style lang="less" scoped>
.header-menu-search {
  display: flex;
  margin-left: 16px;
  .hover-active {
    background: var(--td-bg-color-secondarycontainer);
  }

  .t-icon {
    color: var(--td-text-color-primary) !important;
  }
  .header-search {
    :deep(.t-input) {
      border: none;
      outline: none;
      box-shadow: none;
      transition: background @anim-duration-base linear;
      .t-input__inner {
        transition: background @anim-duration-base linear;
      }
      .t-input__inner {
        background: none;
      }
      &:hover {
        background: var(--td-bg-color-secondarycontainer);
        .t-input__inner {
          background: var(--td-bg-color-secondarycontainer);
        }
      }
    }
  }
}

.t-button {
  margin: 0 8px;
  transition: opacity @anim-duration-base @anim-time-fn-easing;

  .t-icon {
    font-size: 20px;
    &.general {
      margin-right: 16px;
    }
  }
}
.search-icon-hide {
  opacity: 0;
}
.header-menu-search-left {
  display: flex;
  align-items: center;

  .header-search {
    width: 200px;
    transition: width @anim-duration-base @anim-time-fn-easing;
    :deep(.t-input) {
      border: 0;
      &:focus {
        box-shadow: none;
      }
    }
    &.width-zero {
      width: 0;
      opacity: 0;
    }
  }
}

.announcement {
  width: 400px;
  display: flex;
  align-items: center;
  cursor: pointer;
  color: #bbb;

  .text {
    text-decoration: none;
    text-align: left;
    color: #515a6e;
  }
}
:deep(.t-swiper__navigation) {
  display: none;
}
</style>

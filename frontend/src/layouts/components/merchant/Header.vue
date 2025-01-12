<template>
  <div :class="layoutCls">
    <t-head-menu :class="menuCls" :theme="menuTheme" expand-type="popup" :value="active">
      <template #logo>
        <span v-if="showLogo" class="header-logo-container" @click="handleNav('merchantWorkbench')">
          <img :src="siteLogo" alt="" style="width: 184px; height: 26px" />
        </span>
        <div v-else class="header-operate-left">
          <search :layout="layout" />
        </div>
      </template>
      <template v-if="layout !== 'side'" #default>
        <menu-content class="header-menu" :nav-data="menu" />
      </template>
      <template #operations>
        <div class="operations-container">
          <t-dropdown :min-column-width="120" trigger="hover">
            <t-button class="header-user-btn" theme="default" variant="text">
              <template #icon>
                <t-avatar :image="user.avatar" shape="circle" style="width: 30px; height: 30px" />
              </template>

              <div class="header-user-account" style="padding-left: 5px">{{ user.username }}</div>

              <template #suffix><t-icon name="chevron-down" /></template>
            </t-button>

            <template #dropdown>
              <t-dropdown-menu>
                <t-dropdown-item class="operations-dropdown-container-item" @click="handleNav('merchantUserPassword')"> <t-icon name="user-circle"></t-icon>修改密码 </t-dropdown-item>
                <t-dropdown-item class="operations-dropdown-container-item" @click="handleLogout"> <t-icon name="poweroff"></t-icon>退出登录 </t-dropdown-item>
              </t-dropdown-menu>
            </template>
          </t-dropdown>

          <!-- 全局通知 -->
          <header-notice />

          <t-tooltip placement="bottom" content="样式设置">
            <t-button theme="default" shape="square" variant="text" @click="toggleSettingPanel">
              <t-icon name="setting" size="large" />
            </t-button>
          </t-tooltip>
        </div>
      </template>
    </t-head-menu>

    <!-- <global-sticky /> -->
  </div>
</template>
<script lang="ts">
export default {
  name: 'LHeader',
};
</script>
<script setup lang="ts">
import type { PropType } from 'vue';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

import { prefix } from '@/config/global';
import { getActive } from '@/router';
import { useSettingStore, useSiteStore, useUserStore } from '@/store';
import type { MenuRoute } from '@/types/interface';

import MenuContent from '../MenuContent.vue';
import HeaderNotice from './Notice.vue';
import Search from './Search.vue';

const router = useRouter();
// 加载用户资料及权限
const useStore = useUserStore();
const init = () => {
  useStore.getUserInfo();
};
init();

const siteStore = useSiteStore();
const siteLogo = computed(() => siteStore.config.site_logo);

// 用户信息和店铺信息
const user = computed(() => useStore.userInfo);

const props = defineProps({
  theme: {
    type: String,
    default: 'light',
  },
  layout: {
    type: String,
    default: 'top',
  },
  showLogo: {
    type: Boolean,
    default: true,
  },
  menu: {
    type: Array as PropType<MenuRoute[]>,
    default: () => [],
  },
  isFixed: {
    type: Boolean,
    default: false,
  },
  isCompact: {
    type: Boolean,
    default: false,
  },
  maxLevel: {
    type: Number,
    default: 3,
  },
});

const settingStore = useSettingStore();

const toggleSettingPanel = () => {
  settingStore.updateConfig({
    showSettingPanel: true,
  });
};

const active = computed(() => getActive());

const layoutCls = computed(() => [`${prefix}-header-layout`]);

const menuCls = computed(() => {
  const { isFixed, layout, isCompact } = props;
  return [
    {
      [`${prefix}-header-menu`]: !isFixed,
      [`${prefix}-header-menu-fixed`]: isFixed,
      [`${prefix}-header-menu-fixed-side`]: layout === 'side' && isFixed,
      [`${prefix}-header-menu-fixed-side-compact`]: layout === 'side' && isFixed && isCompact,
    },
  ];
});
const menuTheme = computed(() => props.theme as 'light' | 'dark');

const handleNav = (name: string) => {
  router.push({ name });
};

const handleLogout = () => {
  router.push({
    path: '/merchant/login',
    query: { redirect: encodeURIComponent(router.currentRoute.value.fullPath) },
  });
};
</script>
<style lang="less" scoped>
.@{starter-prefix}-header {
  &-menu-fixed {
    position: fixed;
    top: 0;
    z-index: 1001;

    :deep(.t-head-menu__inner) {
      padding-right: var(--td-comp-margin-xl);
    }

    &-side {
      left: 200px;
      right: 0;
      z-index: 10;
      width: auto;
      transition: all 0.3s;

      &-compact {
        left: 64px;
      }
    }
  }

  &-logo-container {
    cursor: pointer;
    display: inline-flex;
  }
}

.header-menu {
  flex: 1 1 1;
  display: inline-flex;

  :deep(.t-menu__item) {
    min-width: unset;
  }
}

.operations-container {
  display: flex;
  align-items: center;

  .t-popup__reference {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .t-button {
    margin-left: var(--td-comp-margin-l);
  }

  .shop-status-not {
    margin-left: var(--td-comp-margin-l);
    color: #999;
    background: #eaeaea;
    padding: 0 16px;
  }

  .shop-status-right {
    margin-left: var(--td-comp-margin-l);
    background-color: var(--td-brand-color);
    color: var(--td-text-color-anti);
    border-color: var(--td-brand-color);
    padding: 0 16px;
  }
}

.header-operate-left {
  display: flex;
  align-items: normal;
  line-height: 0;
}

.header-logo-container {
  width: 184px;
  height: 26px;
  display: flex;
  margin-left: 24px;
  color: var(--td-text-color-primary);

  .t-logo {
    width: 100%;
    height: 100%;

    &:hover {
      cursor: pointer;
    }
  }

  &:hover {
    cursor: pointer;
  }
}

.header-user-account {
  display: inline-flex;
  align-items: center;
  color: var(--td-text-color-primary);
}

:deep(.t-head-menu__inner) {
  border-bottom: 1px solid var(--td-component-stroke);
}

.t-menu--light {
  .header-user-account {
    color: var(--td-text-color-primary);
  }
}

.t-menu--dark {
  .t-head-menu__inner {
    border-bottom: 1px solid var(--td-gray-color-10);
  }

  .header-user-account {
    color: rgba(255, 255, 255, 0.55);
  }
}

.operations-dropdown-container-item {
  width: 100%;
  display: flex;
  align-items: center;

  :deep(.t-dropdown__item-text) {
    display: flex;
    align-items: center;
  }

  .t-icon {
    font-size: var(--td-comp-size-xxxs);
    margin-right: var(--td-comp-margin-s);
  }

  :deep(.t-dropdown__item) {
    width: 100%;
    margin-bottom: 0px;
  }

  &:last-child {
    :deep(.t-dropdown__item) {
      margin-bottom: 8px;
    }
  }
}
:deep(.t-button--variant-text) {
  height: var(--td-comp-size-l);
}
</style>

<!-- eslint-disable-next-line vue-scoped-css/enforce-style-type -->
<style lang="less">
.operations-dropdown-container-item {
  .t-dropdown__item-text {
    display: flex;
    align-items: center;
  }
}
</style>

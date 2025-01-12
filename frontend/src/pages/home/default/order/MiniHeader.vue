<template>
  <nav class="navbar navbar-expand-md navbar-dark">
    <div class="container">
      <a class="navbar-brand" style="width: 166px" @click="goPage('index', {})">
        <img :src="siteLogo" alt="" />
      </a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="list-enter">
          <li>
            <t-button shape="round" theme="danger" variant="base" @click="showTsDialogPage(true)">投诉商家</t-button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <plaint-dialog v-if="showTsDialog" @update:visible="showTsDialogPage" />
</template>
<script lang="ts">
export default {
  name: 'MiniHeader',
};
</script>
<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { useSiteStore } from '@/store';

import PlaintDialog from './components/PlaintDialog.vue';

const router = useRouter();
const siteRouter = useSiteStore();
const siteLogo = siteRouter.getSiteLogo;
const showTsDialog = ref(false);
const { ts } = router.currentRoute.value.query;
showTsDialog.value = !!ts;

const showTsDialogPage = (e: boolean) => {
  showTsDialog.value = e;
};

const goPage = (path: string, val: any) => {
  router.push({
    name: path,
    params: {
      alias: val,
    },
  });
};
</script>
<style lang="less" scoped>
@import url('../css/style.less');

.t-button--shape-round {
  border-radius: var(--td-radius-round);
}
</style>

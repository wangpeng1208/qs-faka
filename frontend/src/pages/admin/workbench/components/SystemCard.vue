<template>
  <t-card title="版本信息" hover-shadow>
    <t-skeleton v-if="loading" :row-col="rowCol"></t-skeleton>
    <div v-else>
      <div class="flex leading-9">
        <div class="w-20">当前版本</div>
        <span>
          <t-space>
            {{ workbenchData?.version }}
            <t-tag v-if="workbenchData?.authorize?.status" theme="success" hover="color" variant="light"> 免费授权版 </t-tag>
          </t-space>
        </span>
      </div>
      <div class="flex leading-9">
        <div class="w-20">程序作者</div>
        <span> {{ workbenchData?.author?.name }}({{ workbenchData?.author?.email }})</span>
      </div>
      <div class="flex leading-9">
        <div class="w-20">技术栈</div>
        <span> {{ workbenchData?.framework?.frontend }} {{ workbenchData?.framework?.backend }}</span>
      </div>
      <div class="flex leading-9">
        <div class="w-20">相关链接</div>
        <t-space>
          <t-link v-for="(item, index) in workbenchData?.license" :key="index" underline theme="primary" :href="item.url" target="_blank" class="ml-3" type="primary" size="small">《{{ item.name }}》</t-link>
        </t-space>
      </div>
    </div>
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin, SkeletonProps } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { systemVersion } from '@/api/admin/workbench';

const workbenchData = reactive({
  version: '',
  authorize: {
    status: false,
    end_time: 0,
  },
  author: {
    name: '',
    email: '',
  },
  framework: {
    frontend: '',
    backend: '',
  },
  license: [],
});
const loading = ref(true);
const rowCol: SkeletonProps['rowCol'] = Array.from({ length: 4 }).map(() => [
  {
    type: 'rect',
    flex: '1',
    width: '80px',
    height: '10px',
  },
  {
    type: 'rect',
    flex: '1',
    width: '100%',
    height: '10px',
  },
]);
const initData = async () => {
  const res = await systemVersion();
  Object.assign(workbenchData, res.data);
  if (workbenchData.authorize.status === false) {
    MessagePlugin.error({ content: '软件未授权，部分功能被限制', duration: 0, closeBtn: true });
  }
  loading.value = false;
};
initData();
</script>

<style lang="less" scoped>
.flex {
  display: flex;
  justify-content: space-between;
}
.leading-9 {
  line-height: 25px;
}
</style>

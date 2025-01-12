<template>
  <t-card title="站点配置" class="basic-container" :bordered="false">
    <t-tabs :default-value="1">
      <t-tab-panel v-for="(item, index) in tabList" :key="index" :value="item.value" :label="item.label">
        <component :is="item.component" />
      </t-tab-panel>
    </t-tabs>
  </t-card>
</template>

<script setup lang="ts">
import WebAgreement from './components/web-agreement.vue';
import WebDomain from './components/web-domain.vue';
import WebInfo from './components/web-info.vue';
import WebWordfilter from './components/web-wordfilter.vue';

const tabList = [
  {
    label: '网站配置',
    component: WebInfo,
    value: 1,
  },
  {
    label: '政策协议',
    component: WebAgreement,
    value: 2,
  },
  {
    label: '域名配置',
    component: WebDomain,
    value: 3,
  },
  {
    label: '敏感词过滤',
    component: WebWordfilter,
    value: 5,
  },
];
</script>

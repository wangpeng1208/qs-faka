<template>
  <t-card :bordered="false" title="操作步骤" :class="{ 'dashboard-overview-card': true, 'overview-panel': true }" style="margin: 20px 0">
    <t-row :gutter="[0, { xs: 8, sm: 16, md: 16, lg: 16, xl: 16, xxl: 40 }]">
      <t-col v-for="(item, index) in options" :key="index" :span="2">
        <t-button :icon="item.dot" theme="primary" variant="outline" @click="goPage(item.path)"> {{ item.label }} </t-button>
      </t-col>
    </t-row>
  </t-card>
</template>

<script lang="tsx" setup>
import { Numbers2Icon, Numbers3Icon, Numbers4Icon, Numbers5Icon, Numbers11Icon } from 'tdesign-icons-vue-next';
import { useRouter } from 'vue-router';

const color = 'var(--td-brand-color)';
const options = [
  { label: '店铺设置', path: '/merchant/shop/config', dot: () => <Numbers11Icon size="medium" color={color} /> },
  { label: '添加栏目', path: '/merchant/goods/category', dot: () => <Numbers2Icon size="medium" color={color} /> },
  { label: '添加商品', path: '/merchant/goods/add', dot: () => <Numbers3Icon size="medium" color={color} /> },
  { label: '添加库存', path: '/merchant/goods/card/add', dot: () => <Numbers4Icon size="medium" color={color} /> },
  { label: '店铺链接', path: '/merchant/shop/link', dot: () => <Numbers5Icon size="medium" color={color} /> },
];
const router = useRouter();
const goPage = (path: string) => {
  router.push(path);
};
</script>

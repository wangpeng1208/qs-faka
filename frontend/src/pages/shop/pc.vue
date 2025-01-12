<template>
  <div>
    <!-- 引入default 组件 -->
    <default v-if="theme == 'default'" :info="info" />
    <year v-if="theme == 'year'" :info="info" />
    <error v-else-if="theme == 'error'" :tip="info" />
    <div v-else></div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { getShopInfo } from '@/api/shop/shop';

import Default from './pc/default/index.vue';
import Error from './pc/error/index.vue';
import Year from './pc/year/index.vue';

const router = useRouter();
// 商铺的主题
const theme = ref('');
const { token } = router.currentRoute.value.params;
const msg = ref('');
const info = ref({
  shop: {
    shop_name: '',
  },
  categorys: [],
  goods: [],
  error: '',
});

// 标题
const setTitle = (title: string) => {
  document.title = title;
};
// 通过token查询商铺的信息
const shopInfo = async () => {
  const params = {
    token,
  };
  const res = await getShopInfo(params);
  if (res.code === 0) {
    msg.value = res.msg;
    theme.value = 'error';
    info.value.error = res.msg;
  } else {
    const { data } = res;
    theme.value = data.pcTemplate;
    info.value = data;
    setTitle(info.value.shop.shop_name ? info.value.shop.shop_name : '未命名商铺');
    if (!info.value.categorys.length) {
      theme.value = 'error';
      info.value.error = '请添加商品分类后重试！';
    }
  }
};
shopInfo();
</script>

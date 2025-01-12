<template>
  <div id="index" class="index-wrapper">
    <c-header />
    <div class="container">
      <div class="help-banner">
        <div class="box">
          <div class="bgimg1"><img src="../css/img/bg_help1.png" alt="" /></div>
          <div class="bgimg2"><img src="../css/img/bg_help2.png" alt="" /></div>
          <h1>帮助中心</h1>
          <p class="d-none d-lg-block">新闻动态、公告通知、资讯您在这里就能看到</p>
        </div>
      </div>
    </div>
    <div class="help">
      <div class="container">
        <ul class="nav-tabs">
          <li v-for="(item, index) in aliasData" :key="index" class="nav-item" @click="goPage('news_cate', item)">
            <a class="nav-link" :class="currentLabel == item.alias ? 'active' : ''">
              {{ item.label }}
            </a>
          </li>
        </ul>
      </div>
      <div class="help-details">
        <div class="container">
          <div class="help-details-box">
            <ol class="breadcrumb">
              <!-- <li class="breadcrumb-item">
                <a>{{ category.name }}</a>
              </li> -->
              <li class="breadcrumb-item active">
                <a href="">{{ detail.title }}</a>
              </li>
            </ol>
            <div class="hd">
              <h1>{{ detail.title }}</h1>
              <h2>发布日期：{{ formatTime(detail.create_at) }}</h2>
            </div>
            <div class="bd" v-html="detail.content"></div>
          </div>
        </div>
      </div>
    </div>
    <c-footer />
  </div>
</template>
<script lang="ts">
export default {
  name: 'DefaultActicleInfo',
};
</script>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref, toRefs } from 'vue';

import { getDetailContent, getNewsType } from '@/api/home/arctile';
import router from '@/router';
import { formatTime } from '@/utils/date';

import CFooter from '../components/Footer.vue';
import CHeader from '../components/Header.vue';

const aliasData = ref([]);
const getAliasData = async () => {
  const res = await getNewsType();
  if (res.code === 1) {
    const { data } = res;
    aliasData.value = data;
  }
};
const currentLabel = ref();

// 获取父组件中 id
const props = defineProps({
  id: {
    type: [Number, String],
    default: '',
  },
});

const { id } = toRefs(props);

const category = ref(null);
const detail = reactive({
  title: '',
  content: '',
  create_at: '' as any,
});
const getDetail = async () => {
  const param = {
    id: id.value,
  };
  const res = await getDetailContent(param);
  if (res.code === 1) {
    const { data } = res;
    // data.detail 合并到 detail
    Object.assign(detail, data.detail);
    category.value = data.category;
    currentLabel.value = category.value.alias;
  } else {
    MessagePlugin.error(res.msg);
  }
};

const goPage = (path: string, item: any) => {
  router.push({
    name: path,
    params: {
      alias: item.alias,
    },
  });
};

getAliasData();
getDetail();
</script>

<style scoped lang="less">
@import url('../css/style.less');
@import url('../css/bootstrap.min.css');
.nav-tabs {
  display: flex;
}
</style>

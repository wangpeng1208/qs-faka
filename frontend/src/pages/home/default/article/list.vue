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
      <div class="help-box">
        <div class="container tab-content">
          <div id="help4" class="tab-pane active">
            <div class="question">
              <div v-for="(item, index) in listData" :key="index" class="notice-item">
                <dl class="date">
                  <dt>{{ getDay(formatTime(item.create_at)) }}</dt>
                  <dd>{{ getMonth(formatTime(item.create_at)) }}</dd>
                </dl>
                <dl class="txt">
                  <dt>
                    <a @click="goArticlePage(item)">{{ item.title }}</a>
                  </dt>
                  <dd>{{ filterHtml(item.content) }}</dd>
                </dl>
                <a class="arrow" @click="goArticlePage(item)"></a>
              </div>

              <ul class="pagination"></ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <c-footer />
  </div>
</template>
<script setup lang="ts">
import { onMounted, ref, watchEffect } from 'vue';
import { useRoute } from 'vue-router';

import { getNewsList, getNewsType } from '@/api/home/arctile';
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
const currentLabel = ref('') as any;
const route = useRoute();
watchEffect(() => {
  const { alias } = route.params;
  if (alias) {
    currentLabel.value = alias;
  } else {
    currentLabel.value = 'notice';
    router.push({
      name: 'news_cate',
      params: {
        alias: 'notice',
      },
    });
  }
});

// 获取分类下的列表数据
const listData = ref([]);
const getList = async (alias: string) => {
  const params = {
    alias,
    page: 1,
    limit: 10,
  };
  const res = await getNewsList(params);
  if (res.code === 1) {
    const { data } = res;
    listData.value = data.list;
  }
};
getList(currentLabel.value);
const goPage = (path: string, item: any) => {
  currentLabel.value = item.alias;
  // 获取分类下的列表数据
  getList(currentLabel.value);
  router.push({
    name: path,
    params: {
      alias: item.alias,
    },
  });
};
const goArticlePage = (item: any) => {
  router.push({
    name: 'article',
    params: {
      id: item.id,
    },
  });
};
// time 时间戳计算 当前天
const getDay = (time: any) => {
  const timestamp = Date.parse(time);
  const date = new Date(timestamp);
  const D = `${date.getDate() < 10 ? `0${date.getDate()}` : date.getDate()}`;
  return D;
};
// 时间戳计算 当前年月 格式 月/年
const getMonth = (time: any) => {
  const timestamp = Date.parse(time);
  const date = new Date(timestamp);
  const Y = `${date.getFullYear()}`;
  const M = `${date.getMonth() + 1 < 10 ? `0${date.getMonth() + 1}` : date.getMonth() + 1}`;
  return `${M}/${Y}`;
};
// 过滤html标签 保留文本, 截取前100个汉字
const filterHtml = (str: any) => {
  // str转 htmlspecialchars_decode
  str = str.replace(/&amp;/g, '&');
  str = str.replace(/&lt;/g, '<');
  str = str.replace(/&gt;/g, '>');
  str = str.replace(/&quot;/g, '"');
  str = str.replace(/&#039;/g, "'");
  const reg = /<[^>]+>/g;
  const newStr = str.replace(reg, '');
  return newStr.substring(0, 100);
};
onMounted(() => {
  getAliasData();
});
</script>

<style scoped lang="less">
@import url('../css/style.less');
@import url('../css/bootstrap.min.css');
.nav-tabs {
  display: flex;
}
</style>

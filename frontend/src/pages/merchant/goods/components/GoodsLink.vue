<template>
  <t-dialog v-model:visible="visible" :destroy-on-close="true" :close-on-overlay-click="false" width="750" header="商品链接" :footer="false">
    <template #body>
      <div class="info-block">
        <div class="info-item">
          <t-space>
            <h1>链接状态</h1>
            <wp-check-tag v-model="linkData.status" :items="linkStatusTag" @actions="setLinkStutus" />
          </t-space>
          <div class="help">选择暂停将仅当前商品链接不可用</div>
        </div>
        <div class="info-item">
          <t-space>
            <h1>绿标短链</h1>
            <t-link theme="primary" :href="linkData.short_link" target="_blank">
              {{ linkData.short_link }}
            </t-link>
            <t-tag class="hand-cursor" theme="primary" variant="light" size="small" @click="copyText(linkData.short_link)">
              <template #icon> <file-copy-icon /> </template>复制
            </t-tag>
            <t-tag class="hand-cursor" theme="primary" size="small" @click="resetLink(0)">
              <template #icon> <refresh-icon /> </template>重置短链
            </t-tag>
          </t-space>
          <div class="help">绿标短链接打开就是商品长链接，强烈建议使用绿标短链接作为访问链接；如果在朋友圈等地方打广告请发【绿标短链】这个链接，这样可以让您的朋友直接进入您的店铺</div>
        </div>
        <div class="info-item">
          <t-space>
            <h1>商品链接</h1>
            <t-link theme="primary" :href="linkData.link" target="_blank">
              {{ linkData.link }}
            </t-link>
            <t-tag class="hand-cursor" theme="primary" variant="light" size="small" @click="copyText(linkData.link)">
              <template #icon> <file-copy-icon /> </template>复制
            </t-tag>
            <t-tag class="hand-cursor" theme="primary" size="small" @click="resetLink(1)">
              <template #icon> <refresh-icon /> </template>重置分接
            </t-tag>
          </t-space>
          <div class="help">重置商品链接后，当前商品的原短链长连接都会失效；严禁使用此链接发广告</div>
        </div>
        <div class="info-item">
          <t-space>
            <h1>电脑端风格</h1>
            <t-check-tag v-for="(item, index) in pcTemplate" :key="index" :checked="item.value == userPcTemplate" @change="changeTemplate('theme', item.value)">
              {{ item.label }}
            </t-check-tag>
          </t-space>
          <div class="help">当前商品链接PC页面风格</div>
        </div>
      </div>
    </template>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'GoodsLink',
};
</script>
<script setup lang="ts">
import { FileCopyIcon, RefreshIcon } from 'tdesign-icons-vue-next';
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { close, getTheme, good, reset, setTheme } from '@/api/merchant/goods/link';
import { getMobileThemes, getPcThemes } from '@/api/merchant/shop/link';
import { copyText } from '@/utils/common';

const linkData = ref({
  id: 0,
  link: '',
  short_link: '',
  status: 0,
});

const visible = ref(false);
// 数据初始化
const init = async (id: any) => {
  const { data } = await good({ id });
  if (data) {
    linkData.value = { ...data };
    visible.value = true;
    getTemplate();
    getUserTemplate();
  } else {
    MessagePlugin.error('获取链接失败');
  }
};
const resetLink = async (status: number) => {
  // 弹窗提示 是否执行操作
  // status 0重置 1删除
  const data = await reset({ type: 'good', id: linkData.value.id, status });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    init(linkData.value.id);
  }
};
const setLinkStutus = async (status: number) => {
  // 弹窗提示 是否执行操作
  const data = await close({ type: 'good', id: linkData.value.id, status });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    init(linkData.value.id);
  }
};

const pcTemplate = ref([]);
const mobileTemplate = ref([]);
const getTemplate = async () => {
  const pcData = await getPcThemes();
  const mobileData = await getMobileThemes();
  pcTemplate.value = pcData.data;
  mobileTemplate.value = mobileData.data;
};

// 用户当前模板设置
const userPcTemplate = ref(null);
const userMobileTemplate = ref(null);
const getUserTemplate = async () => {
  const { data } = await getTheme({ id: linkData.value.id, type: 'good' });
  userPcTemplate.value = data.pc_template;
  userMobileTemplate.value = data.mobile_template;
};
// 更改模板
const changeTemplate = async (field: string, value: string) => {
  const data = await setTheme({ field, value, id: linkData.value.id, type: 'good' });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    getUserTemplate();
  } else {
    MessagePlugin.error(data.msg);
  }
};

// 暂停销售 按钮选择
const linkStatusTag = [
  {
    label: '开启',
    value: 1,
  },
  {
    label: '暂停',
    value: 0,
  },
];
defineExpose({
  init,
});
</script>
<style lang="less" scoped>
.info-block {
  .info-item {
    padding: var(--td-comp-paddingTB-m) 0;
    color: var(--td-text-color-primary);

    h1 {
      width: 100px;
      font-weight: normal;
      font: var(--td-font-body-medium);
      color: var(--td-text-color-secondary);
      text-align: left;
      line-height: 22px;
      float: left;

      @media (max-width: @screen-sm-max) {
        width: 100px;
      }

      @media (min-width: @screen-md-min) and (max-width: @screen-md-max) {
        width: 120px;
      }
    }

    span {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      margin-left: 24px;
    }

    .help {
      color: var(--td-text-color-secondary);
      font-size: 12px;
      margin: 10px 0 0 124px;
      display: block;
    }

    img {
      width: 200px;
      height: 200px;
      margin-left: 24px;
    }

    i {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: var(--td-radius-circle);
      background: var(--td-success-color-5);
    }
  }
}
</style>

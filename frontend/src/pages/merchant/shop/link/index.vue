<template>
  <t-card title="店铺链接" class="basic-container" :bordered="false">
    <!-- 昨夜冷风付我衣，我梦回故乡,不似他乡未知客，却是故园多故人 -->
    <t-loading attach=".basic-container" size="small" :loading="dataLoading"></t-loading>
    <t-form label-align="left" :label-width="160">
      <t-form-item label="链接状态" tips="店铺总链接状态，选择暂停将仅当前店铺“总链接”不可用">
        <t-space>
          <t-check-tag v-for="(item, key) in linkStatusTag" :key="key" :checked="item.value == user.link_status" @change="closeLink(item.value)">
            {{ item.label }}
          </t-check-tag>
        </t-space>
      </t-form-item>
      <t-form-item label="绿标短链" tips="绿标短链接打开就是店铺长链接，强烈建议使用绿标短链接作为访问链接;如果在朋友圈等地方打广告请发【绿标短链】这个链接，这样可以让您的朋友直接进入您的店铺">
        <t-space>
          <t-link theme="primary" :href="user?.short_link" target="_blank"> {{ user?.short_link }} </t-link>
          <t-tag theme="primary" variant="light" size="small" class="tag" @click="copyText(user?.short_link)">
            <template #icon> <file-copy-icon /> </template>
            复制
          </t-tag>
          <t-tag theme="primary" size="small" class="tag" @click="resetLink(0)">
            <template #icon> </template>
            重置短链接
          </t-tag>
        </t-space>
      </t-form-item>
      <t-form-item label="店铺总链" tips="重置总链接后，原短链长连接都会失效；严禁使用此链接发广告">
        <t-space>
          <t-link theme="primary" :href="user.link" target="_blank">{{ user.link }} </t-link>
          <t-tag theme="primary" variant="light" size="small" class="tag" @click="copyText(user.link)">
            <template #icon> <file-copy-icon /> </template>复制
          </t-tag>
          <t-tag theme="primary" size="small" class="tag" @click="resetLink(1)">
            <template #icon> <refresh-icon /> </template>重置总链接
          </t-tag>
        </t-space>
      </t-form-item>
      <t-form-item label="店铺主题" tips="店铺页面主题风格">
        <t-skeleton :loading="templateLoading" animation="flashed" :row-col="[{ type: 'rect', width: '600px', height: '30px' }]">
          <t-space>
            <t-check-tag v-for="(item, key) in pcTemplate" :key="key" :checked="item.value == userPcTemplate" @change="changeTemplate('pc_template', item.value)">
              {{ item.label }}
            </t-check-tag>
          </t-space>
        </t-skeleton>
      </t-form-item>
    </t-form>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'UserLink',
};
</script>

<script setup lang="ts">
import { FileCopyIcon, RefreshIcon } from 'tdesign-icons-vue-next';
import { DialogPlugin, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { close, getMobileThemes, getPcThemes, getTemplate, index, reset, setTemplate } from '@/api/merchant/shop/link';
import { copyText } from '@/utils/common';

const dataLoading = ref(false);
const user = reactive({
  link: '',
  short_link: '',
  src: '',
  user_status: 0,
  link_status: null,
});

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
const fetchData = async () => {
  dataLoading.value = true;
  const { data } = await index();
  user.short_link = data.shortLink;
  user.link = data.link;
  user.src = data.link_src;
  user.user_status = data.user_status;
  user.link_status = [data.link_status];
  dataLoading.value = false;
};
fetchData();

const resetLink = async (status: number) => {
  let body = '';
  if (status === 0) {
    body = `确定要重置短链接吗？重置链接后，之前的短链接将不能访问！`;
  } else if (status === 1) {
    body = `确定要重置总链接吗？重置链接后，之前的总链接将及短链接不能访问！`;
  }
  const confirmDia = DialogPlugin({
    header: '温馨提示',
    body,
    theme: 'warning',
    confirmBtn: '确认',
    closeOnOverlayClick: false,
    onConfirm: () => {
      confirmDia.hide();
      dataLoading.value = true;
      reset({ status }).then((res) => {
        if (res.code === 1) {
          MessagePlugin.success(res.msg);
          fetchData();
        } else {
          MessagePlugin.error(res.msg);
        }
        dataLoading.value = false;
      });
    },
    onClose: () => {
      confirmDia.hide();
    },
  });
};
const closeLink = async (status: number) => {
  if (user.link_status === status) return;
  const data = await close({ status });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    fetchData();
  }
};

const templateLoading = ref(true);
const pcTemplate = ref([]);
const mobileTemplate = ref([]);
const getShopTemplate = async () => {
  const pcData = await getPcThemes();
  const mobileData = await getMobileThemes();
  pcTemplate.value = pcData.data;
  mobileTemplate.value = mobileData.data;
  templateLoading.value = false;
};
getShopTemplate();

// 用户当前模板设置
const userPcTemplate = ref(null);
const userMobileTemplate = ref(null);
const getUserTemplate = async () => {
  const data = await getTemplate();
  userPcTemplate.value = data.data.pc_template;
  userMobileTemplate.value = data.data.mobile_template;
};
getUserTemplate();

// 更改模板
const changeTemplate = async (field: string, value: string) => {
  const data = await setTemplate({ field, value });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    getUserTemplate();
  } else {
    MessagePlugin.error(data.msg);
  }
};
</script>

<style lang="less" scoped>
.qrimg {
  width: 200px;
  height: 200px;
}

.tag {
  cursor: pointer;
}
</style>

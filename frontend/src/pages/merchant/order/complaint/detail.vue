<template>
  <t-card title="投诉详情" class="basic-container" :bordered="false">
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/order/complaint')">
        <template #icon><t-icon name="rollback" /></template>
        返回
      </t-button>
    </template>
    <t-descriptions>
      <t-descriptions-item label="订单编号">{{ fetchData?.complaint?.trade_no }}</t-descriptions-item>
      <t-descriptions-item label="举报原因">{{ fetchData?.complaint?.type }}</t-descriptions-item>
      <t-descriptions-item label="投诉说明">{{ fetchData?.complaint?.desc }}</t-descriptions-item>
      <t-descriptions-item label="联系方式 ">{{ fetchData?.complaint?.mobile }}</t-descriptions-item>
      <t-descriptions-item label="投诉状态">{{ fetchData?.complaint?.status === 0 ? '处理中' : fetchData?.complaint?.status == -1 ? '已撤销' : '已处理' }}</t-descriptions-item>
      <t-descriptions-item label="投诉结果 ">{{ fetchData?.complaint?.result == 0 ? '处理中' : fetchData?.complaint?.result == 1 ? '商家胜诉' : '买家胜诉' }}</t-descriptions-item>
      <t-descriptions-item label="投诉时间">{{ formatTime(fetchData?.complaint?.create_at) }}</t-descriptions-item>
      <t-descriptions-item label="剩余时间">{{ countDown }}</t-descriptions-item>
    </t-descriptions>
    <t-comment v-if="fetchData?.complaint?.status === 0">
      <template #content>
        <div class="form-container">
          <wp-editor v-model="replay" height="300px" mode="simple" user-type="merchant" path="upload/merchant/order/complaint/" />
          <t-button class="form-submit" @click="submitReply">发送内容</t-button>
        </div>
      </template>
    </t-comment>
    <div class="message-list">
      <t-list :split="true">
        <t-list-item v-for="(item, index) in fetchData?.messages" :key="index">
          <template #content>
            <t-comment :author="author(item?.type)" :datetime="formatTime(item.create_at)">
              <template #content>
                <div v-html="item.content"></div>
              </template>
            </t-comment>
          </template>
        </t-list-item>
      </t-list>
    </div>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'RowDetail',
};
</script>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { detail, send } from '@/api/merchant/order/complaint';
import { expireTime } from '@/hooks';
import { useUserStore } from '@/store';
import { formatTime } from '@/utils/date';

const { wss: ws } = useUserStore();

const router = useRouter();

const groupId = router.currentRoute.value.query.id;
// 浏览器监听group-2频道的消息，也就是监听群组2的群消息
const groupChannel = ws.subscribe(`private-group-complaint-${groupId}`);
// 当群组2有message消息事件时
groupChannel.on('message', (data: any) => {
  fetchData.messages.unshift(data);
});

const userTypeMap = [
  { value: 'admin', label: '管理员' },
  { value: 'merchant', label: '商户' },
  { value: 'buyer', label: '买家' },
  { value: 'agent', label: '上级卖家' },
];

const author = (txt: any) => {
  const userType = userTypeMap.find((userType) => userType.value === txt);
  return userType ? userType.label : '未知';
};

const replay = ref('');
const submitReply = async () => {
  if (replay.value === '') return;
  const res = await send({
    id: router.currentRoute.value.query.id,
    content: replay.value,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    replay.value = '';
  } else {
    MessagePlugin.error(res.msg);
  }
};

const fetchData = reactive<any>({});
const [countDown, handleCounter] = expireTime();

const initData = async () => {
  const { data } = await detail({
    id: router.currentRoute.value.query.id,
  });
  Object.assign(fetchData, data);
  if (fetchData) {
    handleCounter(fetchData?.complaint?.expire_at);
  }
};
initData();
</script>
<style lang="less" scoped>
.form-container {
  flex-direction: column;
  align-items: flex-end;
  .form-submit {
    margin-top: 8px;
    float: right;
  }
}
.message-list {
  margin: 20px 0;

  :deep(img) {
    width: 300px;
  }
}
</style>

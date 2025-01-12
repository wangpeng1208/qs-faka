<template>
  <t-card title="投诉详情" class="basic-container" :bordered="false">
    <t-descriptions>
      <t-descriptions-item label="订单编号">{{ fetchData?.complaint?.trade_no }}</t-descriptions-item>
      <t-descriptions-item label="举报原因">{{ fetchData?.complaint?.type }}</t-descriptions-item>
      <t-descriptions-item label="投诉说明">{{ fetchData?.complaint?.desc }}</t-descriptions-item>
      <t-descriptions-item label="联系方式 ">{{ fetchData?.complaint?.mobile }}</t-descriptions-item>
      <t-descriptions-item label="投诉状态">{{ fetchData?.complaint?.status === 0 ? '处理中' : fetchData?.complaint?.status == -1 ? '已撤销' : '已处理' }}</t-descriptions-item>
      <t-descriptions-item label="投诉结果 ">{{ fetchData?.complaint?.result == 0 ? '处理中' : fetchData?.complaint?.result == 1 ? '商家胜诉' : '买家胜诉' }}</t-descriptions-item>
      <t-descriptions-item label="投诉时间">{{ formatTime(fetchData?.complaint?.create_at) }}</t-descriptions-item>
      <t-descriptions-item label="剩余时间">
        <span v-if="fetchData?.complaint?.result == 1">已结束</span>
        <span v-else>{{ countDown }}</span>
      </t-descriptions-item>
    </t-descriptions>
    <t-comment>
      <template #content>
        <div class="form-container">
          <wp-editor v-model="replay" height="300px" width="100%" mode="simple" user-type="admin" />
          <t-button class="form-submit" @click="submitReply">发送内容</t-button>
        </div>
      </template>
    </t-comment>
    <!-- 胜诉 -->
    <t-space>
      <t-divider />
      <t-button v-if="fetchData?.complaint?.status === 0" theme="success" @click="handleWin(1)">商家胜诉</t-button>
      <t-button v-if="fetchData?.complaint?.status === 0" theme="danger" @click="handleWin(2)">买家胜诉</t-button>
      <t-divider />
    </t-space>
    <t-card title="聊天内容" class="message-list">
      <t-list :split="true" style="height: 500px" :scroll="{ type: 'virtual' }">
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
    </t-card>
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

import { detail, send, win } from '@/api/admin/order/complaint';
import { expireTime } from '@/hooks';
import { formatTime } from '@/utils/date';

const router = useRouter();
const fetchData = reactive<any>({});

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
const handleWin = async (result: number) => {
  const res = await win({
    id: router.currentRoute.value.query.id,
    result,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    initData();
  } else {
    MessagePlugin.error(res.msg);
  }
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
const [countDown, handleCounter] = expireTime();

const initData = async () => {
  const res = await detail({
    id: router.currentRoute.value.query.id,
  });
  if (res.code === 0) {
    MessagePlugin.error(res.msg);
  }
  Object.assign(fetchData, res.data);
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

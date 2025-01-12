<template>
  <div>
    <t-card title="商户信息" :bordered="false" class="basic-container" style="margin-top: 20px">
      <t-alert style="margin-bottom: 20px" theme="warning" message="请完善商户资料，以便更好的为您服务。【用户名/手机号/邮箱可以用来登录】" />
      <t-form label-align="left" :label-width="150">
        <t-form-item label="用户头像">
          <wp-upload theme="image" :initial="userData" app="merchant" name="avatar" :data="{ type: 'image' }" @update="handleUpdateImage" />
        </t-form-item>
        <t-form-item label="账号状态" tips="账号审核状态">
          <span v-if="userData.status" class="status"></span>
          {{ userData.status ? '已审核' : '未审核' }}
        </t-form-item>
        <t-form-item label="创建时间" tips="账号创建时间">
          {{ formatTime(userData.create_at) }}
        </t-form-item>
        <t-form-item label="用户名称" tips="系统自动生成随机账号名">
          {{ userData.username ?? '未设置' }}
        </t-form-item>
        <t-form-item label="手机号码" tips="手机号码也是登录账号，不可更改，如需更改请联系管理员">
          {{ userData.mobile }}
        </t-form-item>
        <t-form-item label="邮箱地址" tips="邮箱地址可以用来登录账号及消息提醒">
          <t-space>
            {{ userData.email ? userData.email : '未绑定' }}
            <t-link v-if="!userData.email" theme="warning" size="small" @click="changeEmail(userData.email)">{{ userData.email ? '修改邮箱' : '点击绑定' }}</t-link>
          </t-space>
        </t-form-item>

        <email-dialog ref="emailRef" @success="initUserSetting" />
      </t-form>
    </t-card>
  </div>
</template>

<script lang="ts">
export default {
  name: 'UserSetting',
};
</script>

<script setup lang="ts">
import { computed, nextTick, ref } from 'vue';

import { setAvatar } from '@/api/merchant/user/user';
import WpUpload from '@/components/upload/index.vue';
import { useUserStore } from '@/store';
import { formatTime } from '@/utils/date';

import EmailDialog from './bindEmail.vue';

const userStore = useUserStore();
const userData = computed(() => userStore.userInfo);
const initUserSetting = () => {
  // 初始化用户设置
  // @ts-ignore
  $refs.emailRef?.init();
};

const handleUpdateImage = async ({ name, url }: any) => {
  // @ts-ignore
  userData[name] = url;
  const res = await setAvatar({
    avatar: url,
  });
  if (res.code === 1) {
    // 设置user仓库的头像
    useUserStore().setAvatar(url);
  }
};
// 修改邮箱
const emailRef = ref(null);
const changeEmail = async (email: any) => {
  await nextTick();
  emailRef.value?.open(email);
};
</script>
<style lang="less" scoped>
.status {
  height: 5px;
  width: 5px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
  margin-right: 5px;
}
.form-list {
  display: table;
  font-size: 12px;
}
.form-list li {
  display: table-row;
}
</style>

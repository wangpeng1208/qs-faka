<template>
  <t-card title="用户管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <row-search ref="searchFormRef" @success="fetchSearchData" />
    </div>
    <div class="category-header c-flex">
      <div class="l">
        <t-button v-perms="['adminapi/merchant/user/add']" theme="primary" @click="editRow(0)">添加</t-button>
      </div>
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" :expand-on-row-click="false" :expanded-row-keys="expandedRowKeys" :expand-icon="false" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #expandedRow="{ row }">
        <div calss="edit" style="float: left; height: 30px">
          <t-space>
            <t-link v-perms="['adminapi/merchant/user/eidt']" theme="primary" hover="color" @click="editRow(row.id)">
              <t-icon name="edit" />
              编辑
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/message']" theme="primary" hover="color" @click="messageRow(row.id)">
              <t-icon name="chat-message" />
              发送消息
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/money']" theme="primary" hover="color" @click="moneyRow(row.id)">
              <t-icon name="currency-exchange" />
              资金管理
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/collectDetail']" theme="primary" hover="color" @click="collectRow(row.id)">
              <t-icon name="currency-exchange" />
              收款信息
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/role']" theme="primary" hover="color" @click="roleRow(row.id)">
              <t-icon name="bookmark" />
              分配角色
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/rate']" theme="primary" hover="color" @click="rateRow(row)">
              <t-icon name="application" />
              设置费率
            </t-link>
            <t-link v-perms="['adminapi/merchant/user/unlock']" theme="primary" hover="color" @click="unlockRow(row.id)">
              <t-icon name="lock-off" />
              登录解锁
            </t-link>
            <t-popconfirm content="确认删除吗" @confirm="deleteRow(row.id)">
              <t-link v-perms="['adminapi/merchant/user/del']" theme="danger" hover="color">
                <t-icon name="delete" />
                删除
              </t-link>
            </t-popconfirm>
            <template #separator>
              <t-divider layout="vertical" />
            </template>
          </t-space>
        </div>
      </template>
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" variant="light" theme="success">启用</t-tag>
        <t-tag v-else variant="light" theme="danger">禁用</t-tag>
      </template>

      <template #is_freeze="{ row }">
        <t-tag v-if="row.is_freeze === 1" variant="light" theme="danger">是</t-tag>
        <t-tag v-else variant="light" theme="success">否</t-tag>
      </template>

      <template #operate="{ row }">
        <t-space>
          <t-link theme="primary" size="small" @click="detailRow(row)">详情</t-link>
          <t-link theme="primary" size="small" @click="operateRow(row.id)">操作</t-link>
        </t-space>
      </template>
    </t-table>
    <edit-popup ref="editRef" @success="fetchData" />
    <money-popup ref="moneyRef" @success="fetchData" />
    <message-popup ref="messageRef" />
    <role-popup ref="roleRef" />
    <rate-popup ref="rateRef" />
    <collect-popup ref="collectRef" />
    <detail-popup ref="detailRef" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { del, list, unlock } from '@/api/admin/merchant/user';
import { table } from '@/hooks/table';

import CollectPopup from './components/collect.vue';
import { columns } from './components/constant';
import DetailPopup from './components/detail.vue';
import EditPopup from './components/edit.vue';
import MessagePopup from './components/message.vue';
import MoneyPopup from './components/money.vue';
import RatePopup from './components/rate.vue';
import RolePopup from './components/role.vue';
import RowSearch from './components/row-search.vue';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
});
fetchData();

const detailRef = ref<InstanceType<typeof DetailPopup>>();
const detailRow = (id: number) => {
  detailRef.value?.init(id);
};
const unlockRow = async (id: number) => {
  const res = await unlock({
    user_id: id,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
const collectRef = ref<InstanceType<typeof CollectPopup>>();
const collectRow = (id: number) => {
  collectRef.value?.init(id);
};
const rateRef = ref<InstanceType<typeof RatePopup>>();
const rateRow = (row: any) => {
  rateRef.value?.init(row);
};

const roleRef = ref<InstanceType<typeof RolePopup>>();
const roleRow = (id: number) => {
  roleRef.value?.init(id);
};

const moneyRef = ref<InstanceType<typeof MoneyPopup>>();
const moneyRow = (id: number) => {
  moneyRef.value?.init(id);
};
const expandedRowKeys = ref(['']);
const operateRow = (id: any) => {
  // 如果expandedRowKeys中已经存在id，则删除 -- 折叠效果
  if (expandedRowKeys.value.includes(id)) {
    expandedRowKeys.value = [];
  } else {
    expandedRowKeys.value = [id];
  }
};
const messageRef = ref<InstanceType<typeof MessagePopup>>();
const messageRow = (id: number) => {
  messageRef.value?.init(id);
};
// 搜索
const params = reactive<any>({});
const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};

const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (id: number) => {
  editRef.value?.init(id);
};
const deleteRow = async (id: number) => {
  const res = await del({
    id,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>

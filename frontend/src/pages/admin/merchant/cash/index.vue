<template>
  <div class="basic-container">
    <div style="padding: 15px">
      <t-space v-perms="['adminapi/merchant/cash/cashCount']">
        <t-descriptions title="统计面板" bordered :column="column" item-layout="vertical" layout="horizontal">
          <t-descriptions-item v-for="(item, index) in cashCountData" :key="index" :label="item.name">{{ item.value }}</t-descriptions-item>
        </t-descriptions>
        <t-descriptions title="提示帮助" bordered :column="column" item-layout="vertical" layout="horizontal">
          <t-descriptions-item label="在服务器面板里创建计划任务">
            <t-button
              size="small"
              variant="outline"
              theme="primary"
              @click="
                () => {
                  copyText('php webman unfreeze:money');
                }
              "
              >全自动解冻用户资金</t-button
            >
            <t-button
              size="small"
              variant="outline"
              theme="primary"
              @click="
                () => {
                  copyText('php webman auto:cash');
                }
              "
              >全自动创建结算信息</t-button
            >
            <t-button
              size="small"
              variant="outline"
              theme="primary"
              @click="
                () => {
                  copyText('php webman auto:daifu');
                }
              "
              >全自动结算打款命令</t-button
            >
          </t-descriptions-item>
        </t-descriptions>
      </t-space>
    </div>
    <t-card title="" :bordered="false">
      <search-popup @success="handelSearch" />
      <div class="category-header c-flex">
        <t-space align="baseline">
          <t-link hover="underline"> 打款站内信通知 已开启 </t-link>
          <t-link :theme="notifyData.cash_emailnotify_open ? 'primary' : 'danger'" @click="setConfig('cash_emailnotify_open')">
            打款邮件通知
            {{ notifyData.cash_emailnotify_open ? '已开启' : '已关闭' }}
          </t-link>
        </t-space>
        <div class="l">
          <t-button v-perms="['adminapi/merchant/cash/delBatch']" theme="default" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
          <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
        </div>
      </div>
      <t-table row-key="id" :data="lists" :columns="columns" :expand-on-row-click="false" :expanded-row-keys="expandedRowKeys" :expand-icon="false" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" :loading="dataLoading" max-height="100%" :selected-row-keys="selectedRowKeys" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
        <template #expandedRow="{ row }"> {{ row.collect_info }} </template>
        <template #operate="{ row }">
          <span v-if="row.status === 0">
            <t-space size="small">
              <t-link v-perms="['adminapi/merchant/cash/pass']" theme="primary" @click="passRow(row.id)">手工打款</t-link>
              <t-link v-perms="['adminapi/merchant/cash/autoPass']" theme="primary" @click="hadleAutoRow('autopass', row.id)">代付打款</t-link>
              <t-link v-perms="['adminapi/merchant/cash/refuse']" theme="danger" @click="refuseRow(row.id)">驳回</t-link>
            </t-space>
          </span>
          <span v-if="row.status === 1" v-perms="['adminapi/merchant/cash/del']">
            <t-link theme="danger" @click="deleteRow(row.id)">删除</t-link>
          </span>
        </template>
      </t-table>
    </t-card>
  </div>
</template>
<script setup lang="ts">
import { DialogPlugin, Input, MessagePlugin } from 'tdesign-vue-next';
import { h, reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';
import { autoPass, cashCount, del, delBatch, list, pass, refuse } from '@/api/admin/merchant/cash';
import { table } from '@/hooks/table';
import { copyText } from '@/utils/common';

import { columns } from './components/constant';
import SearchPopup from './components/search.vue';

const searchParams = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
  params: searchParams,
});
fetchData();

const handelSearch = (params: any) => {
  Object.assign(searchParams, params);
  fetchData();
};

const selectedRowKeys = ref<number[]>([]);
const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
// 批量删除
const batchDel = async () => {
  const confirmDia = DialogPlugin({
    header: '提醒',
    body: `是否确认删除？`,
    confirmBtn: '确认',
    onConfirm: () => {
      confirmDia.hide();
      const data = {
        ids: selectedRowKeys.value,
      };
      delBatch(data).then((res) => {
        if (res.code === 1) {
          fetchData();
          MessagePlugin.success(res.msg);
          selectedRowKeys.value = [];
        } else {
          MessagePlugin.error(res.msg);
        }
      });
    },
    onClose: () => {
      confirmDia.hide();
    },
  });
};
const column = ref(5);
interface cashCountDataInter {
  name: string;
  value: string;
}
const cashCountData = ref<cashCountDataInter[]>([]);
const initCashCount = async () => {
  const { data } = await cashCount();
  cashCountData.value = data;
};
initCashCount();

fetchData();

const expandedRowKeys = ref(['']);

const passRow = async (id: any) => {
  // 如果expandedRowKeys中已经存在id，则删除 -- 折叠效果
  if (expandedRowKeys.value.includes(id)) {
    expandedRowKeys.value = [];
  } else {
    expandedRowKeys.value = [id];
  }
  // 提示是否确认打款
  const confirmDialog = DialogPlugin.confirm({
    header: '是否确认打款',
    body: '是否确认提交？',
    confirmBtn: {
      content: '提交',
      theme: 'primary',
      loading: false,
    },
    theme: 'warning',
    onConfirm: () => {
      confirmDialog.update({ confirmBtn: { content: '提交中', loading: true } });
      pass({ id }).then((res) => {
        if (res.code === 1) {
          MessagePlugin.success(res.msg);
          confirmDialog.hide();
          fetchData();
        } else {
          MessagePlugin.error(res.msg);
        }
      });
    },
  });
};
const reason = ref('');
const refuseRow = async (id: number) => {
  // 提示是否确认打款
  const confirmDialog = DialogPlugin.confirm({
    header: '请输入驳回原因',
    body: () =>
      h(Input, {
        onInput: (event: any) => {
          reason.value = event.target.value;
        },
        placeholder: '请输入驳回原因',
      }),
    confirmBtn: {
      content: '提交',
      theme: 'primary',
      loading: false,
    },
    onConfirm: () => {
      confirmDialog.update({ confirmBtn: { content: '提交中', loading: true } });
      refuse({
        id,
        reason: reason.value,
      }).then((res) => {
        if (res.code === 1) {
          MessagePlugin.success(res.msg);
          reason.value = '';
          confirmDialog.hide();
          fetchData();
        } else {
          MessagePlugin.error(res.msg);
        }
      });
    },
  });
};
const hadleAutoRow = async (type: string, id: number) => {
  // 提示是否确认打款
  const confirmDialog = DialogPlugin.confirm({
    header: '是否确认全自动打款',
    body: '是否确认提交？',
    confirmBtn: {
      content: '提交',
      theme: 'primary',
      loading: false,
    },
    theme: 'warning',
    onConfirm: () => {
      confirmDialog.update({ confirmBtn: { content: '提交中', loading: true } });
      autoPass({ id, type }).then((res) => {
        if (res.code === 1) {
          MessagePlugin.success(res.msg);
          confirmDialog.hide();
          fetchData();
        } else {
          MessagePlugin.error(res.msg);
        }
      });
    },
  });
};

const deleteRow = async (id: number) => {
  const res = await del({ id });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};

const notifyData = reactive({
  cash_weixinnotify_open: 0,
  cash_emailnotify_open: 0,
});
// 获取配置
const fetchConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(notifyData),
  });
  for (const key in data) {
    // @ts-ignore
    notifyData[key] = data[key];
  }
};
fetchConfig();
const setConfig = async (name: any) => {
  // 复制notifyData
  const postNotifyData = JSON.parse(JSON.stringify(notifyData));
  // @ts-ignore
  postNotifyData[name] = postNotifyData[name] === 1 ? 0 : 1;
  const res = await editConfig({
    // postNotifyData的项值 需要取反
    data: {
      ...postNotifyData,
    },
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchConfig();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>
<style lang="less" scoped>
.selected-count {
  display: inline-block;
  margin-left: 8px;
  color: var(--td-text-color-secondary);
}
</style>

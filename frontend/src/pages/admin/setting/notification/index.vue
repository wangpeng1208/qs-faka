<template>
  <t-card title="通知场景" class="basic-container" :bordered="false">
    <t-table size="small" :data="lists" :columns="columns" row-key="id" vertical-align="middle" :loading="dataLoading" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" @page-change="rehandlePageChange">
      <template #topContent>
        <t-space style="margin: 15px 0">
          <t-button theme="primary" @click="rowAdd()">新增</t-button>
        </t-space>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link theme="primary" @click="rowEdit(row)">编辑</t-link>
          <t-link theme="danger" @click="rowDel(row)">删除</t-link>
        </t-space>
      </template>
      <!-- <template #bottomContent>
        <t-alert style="margin: 15px 0">
          <div>使用说明 ：</div>
          <div>短信：(new app\service\sms\SmsService())->send(通知标识, 手机号, 短信参数['code' => $code])</div>
          <div>
            示例：$result = (new app\service\sms\SmsService())->send('verify_code', '13800000000', ['code' => $code])
            <br />
            需要验证短信必须达到的话 判断 $result的返回值，使用$result->getErrorMessage()获取错误
          </div>
        </t-alert>
      </template> -->
    </t-table>
    <t-dialog v-model:visible="smsDialogVisible" header="短信配置" :on-confirm="smsOnSubmit">
      <t-form>
        <t-form-item label="状态">
          <t-radio-group
            v-model="smsData.status"
            :options="[
              { label: '开启', value: 1 },
              { label: '关闭', value: 0 },
            ]"
          />
        </t-form-item>
        <t-form-item label="短信平台">
          <t-select v-model="smsData.sms_gateway" clearable placeholder="请选择短信模板" :options="smsTypeListOptions" />
        </t-form-item>
        <t-form-item label="模板ID">
          <t-input v-model="smsData.sms_template_id" clearable placeholder="请输入短信模板ID" />
        </t-form-item>
        <t-form-item label="短信内容" help="复制短信内容到对应平台">
          <t-textarea v-model="smsData.sms_template_content" clearable />
        </t-form-item>
      </t-form>
    </t-dialog>
    <t-dialog v-model:visible="dialogVisible" :header="header" :on-confirm="rowSubmit">
      <t-form>
        <t-form-item label="短信通知">
          <t-radio-group
            v-model="rowData.is_sms"
            :options="[
              { label: '开启', value: 1 },
              { label: '关闭', value: 0 },
            ]"
          />
        </t-form-item>
        <t-form-item label="通知名称">
          <t-input v-model="rowData.name" clearable placeholder="请输入通知场景名称" />
        </t-form-item>
        <t-form-item label="通知说明">
          <t-input v-model="rowData.title" clearable placeholder="请输入通知场景说明" />
        </t-form-item>
        <t-form-item label="通知标识">
          <t-input v-model="rowData.mark" clearable placeholder="请输入通知标识" />
        </t-form-item>
      </t-form>
    </t-dialog>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'SystemNotificationIndex',
};
</script>

<script setup lang="ts">
import { Button, MessagePlugin, PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { add, del, edit, list, setSmsConfig } from '@/api/admin/system/notification';
import { list as smsTypeList } from '@/api/admin/system/sms';
import { table } from '@/hooks/table';

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    title: 'ID',
    colKey: 'id',
    width: 50,
  },
  {
    title: '通知名称',
    colKey: 'name',
  },
  {
    title: '通知标识',
    colKey: 'mark',
  },
  {
    title: '短信通知',
    colKey: 'is_sms',
    width: 180,
    cell: (h, { row }) => {
      const tag = h(
        Button,
        {
          size: 'small',
          theme: row.is_sms === 1 ? 'success' : 'danger',
        },
        () => {
          return row.is_sms === 1 ? '开启' : '禁用';
        },
      );

      const button = h(
        Button,
        {
          theme: 'primary',
          size: 'small',
          style: 'margin-left: 10px',
          // icon: (h as any)(Icon, { name: 'edit' }),
          onClick: () => {
            smsDialogConfig(row);
          },
        },
        () => {
          return '编辑配置';
        },
      );
      return [tag, button];
    },
  },
  // 操作
  {
    title: '操作',
    colKey: 'operate',
    width: 100,
  },
];

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();

// 短信配置
const smsData = reactive({} as Record<string, string>);
const smsDialogVisible = ref(false);
// 编辑短信配置
const smsDialogConfig = async (row: any) => {
  // 清空数据
  Object.keys(smsData).forEach((key) => {
    delete smsData[key];
  });
  // 初始化短信平台列表
  initsmsTypeListOptions();
  smsData.id = row.id;
  smsData.status = row.is_sms;
  smsDialogVisible.value = true;
  Object.assign(smsData, { ...row.sms_config });
};
// 短信平台列表
const smsTypeListOptions = ref([]);
const initsmsTypeListOptions = async () => {
  smsTypeListOptions.value = (await smsTypeList({})).data.list ?? [];
};
const smsOnSubmit = async () => {
  const res = await setSmsConfig({
    data: smsData,
  });
  if (res.code === 1) {
    MessagePlugin.success('操作成功');
    smsDialogVisible.value = false;
    fetchData();
  } else {
    MessagePlugin.error(`${res.msg}`);
  }
};

const opt = ref('add');
const header = ref('新增配置');
const rowData = reactive({} as Record<string, string>);
const dialogVisible = ref(false);
const rowEdit = (row: any) => {
  opt.value = 'edit';
  header.value = '编辑配置';
  dialogVisible.value = true;
  Object.assign(rowData, { ...row });
};
const rowAdd = () => {
  opt.value = 'add';
  header.value = '新增配置';
  dialogVisible.value = true;
  Object.keys(rowData).forEach((key) => {
    delete rowData[key];
  });
};
const rowDel = async (row: any) => {
  const res = await del({
    id: row.id,
  });
  if (res.code === 1) {
    MessagePlugin.success('操作成功');
    fetchData();
  } else {
    MessagePlugin.error(`${res.msg}`);
  }
};
const rowSubmit = async () => {
  const res =
    opt.value === 'add'
      ? await add({
          data: rowData,
        })
      : await edit({
          data: rowData,
        });
  if (res.code === 1) {
    MessagePlugin.success('操作成功');
    dialogVisible.value = false;
    fetchData();
  } else {
    MessagePlugin.error(`${res.msg}`);
  }
};
</script>

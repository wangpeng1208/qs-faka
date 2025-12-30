<template>
  <t-card :title="pageName" class="basic-container" :bordered="false">
    <div class="table-header">
      <t-button theme="default" @click="toggleExpandAll">{{ expandAll ? '收起全部' : '展开全部' }}</t-button>
      <t-button v-perms="['adminapi/merchant/menu/add']" theme="primary" @click="editRow()">添加</t-button>
    </div>
    <t-enhanced-table ref="tableRef" v-model:expanded-tree-nodes="expandedTreeNodes" row-key="id" :data="lists" :columns="columns" :tree="treeConfig" :hover="lists.length > 0 ? true : false" max-height="auto" table-layout="auto" :header-affixed-top="headerAffixedTop" :tree-expand-and-fold-icon="treeExpandIcon" lazy-load>
      <template #icon="{ row }">
        <img v-if="row.icon && (row.icon.startsWith('http') || row.icon.startsWith('/'))" :src="getImgUrl(row.icon)" :style="{ marginRight: '8px', maxWidth: '24px' }" />
        <icon-font v-else :name="`t-icon t-icon-${row.icon}`" :url="CDN_CSS" />
      </template>
      <template #hidden="{ row }">
        <t-tag v-if="row.hidden == 1" theme="danger" variant="outline">隐藏</t-tag>
        <t-tag v-else theme="success" variant="outline">显示</t-tag>
      </template>
      <!-- type -->
      <template #type="{ row }">
        <t-tag v-if="row.type == 'L'" theme="success" variant="outline">目录</t-tag>
        <t-tag v-else-if="row.type == 'M'" theme="primary" variant="outline">菜单</t-tag>
        <t-tag v-else-if="row.type == 'B'" theme="warning" variant="outline">按钮</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/merchant/menu/add']" theme="primary" hover="color" size="small" @click="editRow(0, row.id)">添加</t-link>
          <t-link v-perms="['adminapi/merchant/menu/edit']" theme="primary" hover="color" size="small" @click="editRow(row.id)">编辑</t-link>
          <t-popconfirm content="确认删除吗" @confirm="deleteRow(row.id)">
            <t-link v-perms="['adminapi/merchant/menu/del']" theme="danger" hover="color" size="small"> 删除 </t-link>
          </t-popconfirm>
        </t-space>
      </template>
    </t-enhanced-table>
    <admin-menu-edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts" name="MerchantMenuIndex">
import { ChevronDownIcon, ChevronRightIcon, IconFont } from 'tdesign-icons-vue-next';
import { MessagePlugin } from 'tdesign-vue-next';
// getCurrentInstance 用于获取当前组件实例；nextTick 用于在下次 DOM 更新循环结束之后执行延迟回调
import { computed, nextTick, reactive, ref } from 'vue';

import { del, list } from '@/api/admin/merchant/menu';
import { prefix } from '@/config/global';
import { usePageName } from '@/hooks/usePageName';
import { useSettingStore } from '@/store';
import { getImgUrl } from '@/utils/common';

import { columns } from './components/constant';
import AdminMenuEditPopup from './components/edit.vue';

const pageName = usePageName();
const CDN_CSS = 'https://tdesign.gtimg.com/icon/0.4.0/fonts/index.css';
const expandedTreeNodes = ref([]);
// 自定义树形展开图标
const treeExpandAndFoldIconRender = (h: any, { type }: any) => {
  return type === 'expand' ? h(ChevronRightIcon) : h(ChevronDownIcon);
};
const treeExpandIcon = computed(() => {
  return treeExpandAndFoldIconRender;
});
// 结构收起全部/展开全部
const tableRef = ref(null);
const expandAll = ref(false);
function toggleExpandAll() {
  expandAll.value = !expandAll.value;
  refreshExpandAll();
}
const refreshExpandAll = async () => {
  await nextTick();
  if (expandAll.value) {
    tableRef.value.expandAll();
  } else {
    tableRef.value.foldAll();
  }
};

// 表格数据
const lists = ref([]);
const fetchData = async () => {
  const res = await list({});
  if (res.code) {
    lists.value = res.data.list;
  } else {
    MessagePlugin.error(res.msg);
  }
};
fetchData();

const treeConfig = reactive({
  childrenKey: 'children',
  treeNodeColumnIndex: 0,
  indent: 25,
  expandTreeNodeOnClick: false,
});

// 编辑/添加
const editRef = ref();
const editRow = (id = 0, pid = 0) => {
  editRef.value?.init(id, pid);
};
const deleteRow = async (id: number) => {
  const { msg } = await del({ id });
  MessagePlugin.success(msg);
  fetchData();
};
// 表头吸顶
const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
<style lang="less" scoped>
.table-header {
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
</style>

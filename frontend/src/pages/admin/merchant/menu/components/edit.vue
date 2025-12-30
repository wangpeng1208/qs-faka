<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :on-confirm="onSubmit" confirm-on-enter width="500">
    <template #header>
      <div class="dialog-title">{{ title }}</div>
    </template>
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80" @submit="onSubmit">
      <!-- 类型 目录 L 菜单 M 按钮 B -->
      <t-form-item label="菜单类型" name="type">
        <t-radio-group v-model="formData.type" :options="typeOptions" />
      </t-form-item>
      <t-form-item label="父级菜单" name="pid">
        <t-tree-select v-model="formData.pid" placeholder="请选择父级菜单" :data="menuOptions" clearable filterable @change="formDataPidChange" />
      </t-form-item>
      <t-form-item label="菜单名称" name="title">
        <t-input v-model="formData.title" clearable placeholder="请输入菜单名称" />
      </t-form-item>
      <icon-page ref="iconSearchRef" @success="onUserSearchSuccess" />
      <t-form-item v-if="formData.type === 'L' || formData.type === 'M'" label="菜单图标" name="icon">
        <t-input v-model="formData.icon" clearable placeholder="请选择菜单图标">
          <template #prefix-icon>
            <img v-if="formData.icon.startsWith('http') || formData.icon.startsWith('/')" :src="getImgUrl(formData.icon)" :style="{ marginRight: '8px', maxWidth: '24px' }" />
            <icon-font v-else :name="`t-icon t-icon-${formData.icon}`" :url="CDN_CSS" style="margin-right: 8px" />
          </template>
        </t-input>
        <t-button theme="primary" @click="showIconPage">选择图标</t-button>
      </t-form-item>
      <t-form-item v-if="formData.type === 'L' || formData.type === 'M'" label="路由路径" name="path" help="访问的路由地址，如：`user`">
        <t-input v-model="formData.path" clearable placeholder="请输入路由路径" />
      </t-form-item>
      <t-form-item v-if="formData.type === 'M'" label="组件路径" name="component" help="组件路径，如：`user/setting/index`，默认在`pages`目录下" tips="此处支持下拉和模糊搜索；外链使用Iframe,跳转路径为外链地址">
        <t-auto-complete v-model="formData.component" :options="componentsOptions" clearable highlight-keyword filterable placeholder="请输入组件地址组件" />
      </t-form-item>
      <!-- 权限字符 -->
      <t-form-item v-if="formData.type === 'M' || formData.type === 'B'" label="权限字符" name="perms" help="将作为server端API验权使用，跟该方法路径一致" tips="应用+api+路径,例如：adminapi/setting/socialite/list">
        <t-input v-model="formData.perms" clearable placeholder="请输入权限字符" />
      </t-form-item>
      <t-form-item label="菜单排序" name="sort" help="数值越小越排前">
        <t-input-number v-model="formData.orderNo" clearable placeholder="请输入排序" :style="{ width: '500px' }" theme="column" :min="0" />
      </t-form-item>
      <!-- 是否缓存 -->
      <t-form-item v-if="formData.type === 'L' || formData.type === 'M'" label="是否缓存" name="cache" help="开启缓存后，页面切换时不会重新加载">
        <t-radio-group v-model="formData.keep_alive" :options="keepAliveOptions" />
      </t-form-item>
      <t-form-item v-if="formData.type === 'L' || formData.type === 'M'" label="是否隐藏" name="hidden" help="选择隐藏则路由将不会出现在侧边栏，但仍然可以访问">
        <t-radio-group v-model="formData.hidden" :options="isHiddenOptions" />
      </t-form-item>
      <t-form-item v-if="formData.type === 'L' || formData.type === 'M'" label="跳转路径" name="redirect" help="分割菜单的时候用到">
        <t-input v-model="formData.redirect" clearable placeholder="顶级栏目需要输入跳转路径" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>
<script setup lang="ts" name="MerchantMenuEdit">
import { IconFont } from 'tdesign-icons-vue-next';
import type { FormRule } from 'tdesign-vue-next';
import { MessagePlugin } from 'tdesign-vue-next';
import type { TreeSelectValue } from 'tdesign-vue-next/es/tree-select/type';
import { reactive, ref } from 'vue';

import { add, detail, edit, menuTreeSimple } from '@/api/admin/merchant/menu';
import { getImgUrl } from '@/utils/common';

import { componentsOptions, isHiddenOptions, keepAliveOptions, typeOptions } from './constant';
import IconPage from './icon.vue';

const emit = defineEmits(['success']);

const CDN_CSS = 'https://tdesign.gtimg.com/icon/0.4.0/fonts/index.css';

const iconSearchRef = ref();
const showIconPage = () => {
  iconSearchRef.value.init(formData.icon);
};

const onUserSearchSuccess = (icon: string) => {
  formData.icon = icon;
};

const DATA = {
  id: 0,
  pid: 0,
  app: 'merchant',
  title: '',
  path: '',
  icon: '',
  component: '',
  type: 'M',
  orderNo: 0,
  hidden: 0,
  redirect: '',
  perms: '',
  keep_alive: 0,
};
const formData = reactive({ ...DATA });

const menuOptions = ref([]);

const initMenuOptions = async () => {
  const { data } = await menuTreeSimple({
    app: 'merchant',
  });
  menuOptions.value = data.list;
};
const formRef = ref(null);
const visible = ref(false);
const title = ref('添加菜单');
const init = (id: number, pid: number) => {
  if (id) {
    title.value = '编辑菜单';
    getDetail(id);
  } else {
    title.value = '添加菜单';
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
    }
    if (pid) {
      formData.pid = pid;
    }
  }

  visible.value = true;
  initMenuOptions();
};

const getDetail = async (id: number) => {
  const { data } = await detail({ id });
  for (const key in formData) {
    if (data[key] != null && data[key] !== undefined) {
      // @ts-ignore
      formData[key] = data[key];
    }
  }
};

defineExpose({
  init,
});
// 顶级菜单的时候，组件默认为Layout
const formDataPidChange = (val: TreeSelectValue) => {
  formData.component = val === 0 ? 'Layout' : '';
};
// 表单验证规则
const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '必填', type: 'error' }],
  title: [{ required: true, message: '必填', type: 'error' }],
};
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    let res;
    if (formData.id === 0) {
      res = await add(formData);
    } else {
      res = await edit(formData);
    }
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      visible.value = false;
      emit('success');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
<!-- eslint-disable vue-scoped-css/enforce-style-type -->
<style lang="less">
// icon内联样式
.overlay-options {
  display: inline-block;
  font-size: 50px;
}
</style>

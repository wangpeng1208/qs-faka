<template>
  <t-dialog v-model:visible="visible" :loading="loading" :destroy-on-close="true" :close-on-overlay-click="true" header="导出优惠券" :on-confirm="exportCoupon">
    <t-form label-align="left">
      <t-form-item label="商品分类" name="cate_id">
        <t-select v-model="dumpFormCoupon.cate_id" placeholder="请选择分类" help="不选择时则表示全部分类" :options="cateList"> </t-select>
      </t-form-item>
      <t-form-item label="使用状态" name="status">
        <t-radio-group v-model="dumpFormCoupon.status">
          <t-radio value="1">暂未使用</t-radio>
          <t-radio value="2">已经使用</t-radio>
        </t-radio-group>
      </t-form-item>
      <t-form-item label="导出范围" name="range">
        <t-radio-group v-model="dumpFormCoupon.range">
          <t-radio value="0">全部库存</t-radio>
          <t-radio value="1">导出数量</t-radio>
        </t-radio-group>
      </t-form-item>
      <t-form-item v-if="dumpFormCoupon.range == '1'" label="导出数量" name="number">
        <t-input v-model="dumpFormCoupon.number" />
      </t-form-item>
      <t-form-item label="导出格式" name="file_type">
        <t-radio-group
          v-model="dumpFormCoupon.file_type"
          :options="[
            { label: 'Excel格式', value: 2 },
            { label: 'TXT格式', value: 1 },
          ]"
        />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'ExportCoupon',
};
</script>

<script lang="ts" setup>
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { listSimple } from '@/api/merchant/goods/category';
import { dumpcoupon } from '@/api/merchant/goods/coupon';
import { downloadFile } from '@/utils/common';

// 导出优惠券
const dumpFormCoupon = reactive({
  cate_id: 0,
  status: '1',
  range: '0',
  file_type: 2,
  number: '',
});

const loading = ref(true);
const visible = ref(false);
const exportCoupon = async () => {
  const data = {
    ...dumpFormCoupon,
  };
  const res = await dumpcoupon(data);
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    visible.value = false;
    downloadFile(res.data.url);
  }
};

// 商品分类加载
const cateList = ref([]);
const initGoodsCategory = async () => {
  const { data } = await listSimple();
  // data.list 添加 全部分类
  data.list.unshift({
    value: 0,
    label: '全部分类',
  });
  cateList.value = data.list;
};
initGoodsCategory();
const init = () => {
  visible.value = true;
};
defineExpose({
  init,
});
</script>

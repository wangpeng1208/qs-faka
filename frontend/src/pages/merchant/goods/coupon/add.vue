<template>
  <t-card title="添加优惠券" class="basic-container" :bordered="false">
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/goods/coupon')">
        <template #icon><t-icon name="rollback" /></template>
        返回
      </t-button>
    </template>
    <t-form ref="form" class="base-form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="160" @submit="onSubmit">
      <t-form-item label="选择分类" name="cate_id" help="【必选】请选择商品分类">
        <t-select v-model="formData.cate_id" placeholder="请选择商品分类" type="search" clearable :options="cateList" style="width: 415px" />
      </t-form-item>

      <t-form-item label="折扣面额" name="amount" :help="amountHelp">
        <t-space>
          <t-input-number v-model="formData.amount" :decimal-places="0" theme="normal" placeholder="请输入数字" style="width: 415px" />
          <t-radio-group v-model="formData.type" :options="importType" />
        </t-space>
      </t-form-item>

      <t-form-item label="生成数量" name="quantity" help="最多一次生成200张">
        <t-input-number v-model="formData.quantity" :max="200" :min="1" :decimal-places="0" theme="normal" />
      </t-form-item>

      <t-form-item label="最低使用金额" name="min_banlance" help="此功能为满减优惠卷">
        <t-input-number v-model="formData.min_banlance" placeholder="请输入数字" :decimal-places="0" theme="normal" />
      </t-form-item>

      <t-form-item label="到期时间" name="expire_at" help="过期优惠券系统将自动清理">
        <t-date-picker v-model="formData.expire_at" enable-time-picker allow-input clearable placeholder="请选择到期时间" />
      </t-form-item>

      <t-form-item label="备注信息" name="remark">
        <t-textarea v-model="formData.remark" placeholder="" :style="{ width: '415' }" />
      </t-form-item>

      <t-form-item label="导出格式" name="import_coupon" help="添加完导出优惠券">
        <wp-check-tag v-model="formData.import_coupon" :items="importCoupon" />
      </t-form-item>
      <t-form-item>
        <t-button theme="primary" class="form-submit-confirm" type="submit"> 提交 </t-button>
        <t-button type="reset" class="form-submit-cancel" theme="default" variant="base"> 重置 </t-button>
      </t-form-item>
    </t-form>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'GoodsCouponAdd',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';

import { listSimple } from '@/api/merchant/goods/category';
import { add } from '@/api/merchant/goods/coupon';
import { downloadFile } from '@/utils/common';

import { importCoupon, importType } from './components/constant';

const router = useRouter();

const formData = ref({
  cate_id: '',
  type: 1,
  amount: '',
  quantity: '',
  min_banlance: '',
  expire_at: '',
  remark: '',
  import_coupon: 0,
});

const amountHelp = ref('满减优惠券，设置多少元则抵扣总价的多少元');
watch(
  () => formData.value.type,
  (val) => {
    if (val === 1) {
      amountHelp.value = `
      满减优惠券，设置多少元则抵扣总价的多少元
      `;
    } else {
      amountHelp.value = `
      折扣卡券，设置比例10%则是9折20%为8折，以此类推
      `;
    }
  },
);

const cateList = ref([]);
const initCateList = async () => {
  const { data } = await listSimple();
  cateList.value = data.list;
  cateList.value.unshift({ label: '店铺通用', value: '' });
};
const form = ref(null);
const FORM_RULES: Record<string, FormRule[]> = {
  amount: [{ required: true, message: '请输入折扣面额', type: 'error' }],
  quantity: [{ required: true, message: '请输入数量', type: 'error' }],
  expire_at: [{ required: true, message: '请选择到期时间', type: 'error' }],
};

onMounted(() => {
  initCateList();
  const { query } = router.currentRoute.value as any;
  if (query.cate_id) {
    // 默认选中对应的商品
    formData.value.cate_id = query.cate_id;
  }
});
const onSubmit = async () => {
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    const res = await add(formData.value);
    if (res.code === 1) {
      MessagePlugin.success('新增成功');
      if (formData.value.import_coupon) {
        downloadFile(res.data.url);
      }
      setTimeout(() => {
        router.push('/merchant/goods/coupon');
      }, 3000);
    } else {
      MessagePlugin.error(`新增失败：${res.msg}`);
    }
  }
};
</script>

<style lang="less" scoped>
:deep(.t-input__help) {
  font-size: 11px;
  color: rgb(153, 153, 153);
  margin: 11px 0;
}
:deep(.t-textarea),
:deep(.t-input) {
  width: 415px;
}
</style>

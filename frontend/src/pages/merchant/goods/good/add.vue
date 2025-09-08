<template>
  <t-card :title="title" class="basic-container" :bordered="false">
    <t-form ref="form" class="base-form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="150" scroll-to-first-error="smooth" status-icon @submit="onSubmit">
      <t-form-item label="商品分类" name="cate_id">
        <t-select v-model="formData.cate_id" placeholder="请选择商品分类" size="medium" :style="{ width: '600px' }" :options="goodsCategory" />
      </t-form-item>
      <t-form-item label="商品名称" name="name" tips="输入商品名称，长度需在2-20位之间">
        <t-input v-model="formData.name" :maxlength="20" show-limit-number placeholder="请输入商品名称" size="medium" :style="{ width: '600px' }" />
      </t-form-item>
      <t-form-item label="销售价格" name="price" tips="必填，输入销售价格，范围在0.1-20000">
        <t-input-adornment append="元">
          <t-input-number v-model="formData.price" :max="20000" :min="0.1" :decimal-places="2" placeholder="请输入销售价格" theme="normal" size="medium" />
        </t-input-adornment>
      </t-form-item>
      <t-form-item label="成本价格" name="cost_price" tips="商品成本价不可高于商品价格！（成本价，方便统计）">
        <t-input-adornment append="元">
          <t-input-number v-model="formData.cost_price" :decimal-places="2" placeholder="请输入成本价" theme="normal" size="medium" />
        </t-input-adornment>
      </t-form-item>

      <t-form-item label="限购设置" name="event_give" tips="0表示不限制购买数量">
        <t-space>
          <t-input-number v-model="formData.limit_quantity" theme="normal" align="center" label="最少购买" suffix="件" placeholder="请输入最少购买数量" :style="{ width: '292px' }" size="medium"></t-input-number>
          <t-input-number v-model="formData.limit_quantity_max" theme="normal" align="center" label="最多购买" suffix="件" placeholder="请输入最多购买数量" :style="{ width: '292px' }" size="medium"></t-input-number>
        </t-space>
      </t-form-item>
      <t-form-item label="优惠券" name="coupon_type" tips="选择开启则表示该商品可以使用优惠券">
        <wp-check-tag v-model="formData.coupon_type" :items="TRUEFALSESWITCH" />
      </t-form-item>
      <t-form-item label="活动赠送" name="event_give" tips="">
        <wp-check-tag v-model="formData.event_give" :items="TRUEFALSESWITCH" @actions="addEventGiveNumber" />
      </t-form-item>
      <t-form-item v-if="formData.event_give.length" label="" name="event_give">
        <t-space direction="vertical">
          <div v-for="(item, i) in formData.event_give" :key="i">
            <t-space>
              <t-input-number v-model="item.num" theme="normal" align="center" label="买满：" suffix="件" placeholder="请输入买满数量" :style="{ width: '292px' }"></t-input-number>
              <t-input-number v-model="item.give_num" theme="normal" align="center" label="赠送：" suffix="件" placeholder="请输入赠送数量" :style="{ width: '292px' }"></t-input-number>
              <t-button theme="danger" variant="outline" @click="deleteEventGiveNumber(i)">删除</t-button>
              <t-button v-if="formData.event_give.length" variant="outline" theme="primary" @click="addEventGiveNumber(1)"> 添加 </t-button>
            </t-space>
          </div>
        </t-space>
      </t-form-item>
      <t-form-item label="附加赠送" name="addtion_give" tips="">
        <wp-check-tag v-model="formData.addtion_give" :items="TRUEFALSESWITCH" @actions="addtionGiveNumber" />
      </t-form-item>
      <t-form-item v-if="formData.addtion_give.length" label="" name="addtion_give" tips="若编辑（B商品，2,1）意思为买2个当前商品送B商品1个">
        <t-space v-if="formData.addtion_give.length" direction="vertical">
          <div v-for="(item, i) in formData.addtion_give" :key="i">
            <t-space>
              <t-select v-model="item.good_id" :style="{ width: '292px' }" placeholder="请选择商品">
                <t-option v-for="(val, key) in goosList" :key="key" :value="val.id" :label="val.name" />
              </t-select>
              <t-input v-model="item.bug_num" placeholder="请输入购买数量" type="number" theme="normal" :decimal-places="false" :min="1" :style="{ width: '138px' }" />
              <t-input v-model="item.give_num" placeholder="请输入赠送数量" type="number" theme="normal" :decimal-places="false" :min="1" :style="{ width: '138px' }" />
              <t-button theme="danger" variant="outline" @click="deleteAddtionGiveNumber(i)">删除</t-button>
              <t-button v-if="formData.addtion_give.length" variant="outline" theme="primary" @click="addtionGiveNumber(1)"> 添加 </t-button>
            </t-space>
          </div>
        </t-space>
      </t-form-item>
      <!-- 批发优惠 -->
      <t-form-item label="批发优惠" name="wholesale_discount_list" tips="">
        <wp-check-tag v-model="formData.wholesale_discount_list" :items="TRUEFALSESWITCH" @actions="addWholesaleNumber" />
      </t-form-item>
      <t-form-item v-if="formData.wholesale_discount_list.length" label="" name="wholesale_discount_list">
        <t-space direction="vertical">
          <div v-for="(item, i) in formData.wholesale_discount_list" :key="i">
            <t-space>
              <t-input-number v-model="item.num" theme="normal" align="right" label="数量：" suffix="件" placeholder="请输入购买数量" :style="{ width: '290px' }"></t-input-number>
              <t-input-number v-model="item.price" theme="normal" align="right" label="价格：" suffix="元" placeholder="请输入价格" :style="{ width: '290px' }"></t-input-number>
              <t-button theme="danger" variant="outline" @click="deleteWholesaleNumber(i)">删除</t-button>
              <t-button v-if="formData.wholesale_discount_list.length" variant="outline" theme="primary" @click="addWholesaleNumber(1)"> 添加 </t-button>
            </t-space>
          </div>
        </t-space>
      </t-form-item>

      <t-form-item label="商品描述" name="content" tips="必填，商品描述会在买家选择商品时展示，建议写上您商品的简介，官网以及常见的问题" :style="{ width: '760px' }">
        <t-textarea v-model="formData.content" placeholder="商品描述会在买家选择商品时展示，建议写上您商品的简介，官网以及常见的问题，请保持在10-500字之间" size="medium" />
      </t-form-item>
      <t-form-item label="使用说明" name="remark" tips="必填，商品使用说明会在买家购买完成后展示，建议写上您的产品使用说明，售后联系方式等" :style="{ width: '760px' }">
        <t-textarea v-model="formData.remark" placeholder="请输入使用说明" size="medium" />
      </t-form-item>
      <div class="more-setting">
        <t-switch v-model="moreSetting" />
        <span class="more-sett-text">显示更多设置</span>
      </div>
      <div v-if="moreSetting" class="more-content">
        <t-form-item label="短信费用" name="sms_payer" tips="选择由买家或者商家承担平台服务费。默认买家承担">
          <t-radio-group v-model="formData.sms_payer" :options="SMSPAYER" />
        </t-form-item>
        <t-form-item label="售卡顺序" name="card_order">
          <t-radio-group v-model="formData.card_order" :options="CARDORDER" />
        </t-form-item>
        <!-- <t-form-item label="自助选号费" name="selectcard_fee">
        <t-input-number v-model="formData.selectcard_fee" theme="normal" placeholder="输入自助选号费用" :style="{ width: '600px' }"></t-input-number>
      </t-form-item> -->

        <t-form-item label="售出通知" name="sold_notify" tips="">
          <t-radio-group v-model="formData.sold_notify" :options="TRUEFALSESWITCH" />
        </t-form-item>

        <t-form-item v-if="formData.sold_notify" :span="8" label="通知方式" name="inventory_notify_type" tips="默认站内信通知，邮件和微信通知需要绑定对应关系" class="notify_type">
          <t-radio-group v-model="formData.inventory_notify_type" :options="INVENTORYNOTIFYTYPE" />
        </t-form-item>
        <t-form-item label="提货密码" name="take_card_type" tips="开启后，购买页面会提示买家填写取卡密码">
          <t-radio-group v-model="formData.take_card_type" :options="TAKECARDTYPE" />
        </t-form-item>
        <t-form-item label="联系方式" name="contact_limit" tips="">
          <t-radio-group v-model="formData.contact_limit" :options="CONTACTLIMIT" />
        </t-form-item>
        <t-form-item label="库存预警" name="inventory_notify" tips="设置后请确保邮箱正确，否则无法接收邮件">
          <t-radio-group v-model="formData.inventory_notify" :options="TRUEFALSESWITCH" />
        </t-form-item>

        <t-form-item label="商品排序" name="sort" tips=""> <t-input-number v-model="formData.sort" :min="0" theme="normal" placeholder="" :style="{ width: '600px' }" size="medium" /> </t-form-item>
      </div>
      <t-form-item>
        <t-button theme="primary" class="form-submit-confirm" type="submit"> 提交 </t-button>
        <t-button theme="default" class="form-submit-confirm" @click="onSubmit2"> 提交并返回至商品列表 </t-button>
      </t-form-item>
    </t-form>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'GoodsAdd',
};
</script>

<script setup lang="ts">
import { DialogPlugin, FormRule, MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { listSimple } from '@/api/merchant/goods/category';
import { add, detail, edit, goodList } from '@/api/merchant/goods/good';

import { CARDORDER, CONTACTLIMIT, INVENTORYNOTIFYTYPE, SMSPAYER, TAKECARDTYPE, TRUEFALSESWITCH } from './constant';

const router = useRouter();
const opt = ref('add');
const formData = ref({
  cate_id: '', // 分类id
  name: '', // 商品名
  price: '', // 商品价格
  event_give: [], // 活动赠送
  addtion_give: [], // 附加赠送
  sms_payer: 0, // 短信费承担者 1:商家 0:用户
  cost_price: '', // 成本价
  limit_quantity: '', // 起购数量
  limit_quantity_max: '', // 起购数量
  inventory_notify: 1, // 库存预警
  card_order: 0, // 售卡顺序
  selectcard_fee: '', // 自助选号费
  coupon_type: 0, // 优惠券
  sold_notify: 0, // 售出通知
  inventory_notify_type: 1, // 通知方式
  take_card_type: 0, // 提货密码
  contact_limit: 'mobile', //  客户信息
  content: '', // 商品说明
  remark: '', // 使用说明
  sort: '0',
  wholesale_discount: 0, // 批发优惠 取消 没有用了
  wholesale_discount_list: [],
  theme: 'default', // 风格
});
const goosList = ref([]);

const initGoods = async () => {
  const { data } = await goodList();
  if (router.currentRoute.value.query.id) {
    // 如果存在id，则过滤goosList中id等于此url携带id的数据
    // eslint-disable-next-line eqeqeq
    goosList.value = data.filter((item: any) => item.id != router.currentRoute.value.query.id);
  } else {
    goosList.value = data;
  }
};
const addtionGiveNumber = (value: number) => {
  // 商品数量 如果小于2，则不允许开启附加赠送
  if (value && goosList.value.length < 2) {
    MessagePlugin.warning('至少要有两个商品才能开启附加赠送');
    return;
  }
  if (value) {
    // 添加addtionGive数组中项目数据
    formData.value.addtion_give.push({
      good_id: '',
      bug_num: '',
      give_num: '',
    });
  } else {
    formData.value.addtion_give = [];
  }
};
// 附加赠送删除按钮
const deleteAddtionGiveNumber = (index: number) => {
  formData.value.addtion_give.splice(index, 1);
  if (formData.value.addtion_give.length === 0) {
    formData.value.addtion_give = [];
  }
};

// 活动赠送逻辑开始
const addEventGiveNumber = (value: number) => {
  if (value) {
    formData.value.event_give.push({
      num: '',
      give_num: '',
    });
  } else {
    formData.value.event_give = [];
  }
};
const deleteEventGiveNumber = (index: number) => {
  formData.value.event_give.splice(index, 1);
  // 如果活动赠送数量为0，则关闭活动赠送
  if (formData.value.event_give.length === 0) {
    formData.value.event_give = [];
  }
};
// 批发优惠逻辑开始
const addWholesaleNumber = (value: number) => {
  if (value) {
    formData.value.wholesale_discount_list.push({
      num: '',
      price: '',
    });
  } else {
    formData.value.wholesale_discount_list = [];
  }
};
// 批发优惠删除按钮
const deleteWholesaleNumber = (index: number) => {
  formData.value.wholesale_discount_list.splice(index, 1);
  // 如果批发优惠数量为0，则关闭批发优惠
  if (formData.value.wholesale_discount_list.length === 0) {
    formData.value.wholesale_discount = 0;
  }
};
const title = ref('添加商品');
const getGoods = async () => {
  if (router.currentRoute.value.query.id) {
    try {
      const { data } = await detail({
        id: router.currentRoute.value.query.id,
      });
      formData.value = { ...data };
      opt.value = 'edit';
      title.value = '编辑商品';
    } catch (e) {
      console.log(e);
    }
  }
};

// 如果data.list为空 则DialogPlugin弹窗提示需要添加分类,确认跳转到分类页面
const goodsCategory = ref([]);
const initGoodsCategory = async () => {
  const { data } = await listSimple();
  if (data.list.length === 0) {
    const confirmDia = DialogPlugin({
      header: '提醒',
      body: '还没有商品分类，请先添加分类！',
      confirmBtn: '去分类页添加',
      closeOnOverlayClick: false,
      theme: 'warning',
      onConfirm: ({ e }) => {
        confirmDia.hide();
        router.push('/merchant/goods/category');
      },
      onCloseBtnClick: ({ e }) => {
        confirmDia.hide();
        router.push('/merchant/goods/category');
      },
      onCancel: ({ e }) => {
        confirmDia.hide();
        router.push('/merchant/goods/category');
      },
    });
  }
  goodsCategory.value = data.list;
};

const moreSetting = ref(false);
const FORM_RULES: Record<string, FormRule[]> = {
  cate_id: [{ required: true, message: '请选择分类', type: 'error' }],
  name: [{ required: true, message: '请输入商品名', type: 'error' }],
  price: [{ required: true, message: '请输入商品价格', type: 'error' }],
  content: [{ required: true, message: '请输入商品详情', type: 'error' }],
  remark: [{ required: true, message: '请输入商品备注', type: 'error' }],
};

// form
const form = ref();
// 保存
const onSubmit = async () => {
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    const submitForm = formData.value;
    try {
      let res;
      if (opt.value === 'add') {
        res = await add(submitForm);
      } else {
        res = await edit(submitForm);
      }
      if (res.code === 1) {
        MessagePlugin.success(res.msg);
      } else {
        MessagePlugin.error(res.msg);
      }
    } catch (error) {
      console.error(error);
    }
  }
};

const onSubmit2 = async () => {
  onSubmit();
  router.push('/merchant/goods/index');
};

initGoodsCategory();
getGoods();
initGoods();
</script>

<style lang="less" scoped>
.more-setting {
  margin: var(--td-comp-paddingTB-xxl) 0;
  padding-left: var(--td-comp-paddingTB-xxl);
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background: var(--td-brand-color-1);
  padding-top: 8px;
  padding-bottom: 10px;

  .more-sett-text {
    display: inline-block;
    margin-left: 13px;
  }

  .more-setting span {
    color: #a2a9ba;
  }
}

.more-content {
  padding-bottom: var(--td-comp-paddingTB-xxl);
}
</style>

<template>
  <div style="background: #5e0000; min-height: 100vh">
    <common-header :shop-info="shopInfo" />
    <t-card class="container section details pb20 index-card" :bordered="false" style="">
      <div class="row category">
        <h3 class="title">
          <t-space align="center">
            <img :src="categoryImg" />
            商品分类{{ feePlayer }}
          </t-space>
        </h3>

        <div v-for="(item, key) in cateInfo.categorys" :key="key" flex="auto" class="category_box" :class="cateInfo.id == item.id ? 'active' : ''" @click="clickCategory(item.id)">
          <div class="card">
            <div>
              {{ item.name }}
            </div>
            <span class="card__s_cateremark">共{{ item.goodsCount }}种商品</span>

            <img class="lite_img" src="./static/on.png" />
          </div>
        </div>
      </div>

      <div v-if="cateInfo.goods.length > 0">
        <t-divider />
        <div class="row goods">
          <h3 class="title">选择商品</h3>

          <t-row v-for="(item, key) in cateInfo.goods" :key="key" class="card" :class="goodsInfo.id == item.id ? 'active' : ''" style="min-height: 80px; margin-bottom: 10px; position: relative; align-items: center" @click="clickGoods(item.id)">
            <t-col :span="4">
              <h4>{{ item.name }}</h4>
            </t-col>
            <t-col :span="1"> ￥{{ item.price }} </t-col>
            <t-col :span="1">
              {{ item.stockStr }}
            </t-col>

            <t-col :span="6">
              <span v-html="item.content"></span>
              <span v-if="item.wholesale_discount_list.length > 0" class="row">
                <span style="padding: 0 20px">(满减优惠)</span>
                <span v-for="(r, index) in item.wholesale_discount_list" :key="index">买满{{ r.num }}件，单价{{ r.price }}元</span>
              </span>
              <span v-if="item.event_give != null && item.event_give.length > 0" class="row">
                <span style="padding: 0 20px">(活动赠送)</span>
                <span v-for="(r, index) in item.event_give" :key="index">买满{{ r.num }}件，赠送{{ r.give_num }}件</span>
              </span>
              <span v-if="item.addtion_give != null && item.addtion_give.length > 0" class="row">
                <span style="padding: 0 20px">(附加赠送)</span>
                <span v-for="(r, index) in item.addtion_give" :key="index">
                  买满{{ r.bug_num }}件，赠送`<b>{{ r.goods_name }}</b
                  >`商品{{ r.give_num }}件
                </span>
              </span>
            </t-col>
            <img class="lite_img" src="./static/on.png" />
          </t-row>
        </div>

        <t-divider />
        <div class="row">
          <h3 class="title">
            <t-space align="center">
              <img :src="goodsBuyImg" />
              购买信息
            </t-space>
          </h3>
          <div class="content">
            <t-form label-width="80" style="width: 400px">
              <t-form-item label="联系方式" tips="联系方式特别重要,可用来查询订单">
                <t-input v-model="formData.contact" name="contact" :placeholder="contactText" clearable />
              </t-form-item>
              <t-form-item label="提醒服务" tips="短信提醒可能需要支付额外的短信费用">
                <t-check-tag-group
                  v-model="checkTagValue1"
                  theme="danger"
                  multiple
                  :options="[
                    { label: '短信提醒', value: 1 },
                    { label: '邮箱提醒', value: 2 },
                  ]"
                />
              </t-form-item>
              <!-- 如果checkTagValue1包含2 -->
              <t-form-item v-if="checkTagValue1.includes(2)" label="邮箱地址">
                <t-input v-model="formData.email" name="email" placeholder="填写你常用的邮箱地址" clearable />
              </t-form-item>
              <!-- <t-form-item label="购买数量">
                <t-input-number v-model="formData.quantity" :step="1" :max="goodsInfo.cards_stock_count" :min="goodsInfo.limit_quantity" auto-width clearable @change="handleChange" />
              </t-form-item> -->
              <!-- 优惠券 -->
              <t-form-item v-if="goodsInfo.coupon_type" label="优惠券">
                <t-switch v-model="couponBtnActive" />
              </t-form-item>
              <t-form-item v-if="couponBtnActive && goodsInfo.coupon_type" label="优惠券" :tips="couponHelp">
                <t-input v-model="formData.coupon_code" name="coupon_code" placeholder="请填写你的优惠券" />
              </t-form-item>
              <t-form-item v-if="goodsInfo.take_card_type != 0" label="取卡密码">
                <t-input v-if="goodsInfo.take_card_type != 0" v-model="formData.pwdforsearch" placeholder="请输入取卡密码（6-20位）" />
              </t-form-item>
            </t-form>
          </div>
        </div>
        <t-divider />
        <div v-if="payList.length" class="row">
          <h3 class="title">选择支付方式</h3>
          <div class="ure_info_box">
            <div class="pay_type">
              <div class="pay_type_box">
                <div v-for="(item, key) in payList" :key="key" class="pay_type_leng" :class="payInfo.channel_id == item.channel_id ? 'pay_type_leng_xz' : ''" @click="clickPayType(item.channel_id)">
                  <img style="width: 21px" :src="baseUrl + item.ico" />
                  <span>{{ item.show_name }}</span>
                  <img class="xiadui" src="./static/on.png" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <template #footer>
        <t-button block theme="danger" size="large" variant="base" @click="handleSubmit()">
          <div class="content">
            <span>确认支付 : </span>
            <span>支付金额￥{{ paymoneyTotal }}</span>
            <s v-if="goodsInfo.coupon_type && formData.coupon_code">原价：{{ paymoney }}</s>
          </div>
        </t-button>
      </template> -->

      <!-- <span @click="showPriceModal()">价格说明</span> -->
    </t-card>
    <footer>
      <!-- <price :form-data="formData" :visible="priceDialogVisible" :sms-price="smsPrice" :price="goodsInfo.price" @update-show="handelPriceDialogVisible" /> -->
      <div class="container">
        <p style="color: #bf6f6f"><span v-html="siteInfoCopyright"></span></p>
        <!-- 如有侵权请及时联系 {{ siteInfoEmail }} -->
        <p style="color: #bf6f6f">{{ siteInfoIcp }}</p>
      </div>
    </footer>

    <div class="create-order">
      <div class="create-item container">
        <div class="goods-title">
          <!-- {{ goodsInfo?.name }} -->
        </div>
        <div class="create-goods-counts"><t-input-number v-model="formData.quantity" :step="1" :max="goodsInfo.cards_stock_count" :min="goodsInfo.limit_quantity" auto-width clearable size="large" @change="handleChange" /></div>
        <div>
          <t-space align="center" size="large">
            <div class="price">
              支付金额
              <span class="total">￥{{ paymoneyTotal }}</span>
              <span v-if="goodsInfo.coupon_type && formData.coupon_code" class="s">原价：{{ paymoney }}</span>
            </div>
            <t-button shape="round" theme="danger" variant="base" size="large" @click="handleSubmit()"> 确认订单 </t-button>
          </t-space>
        </div>
      </div>
    </div>

    <t-loading :loading="orderLoading" text="生成订单中..." attach="body" fullscreen size="small"></t-loading>
    <order-dialog ref="orderRef" />
  </div>
</template>
<script lang="ts">
export default {
  name: 'Default',
};
</script>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, nextTick, reactive, ref, toRefs, watch } from 'vue';

import { baseUrl } from '@/api/base';
import { createOrder, getCouponInfo, getGoodsList } from '@/api/shop/shop';
import { useSiteStore } from '@/store';

import CommonHeader from './Header.vue';
// import Price from './Price.vue';
import OrderDialog from './OrderDialog.vue';
import categoryImg from './static/img/category.img?raw';
import goodsBuyImg from './static/img/goodsbuy.img?raw';

const siteStore = useSiteStore();
const siteInfoCopyright = computed(() => siteStore.config.site_shop_copyright);
// const siteInfoEmail = computed(() => siteStore.config.site_info_email);
const siteInfoIcp = computed(() => siteStore.config.site_info_icp);
const escape2Html = (str: string) => {
  const arrEntities: { [key: string]: string } = { lt: '<', gt: '>', nbsp: ' ', amp: '&', quot: '"' };
  return str.replace(/&(lt|gt|nbsp|amp|quot);/gi, (all, t: keyof typeof arrEntities) => arrEntities[t]);
};

const checkTagValue1 = ref([]);

// 父组件传来的 info
const props = defineProps<{
  info: any;
}>();

const { info } = toRefs(props);
// 费率承担者
const feePlayer = ref(0);
// 店铺信息
const shopInfo = reactive({
  shop_name: '',
  qq: '',
  shop_id: '',
  shop_notice_show: 0,
  shop_notice: '',
  show_contact: 0,
  shop_contact: {
    mobile: '',
    qq: '',
    wechat: '',
  },
});
const cateInfo = reactive({
  categorys: [],
  goods: [],
  id: null,
  // goodsContent: info.value.goods[0],
  // payInfo: info.value.userChannels,
});
// 初始渲染
// 店铺信息
const initShopInfo = () => {
  Object.assign(shopInfo, info.value.shop);
};
// 栏目信息
const initCateInfo = () => {
  Object.assign(cateInfo, info.value);
  cateInfo.id = info.value.categorys[0].id;
};
// 商品信息
const goodsInfo = reactive({
  id: null,
  content: '',
  coupon_type: '',
  // wholesale_discount: info.value.goods[0].wholesale_discount,
  visit_type: '',
  take_card_type: 0,
  limit_quantity: 0,
  price: 0,
  contact_limit: '',
  sms_payer: 0,
  sms_price: 0,
  name: '',
  card_order: '',
  stockStr: '',
  cards_stock_count: null,
  wholesale_discount_list: [],
  event_give: [],
  addtion_give: [],
});
// 初始化商品信息
const initGoods = () => {
  if (info.value.goods.length > 0) {
    Object.assign(goodsInfo, info.value.goods[0]);
  }
};
initShopInfo();
initCateInfo();
initGoods();

// 支付通道 - 初始渲染
const payList = reactive(info.value.userChannels);
const payInfo = reactive({
  channel_id: payList.length ? payList[0].channel_id : 0,
  // pay_type: info.value.pay_type,
  rate: payList.length ? payList[0].rate : 0,
});
// 栏目点击切换
const clickCategory = async (id: number) => {
  // 如果点击的栏目是当前栏目，不切换
  if (id === cateInfo.id) return;
  // 重置商品列表
  const { data } = await getGoodsList({
    cate_id: id,
    token: info.value.token,
  });
  // 如果栏目下没有商品，不切换
  if (data.length === 0) {
    MessagePlugin.error('该栏目下没有商品!');
    return;
  }
  // 切换栏目
  cateInfo.id = id;
  // 栏目下的商品列表
  cateInfo.goods = data;
  // 渲染第一个商品
  Object.assign(goodsInfo, data[0]);
  // 商品详情格式化
  goodsInfo.content = escape2Html(data[0].content);
  initPayMoney();
  formData.goods_id = goodsInfo.id;
};

// 商品点击切换
const clickGoods = (id: number) => {
  if (id === goodsInfo.id) return;
  // 根据商品id获取商品详情
  const goodsData = cateInfo.goods.find((item: any) => item.id === id);
  // 渲染商品详情
  Object.assign(goodsInfo, goodsData);
  // 商品详情格式化
  goodsInfo.content = escape2Html(goodsData.content);
  initPayMoney();
  formData.goods_id = goodsInfo.id;
};

const contactLimitText = ref('无限制');
const contactText = ref('[必填]推荐填写QQ号或手机号!');
const initContactLimitText = () => {
  if (goodsInfo.contact_limit === 'any') {
    contactLimitText.value = '任意字符串';
  } else if (goodsInfo.contact_limit === 'mobile') {
    contactLimitText.value = '只能输入手机号';
    contactText.value = '[必填]请填写您的手机号!';
  } else if (goodsInfo.contact_limit === 'email') {
    contactLimitText.value = '只能输入邮箱';
    contactText.value = '[必填]请填写您的邮箱!';
  } else if (goodsInfo.contact_limit === 'qq') {
    contactLimitText.value = '只能输入QQ号';
    contactText.value = '[必填]请填写您的QQ号!';
  } else {
    contactLimitText.value = '[必填]请输入联系方式';
  }
};
initContactLimitText();
// 如果checkTagValue1包含1则显示短信提醒（contactText.value = '[必填]请填写您的手机号!'）,计算短信费用（formData.is_rev_sms = 1）否则使用默认值initContactLimitText();并重新计算短信费用；如果包含2则显示邮箱输入框（formData.isemail = 1）
watch(
  () => checkTagValue1.value,
  (val) => {
    if (val.includes(1)) {
      contactText.value = '[必填]请填写您的手机号!';
      formData.is_rev_sms = 1;
    } else {
      initContactLimitText();
      formData.is_rev_sms = 0;
    }
    if (val.includes(2)) {
      formData.isemail = 1;
    } else {
      formData.isemail = 0;
    }
    initPayMoney();
  },
);

// 点击 优惠券 按钮
const couponBtnActive = ref(false);
// 如果couponBtnActive激活则 formData.is_coupon = 1 否则 formData.is_coupon = 0
watch(
  () => couponBtnActive.value,
  (val) => {
    if (val) {
      formData.is_coupon = 1;
      return;
    }
    formData.is_coupon = 0;
  },
);
// 点击支付方式按钮
const clickPayType = (id: number) => {
  payInfo.channel_id = id;
  formData.pid = id;
};
// 数量输入框切换
const handleChange = (v: number) => {
  if (v) {
    initPayMoney();
    if (v > goodsInfo.cards_stock_count) {
      MessagePlugin.error('库存不足');
    }
  }
};
const formData = reactive({
  goods_id: goodsInfo.id,
  contact: '',
  coupon_code: '',
  pwdforsearch: '',
  isemail: 0,
  email: '',
  is_rev_sms: 0,
  pid: payInfo.channel_id,
  is_coupon: 0,
  quantity: goodsInfo.limit_quantity ? goodsInfo.limit_quantity : 1,
});

// 监听 formData.coupon_code 变化
watch(
  () => formData.coupon_code,
  (val) => {
    if (val) {
      initPayMoney();
    }
  },
);
// 发起订单  生成订单号
const orderLoading = ref(false);
// 订单窗口
const orderInfo = reactive({});
const orderRef = ref();
const handleSubmit = async () => {
  if (formData.contact === '') {
    MessagePlugin.error('请填写联系方式!');
    return;
  }
  if (formData.quantity === 0) {
    MessagePlugin.error('请填写购买数量!');
    return;
  }
  if (formData.quantity > goodsInfo.cards_stock_count) {
    MessagePlugin.error('库存不足!');
    return;
  }
  if (formData.quantity < goodsInfo.limit_quantity) {
    MessagePlugin.error('购买数量不能小于最小购买数量!');
    return;
  }

  if (formData.isemail === 1 && formData.email === '') {
    MessagePlugin.error('请填写邮箱!');
    return;
  }
  if (formData.is_rev_sms === 1 && formData.contact === '') {
    MessagePlugin.error('请填写手机号!');
    return;
  }
  if (formData.is_coupon === 1 && formData.coupon_code === '') {
    MessagePlugin.error('请填写优惠券!');
    return;
  }
  if (goodsInfo.take_card_type === 1 && formData.pwdforsearch === '') {
    MessagePlugin.error('请填写卡密查询密码!');
    return;
  }
  orderLoading.value = true;
  // 提交订单
  const res = await createOrder(formData);

  if (res.code === 1) {
    // res.data合并到orderInfo
    Object.assign(orderInfo, res.data);

    await nextTick();
    orderRef.value?.init(orderInfo);
  } else {
    MessagePlugin.error(res.msg);
  }
  orderLoading.value = false;
};

// 对支付费用进行计算 取2未小数 不足补0
const toFixed = (num: number) => {
  return num.toFixed(2);
};

// get_discount_price 批发优惠单价计算
const getDiscountPrice = (price: any, list: any, quantity: any) => {
  const sort = list.sort((a: any, b: any) => {
    return a.num - b.num;
  });
  sort.forEach((item: any) => {
    if (quantity >= item.num) {
      price = item.price;
    }
  });
  return price;
};

// 如果卖家承担短信费用
const smsPrice = ref(0);
// 原价
const paymoney = ref(0);
// 实际支付
const paymoneyTotal = ref();
// 批发优惠价
// 单价
const paymoneyDj = ref(0);
// 原单价
const paymoneyDjY = ref(0);
// 优惠券价格
const paymoneyYhj = ref(0);
// 支付费用计算
// 受影响位置
// 1. 商品数量 2. 短信提醒 3. 使用优惠券 4. 栏目切换 5. 商品切换 6. 批发优惠
const couponHelp = ref('');
const initPayMoney = async () => {
  paymoneyDjY.value = goodsInfo.price;
  paymoneyDj.value = goodsInfo.price;
  if (goodsInfo.wholesale_discount_list != null) {
    paymoneyDj.value = getDiscountPrice(goodsInfo.price, goodsInfo.wholesale_discount_list, formData.quantity);
  }

  // 原价*数量
  paymoney.value = paymoneyDjY.value * formData.quantity;
  // 如果批发优惠命中条件，优惠价*数量
  if (paymoneyDj.value > 0) {
    paymoneyTotal.value = paymoneyDj.value * formData.quantity;
  } else {
    paymoneyTotal.value = paymoney.value;
  }

  // 使用优惠券
  if (couponBtnActive.value === true && formData.coupon_code !== '') {
    // 获取优惠券信息
    const formDataCoupon = {
      coupon_code: formData.coupon_code,
      goods_id: goodsInfo.id,
      cate_id: cateInfo.id,
      quantity: formData.quantity,
      shop_id: shopInfo.shop_id,
      total_price: paymoneyDj.value * formData.quantity,
    };
    const res = await getCouponInfo(formDataCoupon);
    if (res.code === 1) {
      if (res.data.type === 1) {
        // 满减券
        paymoneyYhj.value = res.data.amount;
      } else if (res.data.type === 2) {
        // 折扣券
        paymoneyYhj.value = (paymoneyTotal.value * res.data.amount) / 100;
      }
      // 优惠券可用提示

      couponHelp.value = `优惠券可用,优惠${res.data.amount}${res.data.type === 1 ? '元' : '%'}`;
      // 如果优惠券金额大于订单金额，优惠券金额等于订单金额
      if (paymoneyYhj.value > paymoneyTotal.value) {
        paymoneyYhj.value = paymoneyTotal.value;
        couponHelp.value = `优惠券可用,优惠${res.data.amount}${res.data.type === 1 ? '元' : '%'}，但大于订单金额，本单享受全额优惠【0元购买】`;
      }
    } else {
      couponHelp.value = res.msg;
      paymoneyYhj.value = 0;
    }
  }

  // 短信费用
  if (goodsInfo.sms_payer === 0 && formData.is_rev_sms) {
    smsPrice.value = goodsInfo.sms_price;
  } else {
    smsPrice.value = 0;
  }

  paymoneyTotal.value = toFixed(Number(paymoneyTotal.value) + Number(smsPrice.value) - Number(paymoneyYhj.value));
};
initPayMoney();
</script>
<!-- css  -->
<style lang="less" scoped>
.index-card {
  border: 2px solid #dbb479;
  border-radius: 12px;
  box-shadow: none;
  background-color: var(--td-error-color-10);
  background-image: url(./static/back.04fc389.png);
}
footer {
  padding-bottom: 80px;
}
@import url('./static/pc_main.css');
</style>

<template>
  <div id="index" class="order-wrapper">
    <mini-header />

    <div class="order-banner">
      <div class="container">
        <dl>
          <dt><img src="../css/img/bg_index3.png" style="transform: scaleX(-1); height: 150px" /></dt>
          <dd>{{ searchType.text }}</dd>
        </dl>
        <div class="order-search">
          <div class="order-search-box">
            <div class="item">
              <div class="input-group">
                <div style="width: 100%; display: flex">
                  <div style="width: 20%">
                    <span>查询类型</span>
                    <t-select v-model="searchType" class="searchType" value-type="object" size="large" :options="searchTypeArr" @change="handleSearchTypeChange"> </t-select>
                  </div>
                  <div :style="searchType.value == '2' ? 'width:30%;margin-right: 20px;' : 'width: 60%;margin-right: 20px;'">
                    <span>订单号</span>
                    <t-input v-model="inputVal" class="orderid_input" size="large" placeholder="请输入订单号" />
                  </div>
                  <div v-if="searchType.value == '2'" :style="searchType.value == '2' ? 'width:30%;margin-right: 20px;' : ''">
                    <span>查询密码</span>
                    <t-input v-model="pwd" class="orderid_input" size="large" placeholder="请输入查询密码" />
                  </div>

                  <div style="width: 20%">
                    <span>查询类型</span>
                    <t-button class="order-btn" @click="orderQuery">{{ searchType.submitText }}</t-button>
                  </div>
                </div>
              </div>
            </div>
            <div class="p d-none d-lg-block"><span>免责声明：</span>平台不参与商品售卖，如需售后请点击联系商家，若需要平台介入售后：可在【订单投诉】等待平台处理。(且平台只处理24小时内订单)</div>
          </div>
        </div>
      </div>
    </div>

    <t-dialog v-model:visible="visibleModal" :close-on-overlay-click="false" header="提示" mode="modal" draggable confirm-btn="确定" :on-confirm="onSubmit">
      <template #body>
        <t-form ref="form" :label-align="'top'">
          <t-form-item label="" name="name">
            <t-input v-model="pwd" placeholder="请输入查询密码" :style="{ width: '500px' }" />
          </t-form-item>
        </t-form>
      </template>
    </t-dialog>

    <div class="order">
      <div v-if="orderQueryStatus" class="container">
        <t-row>
          <t-col v-if="!order" class="col-lg-12">
            <div class="no-order">
              <!--<img src="/static/theme/contracted_business/imgs/no-data.png" alt="">-->
              <p>没有查询到订单信息</p>
            </div>
          </t-col>

          <t-col v-if="order.status == 0" class="col-lg-12">
            <div class="no-order">
              <!--<img src="/static/theme/contracted_business/imgs/no-data.png" alt="">-->
              <p>订单未支付</p>
            </div>
          </t-col>

          <t-col v-else :span="12">
            <div class="order-list">
              <t-button>订单号：{{ order.trade_no }}</t-button>
              <div class="h" style="display: flex; justify-content: space-between; align-items: center">
                <dl>
                  <dt>下单时间</dt>
                  <dd>{{ formatTime(order.create_at) }}</dd>
                </dl>
                <dl>
                  <dt>付款方式</dt>
                  <dd>{{ paytype }}</dd>
                </dl>
                <dl>
                  <dt>支付金额</dt>
                  <dd>{{ order.total_price }}元</dd>
                </dl>
                <dl>
                  <dt>已发卡密</dt>
                  <dd>发放卡密{{ order.quantity }}张</dd>
                </dl>
                <dl>
                  <dt>商品名称</dt>
                  <dd style="max-width: 303px">{{ goods.name }}</dd>
                </dl>
              </div>
              <div style="text-align: center">
                <t-space>
                  <t-button v-if="outCards" @click="dumpCards">导出卡密</t-button>
                  <t-button v-if="outCards" tip="点击复制" @click="constOutCards">复制卡密</t-button>
                </t-space>
              </div>
              <div style="text-align: center; padding: 20px; margin: 20px">
                <div id="copyText" v-html="outCardsHtml"></div>
                <div class="remark">
                  使用说明：
                  <div v-html="goods.remark"></div>
                </div>
                <div class="remark">
                  联系商家:
                  <div v-for="(item, index) in shopContact" :key="index">{{ index }} : {{ item }}</div>
                </div>
              </div>
            </div>
          </t-col>
        </t-row>
      </div>
    </div>
    <t-loading :loading="loading" text="加载中..." fullscreen />

    <div class="container copyright">
      防骗提示：如果您查询卡密时发现有以下情况,证明您很有可能被骗,请及时与快发卡客服联系 <br />
      1.卡密内容为"联系XX取卡"、"付款成功，等待充值" 2.以各种理由推脱到第二天发货 3.商品有问题，卖家不售后 4.承诺充值返现 5.购买的商品为实物，需要快递发货
    </div>
    <complaint-deatil ref="complaintDeatilRef" />
  </div>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';
// import { UserIcon } from 'tdesign-icons-vue-next';
import { useRouter } from 'vue-router';

import { query as complaintQuery } from '@/api/home/complaint';
import { query } from '@/api/home/order';
import { copyText } from '@/utils/common';
import { formatTime } from '@/utils/date';

import ComplaintDeatil from './components/ComplaintDeatil.vue';
import MiniHeader from './MiniHeader.vue';

const router = useRouter();

const { tscx, orderId } = router.currentRoute.value.query;
const searchType = ref({ value: '1', label: '订单查询', text: '轻松查询订单,即刻享受卡密自动交易', submitText: '查询订单' });
if (tscx) {
  searchType.value = { value: '2', label: '投诉查询', text: '轻松查询投诉,保障您的消费权益', submitText: '查询投诉' };
}
const searchTypeArr = [
  {
    label: '订单查询',
    value: '1',
  },
  {
    label: '投诉查询',
    value: '2',
  },
];

const handleSearchTypeChange = (val: any) => {
  if (val.value === '1') {
    searchType.value.text = '轻松查询订单,即刻享受卡密自动交易';
    searchType.value.submitText = '查询订单';
  } else {
    searchType.value.text = '轻松查询投诉,保障您的消费权益';
    searchType.value.submitText = '查询投诉';
  }
  searchType.value = val;
};
const orderQueryStatus = ref(false);
// 订单号、联系方式
const inputVal = ref('');
if (orderId) {
  inputVal.value = orderId as string;
}
const queryType = ref(3);
const outCards = ref('');
const outCardsHtml = ref('');
const order = ref({
  trade_no: 'Dd240318072806b1a72b16',
  create_at: 1,
  total_price: '',
  quantity: '',
  status: 0,
});
const paytype = ref('');
const goods = ref({
  name: '',
  remark: '',
});
const shopContact = ref({
  wechat: '',
  mobile: '',
  qq: '',
});
const loading = ref(false);
const visibleModal = ref(false);
const pwd = ref('');
const complaintDeatilRef = ref();
const orderQuery = async () => {
  if (!inputVal.value.length) {
    MessagePlugin.error('请输入订单号！');
    return;
  }

  let queryTypeValue = 2; // 默认为订单号查询
  // 判断inputVal是否是手机号
  if (/^1[3456789]\d{9}$/.test(inputVal.value)) {
    queryTypeValue = 3;
  }

  queryType.value = queryTypeValue;
  orderQueryStatus.value = false;
  loading.value = true;

  try {
    let res;
    if (searchType.value.value === '1') {
      res = await query({
        orderid: inputVal.value,
        queryType: queryType.value,
        pwd: pwd.value,
      });
    } else {
      res = await complaintQuery({
        trade_no: inputVal.value,
        pwd: pwd.value,
      });
    }

    loading.value = false;

    if (res.code === 1001) {
      visibleModal.value = true;
      return;
    }

    if (res.code === 0) {
      MessagePlugin.error(res.msg);
      return;
    }

    if (searchType.value.value === '1') {
      order.value = res.data.order;
      outCards.value = res.data.outCards;
      outCardsHtml.value = outCards.value.replace(/\n/g, '<br />');
      paytype.value = res.data.paytype;
      goods.value = res.data.goods;
      shopContact.value = res.data.shop.shop_contact;
      orderQueryStatus.value = true;
      visibleModal.value = false;
      pwd.value = '';
    } else {
      complaintDeatilRef.value?.init(res.data);
    }
  } catch (error) {
    loading.value = false;
    MessagePlugin.error('查询出错');
  }
};

const saveBtn = reactive({
  content: '查询',
  loading: false,
});

const onSubmit = () => {
  if (pwd.value) {
    saveBtn.content = '查询中...';
    saveBtn.loading = true;
    orderQuery();
  } else {
    MessagePlugin.error('请输入查询密码');
  }
};

const dumpCards = () => {
  const fileName = `${goods.value.name}-${order.value.trade_no}.txt`;
  const fileContent = outCards.value;
  const url = window.URL.createObjectURL(new Blob([fileContent]));
  const link = document.createElement('a');
  link.style.display = 'none';
  link.href = url;
  link.setAttribute('download', fileName);
  document.body.appendChild(link);
  link.click();
};

const constOutCards = () => {
  copyText(outCards.value);
};
</script>

<style lang="less" scoped>
@import url('../css/style.less');
@import url('../css/bootstrap.min.css');

#index {
  position: relative;
}
.container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 20px;
}
.item span {
  display: block;
  color: #999;
  font-weight: 500;
  font-size: 16px;
  padding-bottom: 18px;
  text-indent: 10px;
}
.order-list {
  box-shadow: 0 5px 5px #eeeeee73;
}
.order-list p {
  line-height: 1.6;
}
.order-list dl dt {
  text-align: center;
}
.order-list .h dl {
  margin-right: 10px;
}
.copyright {
  font-size: 14px;
  bottom: 64px;
  margin: 60px auto;
  color: var(--td-text-color-secondary);
  position: relative;
  bottom: 0;
}
:deep(.t-input.t-size-l) {
  height: 60px;
  border-radius: 6px;
}
.searchType {
  padding-right: 20px;
}
.orderid_input {
  height: 60px;
  border: none;
  border-radius: 6px;
  margin-right: 20px;
  border: 1px solid #f2f2f2;
}

.order-btn {
  width: 145px;
  height: 60px;
  border-radius: 6px;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition:
    border-color 0.15s ease-in-out,
    box-shadow 0.15s ease-in-out;
  box-shadow:
    0 1px 6px rgba(0, 0, 0, 0.117647),
    0 1px 4px rgba(0, 0, 0, 0.117647);
}
.remark {
  padding: 10px;
  background: #f5f5f5;
  border-top: 1px solid #f2f2f2;
}
</style>

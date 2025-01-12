<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :header="false" :footer="false" :close-btn="false" placement="top" top="30px" confirm-btn="null" @closed="noticeParent">
    <template #body>
      <div class="plaint-mark">
        <div class="plaint-form">
          <div class="title">
            <img src="@/assets/mini_complaint/a1.png" width="43" />
            <div>
              <h3>
                提交投诉订单
                <i>
                  <!-- 累计已解决{{ plaintCount }}件投诉 -->
                </i>
              </h3>
              <p>提交投诉后,平台将在24小时内为您解决问题</p>
            </div>
          </div>
          <div class="item">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAATCAMAAACuuX39AAAA9lBMVEXw9P/w8//2+P/6+/+gvNqhvNqUs9SUs9SNrtCVtNWTs9SRsdOUs9STstSVtNXc5feYttbp7/7v9P/y9v/4+v/X4vXh6fri6vro7v6NrtDq8P/v8/+at9fx9f/y9f+eutn3+f+5zeb////A0urB0+vG1+zO3PHQ3fLT3/OTstPa5PeVtNSVtNXj6/nn7f2WtNSYttaLrc/r8f/s8f/u9P+cudedudiQr9GzyeO1yuTz9v/1+P/2+P+3zOWSstP+/v+8z+jt8//u8/+lv9ypwt7e5/i/0emqw9/B0uqrw9/09//19//C1Ovo7/6vxuKauNeUs9Skvts7qNK3AAAAEXRSTlM+c3Nzm5uur/Hx8fHx8fL2++I3n9MAAADSSURBVHheTctVcsNAEEXRlh2Q7ER2z4yYZWZmDDPtfzORO7GSU+/rVV2ATFY6lS8S8omUzQAUSpVo2/hMNLZRpVSAYmviWgMrMbDcSasI+W7olz+mQTB1y37YzYNisKGDJiZzhsxQQNEZ2iNiI9MPx9hZ+mTpjA+Hsdr0AtLbrCjh1f0j2Vf5MeHkmKznsz6ZzdeUeM1andSaHiVXIo7jHffT5Pn+6+FmgSNEZD/H6+37U/R36NdchOIF334P1RReSpgqtLXOXaqjteE8d/lP7uwbP8gnLoxoa5oAAAAASUVORK5CYII="
              width="16"
            />
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAYFBMVEXS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tL////+/v74+PjU1NTW1tbg4ODY2Njk5OTn5+fq6ur09PT19fXZ2dnb29vd3d2OA0XMAAAAEHRSTlMAAiIjWVqyt8vM5ebp6uv5slEr4gAAAHpJREFUeF5lj4kOhDAIRMHaeq9Tb/fy///SSb0260tIZoACFaKxq1C5WCUQZdjIomBLHJRMaEoxMvoOSFUs5dwM6NsXE1YSoGt9MzEWIJEHwJr3nj1AISD40j9B6v/67f01/x3mh/2fa7+Yn/uMEHPeT7v/L68LZ5V6BXIVC5/Lrsn2AAAAAElFTkSuQmCC"
              width="15"
              style="display: none"
            />
            <input v-model="params.trade_no" type="text" placeholder="订单编号" />
          </div>
          <div class="item">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAATCAMAAABBexbDAAACDVBMVEWUs9Srwf2Ts9Orwf2uw/+twv+twv+nv/awxP+Us9Wuw/+SstChu+uZtt2iu+2Ztt2TstKiu+2swf6Us9SRsc+RsdCuw/+Ts9OTstKUs9SRsc+kvfCSstCUs9Orwf2TstKrwf6tw/+swv6wxf+vw/+swv+SstGUs9Sov/eqwPqswv+Ts9ORsc+Us9Ouw/+ov/euw/+rwf2uw/+Ssc+Vs9alvvKWtNiWtNiPsMyZttyivO2nvvWfuueguumTstOtwv+WtNiTs9KRsc6dueSvxP6nv/WTs9OSstGUs9Oov/eUs9OPsMuQsc2Xtdmtwv+eueaZtt6Rsc+jvO+zxf+nvvWduOWkve6bt+GWtNecuOOiu+ylvvStwv+uw/+vw/+jvPCtwv+mvvWxxP+mvvSQsc6lvfKyxf+swf6twv+swf6swv+uw/+mvvWRsc6euuarwf2pwPqrwfyov/eZtt2swf6rwf2rwfyZt9+fuueRsc6TstGXtdulvfKVs9aiu+2rwf2kvfGSstCeuueYtduTstGUs9STs9OSsdGTstKlvfGswv+swv+pwPqbt+CSstKUs9WTstGVs9WqwPyxxP+twv+Ztt6twv+Vs9aTstKUs9OTstOduOSnv/aPsMyUs9Onv/acuOGTstKUs9SUs9SlvfGcuOOQsc2Us9SQsc2SstCRsc+SsdCPsMuSstGOsMpgb29hAAAAqHRSTlMAHOwdAAAEVwAAAuFgsUm8iFEcMK2/A+6SEetT01gb6xsVGwAAGeZAVggc6nncDk4NBwHV/TH4t/6gXCtrb9gB7mDGmAAq3chdGeH5/LQXith4VABJh1WdrZlwKgMIBVMFRQFO8GAAARIYFQdG2noVKyAa0hogHNN324nhKs5eHl/pVd6HA8z72DMOFCCG2QJ4/AAACIoH930l/ZRL8uBKnP4kSDubxkeD9brmAAABJElEQVR4XjXNU3vDABhA4S9LsqW27Xa2bdu2bdu2zWLbb1zTPHsvz80BD4uQ4ccQWuAfTepgMYOYLIeUBhSui43Rm+kY28WlgsDJI/gogvIJnlMAJBEH1yMkPc4RkUEmV4hRT0HFCrnMXVSZozqEossJULmL/xTmSwW00Fhc4l6HhUckhQaaUFMwFhL/k0WD7Mio6JjYOBtmy0hI/L5IToHUtPQiu/3hcSw3L7/gnfj4BHNpWflvRWVVdU1tXX1DY5MZJC2tbe0dnXgXbuzu6e3rl8DAIDE0PKLWjmsR9cSkYXoGZufmFxaxJfJOX15ZXVuHjc2t7Z1dhLS3f2A/PAI4Pjk9O/cmXRrwq2sAuLm9u7f6kKxPzy+v4Pam1HhRNMovgD8S/ULNsb6+NQAAAABJRU5ErkJggg=="
              width="16"
            />
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAYFBMVEXS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tL////+/v74+PjU1NTW1tbg4ODY2Njk5OTn5+fq6ur09PT19fXZ2dnb29vd3d2OA0XMAAAAEHRSTlMAAiIjWVqyt8vM5ebp6uv5slEr4gAAAHpJREFUeF5lj4kOhDAIRMHaeq9Tb/fy///SSb0260tIZoACFaKxq1C5WCUQZdjIomBLHJRMaEoxMvoOSFUs5dwM6NsXE1YSoGt9MzEWIJEHwJr3nj1AISD40j9B6v/67f01/x3mh/2fa7+Yn/uMEHPeT7v/L68LZ5V6BXIVC5/Lrsn2AAAAAElFTkSuQmCC"
              width="15"
              style="display: none"
            />
            <input v-model="params.qq" type="text" placeholder="QQ号码" />
          </div>
          <div class="item phone">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAATCAMAAACX3symAAABjFBMVEU4bPqRsdU/cfcxZ/2VtNQvZf5EdvWQsNabudGUs9Q7bvkyaP2NrdeVs9QtZP9OffFLe/IiW/9AcvdLe/EwZv2YttKat9IwZv0uZP4xZ/2at9KMrdeauNKVtNMeWP9Le/KUs9Qzaf01afuZttKHqdmVs9QsY/+YttKat9I8bviKq9g/cvWYt9I/cfcpYf8tZP43bPpKevIsY/9dieowZv2QsNU8b/g4bPpQfvBPfvE6bvlRf/BHd/QhWv9qk+VahuwsY/4+cfePr9Y8b/lxmOKivs5CdPZokeaQsNV/o92Pr9YuZP48b/g8b/gyaP2Fp9pEdfWHqdmZttJtlORYhe2RsdV2nOAuZP49cPg8b/guZf6MrNdQfu8vZf49cPg5bfk6bfk6bfk6bvktY/89cPgxZv1jjehGd/QxZv0xZ/01afs2avsyaPw0afwwZv02avs5bfozaPxLe/IwZv5Me/KZt9KJq9hFdvR3neBEdfWKq9huluRZhew+cfacudGtxsqkwM6cutCvyMmlwMybGFcwAAAAfnRSTlMc6z0L8wdK7PnyNwwZ8gFSPABFPg/B9gcLDMMZ9fUAPfkMGsHV+wHA8zfkMMJAAAQcOwR2FesyCklSGFIoAGNFCDzqLVvgLkivXrwDOTwAkz7huG08vHICOzoCok4LDBIfCxIBPAlFLBQWGRkWGQ4XHhguET3D5DOTK+VcQh2Wja9OAAAA0klEQVR4XmOQVtZQkOXk5eXlVJVR52HQ0dI2bm6sq6trUDEMlGLgEJAzt7Dk5+e3trGV52Bg51JUMkrm4+NTE+HWZGdgZGJmgAJmJkYMrq6evkGhRLGJhAiIa2pWXlFpVV1Ta2fv4MjI4OTs4urm3uThWe/l7QNU7OvnH1AUFBwSGhYeAeRGRkXHxMbFJyQmSYKMSklNS8/IzMrOyYVYJJmXX4BmLy4uOxc3jMvNxQ70kaA4KxiIC5ZwMJSWCQuxgYGQcJUUA4+oGCcLGHCKifIAAEwHJRwlZPh7AAAAAElFTkSuQmCC"
              width="15"
              style="top: 31px"
            />
            <input v-model="params.mobile" type="text" placeholder="手机号码" />
            <!-- <div>获取验证码</div>
            <div style="display: none">0 s重新获取</div> -->
          </div>
          <div class="item" style="display: none">
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAQCAMAAAD+iNU2AAABMlBMVEWUs9STstOUs9SVtNWRsdORsdOUs9SPr9KPr9GUs9SQsNKSstORsdOUs9SUs9SJq8+Pr9GPr9GTstSRsdOMrdCUs9SPsNKUs9SUs9SRsdOPsNKUs9SQsNKUs9SPr9GUs9SSsdOUs9SSsdOUs9SUs9SRsdOUs9SSstONrtGUs9SSsdONrtGQsNKUs9SNrtGNrtHp7/7x9f/z9v/09//u8//w9P/R3vLK2e/Z5PfY4/bU4PP9/f/h6frQ3vLE1uzZ5PaZttba5feXtdXL2u/W4fXg6fqUs9T9/v/X4fXQ3fLy9f/X4/bd5/jw9f/a5Peqw96SsdPU4PSHqs7G1uypwt7q8P/o7v7y9v+Jq8/G1u2zyePX4vXc5vewx+KOr9Ha5Pbq8P7b5vf1+P/t8v/n7v319/9MXAPnAAAAMHRSTlMA8QEA8Qbx9tejZfEFu/y69tYAq9rHcqzDxHAbYGvYYfeX+Jhi8Gr34/L26mEz6ORixsMGAAAA0UlEQVR4XjXIVXbDMBSE4WtOUkOQocwkyRxmpiIz7H8LlRPnf5nzDXix26J4vMuCH5tWC+cHanp9bPZydHK9Pd+pxHISKd9BZWkluGI0lpEFQZAzsSgVl9ekcCRQDETCknbGQahVK1nDqxerapVqrRBc3vR18v3z+0eI3n86gp0ZQZ/m86JiIEQ+toAfjNCdcXvdnCI0GvCw3/E8f2ya1B0eDh1q8+29a1A7J3BqlzHW77sPGOOyfQHJRvu1Pp5UXLf+1W4kgcvGGWbDi2HiWe4fZbUhmmkA+ksAAAAASUVORK5CYII="
              width="16"
            />
            <img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAMAAAAMCGV4AAAAYFBMVEXS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tL////+/v74+PjU1NTW1tbg4ODY2Njk5OTn5+fq6ur09PT19fXZ2dnb29vd3d2OA0XMAAAAEHRSTlMAAiIjWVqyt8vM5ebp6uv5slEr4gAAAHpJREFUeF5lj4kOhDAIRMHaeq9Tb/fy///SSb0260tIZoACFaKxq1C5WCUQZdjIomBLHJRMaEoxMvoOSFUs5dwM6NsXE1YSoGt9MzEWIJEHwJr3nj1AISD40j9B6v/67f01/x3mh/2fa7+Yn/uMEHPeT7v/L68LZ5V6BXIVC5/Lrsn2AAAAAElFTkSuQmCC"
              width="15"
              style="display: none"
            />
            <input id="ts_pwd" type="text" placeholder="请输入短信验证码" />
          </div>
          <div class="input_select_box">
            <div class="title">
              <span>请选择投诉类型</span>
              <span>请准确填写投诉类型，恶意抹黑将无法受理</span>
            </div>
            <div v-for="(item, index) in tsType" :key="index" class="select_box" :class="selectValue == item.value ? 'select' : ''" @click="changeType(item.value)">
              {{ item.name }}
              <i v-if="item.tip">{{ item.tip }}</i>
            </div>
          </div>
          <div class="item">
            <img src="@/assets/mini_complaint/error-circle.png" width="16" />
            <textarea v-model="params.desc" :placeholder="doc"></textarea>
          </div>
          <div class="waring_tips">
            <img src="@/assets/mini_complaint/tips.png" width="15" />
            温馨提示
          </div>
          <div class="plaint-p">
            <p>1.提交投诉后,对应订单的款项将被平台冻结,不会给卖家结算</p>
            <p>2.如投诉在24小时内未解决,平台客服将介入判定</p>
            <p>
              3.平台客服QQ：<span>{{ siteConfig.site_info_qq }}</span>
            </p>
          </div>
          <div class="plaint-btn">
            <div class="cancel" @click="closeCard()">取消</div>
            <div class="submit" @click="submitPlaint()">提交投诉</div>
          </div>
        </div>
      </div>
    </template>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'PlaintDialog',
};
</script>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, onMounted, reactive, ref } from 'vue';

import { doComplaint } from '@/api/home/complaint';
import { useSiteStore } from '@/store';

// const plaintCount = ref(1200);

// const tsFrom = reactive({
//   tsPwd: '',
//   tsFor: '',
// });
const tsType = [
  {
    name: '不会使用',
    value: 1,
    tip: '',
    doc: '填写投诉原因,请说明具体哪个网站/软件/APP哪个部分操作出现了问题,需要什么帮助,为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '无效卡密',
    value: 2,
    tip: '',
    doc: '填写投诉原因,为保证投诉/售后处理速度,请尽量写详细些,20字以上',
  },
  {
    name: '涉嫌色情',
    value: 3,
    tip: '全额退款',
    doc: '填写投诉原因,请带上涉黄内容地址(如网页地址、公众号名称、APP名称等),为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '涉嫌赌博',
    value: 4,
    tip: '全额退款',
    doc: '填写投诉原因,请带上涉赌内容地址(如网页地址、公众号名称、APP名称等),为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '实名账号',
    value: 5,
    tip: '全额退款',
    doc: '填写投诉原因,请带上违规内容(如账号类型、网页地址、公众号名称、APP名称等),为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '盗版侵权',
    value: 6,
    tip: '',
    doc: '填写投诉原因,请带上盗版侵权内容地址(如网页地址、公众号名称、APP名称等),为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '欺诈骗钱',
    value: 7,
    tip: '',
    doc: '填写投诉原因,请带上违规内容(如网页地址、公众号名称、APP名称、QQ群等),为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '非法外挂',
    value: 8,
    tip: '',
    doc: '填写投诉原因,请携带外挂产品地址(如网页地址、公众号名称、APP名称等),请为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
  {
    name: '描述不符',
    value: 9,
    tip: '',
    doc: '填写投诉原因,请说明产品哪个部分描述不符,为保证投诉/售后处理速度,尽量写详细些,20字以上',
  },
];
const doc = ref('');
doc.value = tsType[0].doc;
const selectValue = ref(1);
const changeType = (val: number) => {
  doc.value = tsType.find((item) => item.value === val)?.doc || '';
  selectValue.value = val;
  params.type = tsType.find((item) => item.value === val)?.name || '';
};
const emit = defineEmits(['update:visible']);
const closeCard = () => {
  visible.value = false;
};
const noticeParent = () => {
  emit('update:visible', false);
};
const siteStore = useSiteStore();
const siteConfig = computed(() => siteStore.config);

const params = reactive({
  trade_no: '',
  type: '',
  qq: '',
  mobile: '',
  desc: '',
});
// 提交投诉
const submitPlaint = async () => {
  if (!params.trade_no) {
    MessagePlugin.error('请输入订单号');
    return;
  }
  if (!params.type) {
    MessagePlugin.error('请选择投诉类型');
    return;
  }
  if (!params.qq) {
    MessagePlugin.error('请输入QQ号');
    return;
  }
  if (!params.mobile) {
    MessagePlugin.error('请输入手机号');
    return;
  }
  if (!params.desc) {
    MessagePlugin.error('请输入投诉原因');
    return;
  }
  if (params.desc.length < 20) {
    MessagePlugin.error('投诉原因不能少于20字');
    return;
  }
  const data = {
    trade_no: params.trade_no,
    type: params.type,
    qq: params.qq,
    mobile: params.mobile,
    desc: params.desc,
  };
  const res = await doComplaint(data);
  if (res.code === 1) {
    MessagePlugin.success('投诉成功');
    // 3s后关闭
    setTimeout(() => {
      closeCard();
    }, 3000);
  } else {
    MessagePlugin.error(res.msg);
  }
};
const visible = ref(false);
onMounted(() => {
  visible.value = true;
});
</script>

<style lang="less" scoped>
:deep(.t-dialog--default) {
  padding: 1px;
}
:deep(.t-dialog__body) {
  padding: 0;
}
.plaint-mark {
  background-color: rgba(0, 0, 0, 0.32);
  z-index: 666;
}
.plaint-form {
  padding: 0 10px;
  box-sizing: border-box;
  background-color: #fff;
  .title {
    letter-spacing: 1px;
    img {
      margin-right: 20px;
    }
    div {
      display: inline-block;
      padding-bottom: 5px;
      h3 {
        font-size: 20px;
        font-weight: 800;
        color: var(--td-font-gray-1);
        i {
          font-size: 12px;
          text-decoration: none;
          font-style: normal;
          margin-left: 10px;
          font-weight: 400;
          color: var(--td-success-color-5);
          letter-spacing: 0.5px;
        }
      }
      p {
        font-size: var(--td-font-size-mark-medium);
        color: var(--td-font-gray-3);
      }
    }
  }
  .input_select_box {
    .title {
      display: block;
      margin: 20px 7px;
      span {
        &:first-child {
          font-weight: 700;
          font-size: 16px;
          color: var(--td-font-gray-1);
          text-align: left;
          float: left;
        }
        &:nth-child(2) {
          color: var(--td-font-gray-3);
          font-size: 12px;
          font-weight: 400;
          text-align: left;
          float: right;
        }
      }
    }
    text-align: center;
    .select_box {
      background: #fcfcfc;
      color: #999;
      border: 1px solid #f2f2f2;
      width: 31%;
      margin: 1%;
      display: inline-block;
      border-radius: 6px;
      line-height: var(--td-size-13);
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      position: relative;
      i {
        font-size: var(--td-font-size-link-small);
        position: absolute;
        width: 68px;
        display: inline-block;
        text-align: center;
        z-index: 99;
        font-style: normal;
        height: 20px;
        line-height: 20px;
        background: var(--td-error-color-5);
        color: #fff;
        border-radius: 999px;
        top: -12px;
        right: -15px;
        font-weight: 400;
        -webkit-box-shadow: 0 1px 1px 0 var(--td-error-color-5);
        box-shadow: 0 1px 1px 0 var(--td-error-color-5);
        border-radius: 10px 0 10px 0;
      }
      &.select {
        border: 1px solid var(--td-brand-color-6);
        background: #f9f9f9;
        color: var(--td-brand-color-6);
        font-weight: 700;
      }
    }
  }
  .item {
    position: relative;
    margin: 0 auto;
    &.phone {
      position: relative;
      div {
        position: absolute;
        top: 50%;
        right: 20px;
        color: var(--td-brand-color-6);
        font-weight: 700;
        cursor: pointer;
      }
    }
    img {
      position: absolute;
      &:first-child {
        top: 34px;
        left: 18px;
      }
      &:nth-child(2) {
        top: 36px;
        right: 18px;
        cursor: pointer;
      }
    }
    textarea {
      display: inline-block;
      width: 100%;
      height: 135px;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      border: 1px solid #f2f2f2;
      border-radius: 6px;
      background: #fcfcfc;
      padding: 13px 30px 21px 50px;
      margin-top: 16px;
      font-size: 13px;
      color: var(--td-font-gray-1);
      &::-webkit-input-placeholder {
        color: silver;
      }
      &:-ms-input-placeholder {
        color: silver;
      }
    }
    input {
      display: inline-block;
      width: 100%;
      height: 50px;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      border: 1px solid #f2f2f2;
      border-radius: 6px;
      background: #fcfcfc;
      padding: 0 50px;
      margin-top: 16px;
      color: var(--td-font-gray-1);
      &::-webkit-input-placeholder {
        color: silver;
      }
      &:-ms-input-placeholder {
        color: silver;
      }
    }
  }
  .waring_tips {
    font-size: 14px;
    font-weight: 600;
    color: #3259ff;
    margin-top: 12px;
    line-height: 1;
    img {
      vertical-align: text-bottom;
    }
  }
  .plaint-p {
    margin-top: 12px;
    margin-left: 5px;

    letter-spacing: 0.5px;
    font: var(--td-font-body-small);
    p {
      font-size: 13px;
      line-height: 20px;
    }
    span {
      color: #3259ff;
      cursor: pointer;
    }
  }
  .plaint-btn {
    margin-top: 18px;
    text-align: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    .cancel {
      color: #999;
      margin-left: 1px;
    }
    .submit {
      color: #fcfcfc;
      -webkit-box-shadow: 0 3px 9px 0 rgba(51, 107, 255, 0.26);
      box-shadow: 0 3px 9px 0 rgba(51, 107, 255, 0.26);
      background: var(--td-brand-color-7);
      margin-right: 1px;
    }
  }
}
.plaint-form .item textarea:-moz-placeholder,
.plaint-form .item textarea::-moz-placeholder,
.plaint-form .item input:-moz-placeholder,
.plaint-form .item input::-moz-placeholder {
  color: silver;
}
.plaint-form .plaint-btn .cancel,
.plaint-form .plaint-btn .submit {
  width: 169px;
  height: 50px;
  border: 1px solid #e4ebf3;
  border-radius: 6px;
  text-align: center;
  font-size: 18px;
  font-weight: 400;
  letter-spacing: 2px;
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
}
</style>

<template>
  <t-card title="添加库存" class="basic-container" :bordered="false">
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/goods/card')">
        <template #icon><t-icon name="rollback" /></template>
        返回
      </t-button>
    </template>
    <!-- 表单内容 -->
    <t-form ref="form" class="base-form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="150" @submit="onSubmit">
      <t-form-item label="选择商品" name="goods_id">
        <t-select v-model="formData.goods_id" placeholder="请选择商品" :options="goodsList" :keys="{ value: 'id', label: 'name' }" :style="{ width: '800px' }" />
      </t-form-item>

      <t-form-item label="插入方式" name="order_type" help="">
        <wp-check-tag v-model="formData.order_type" :items="orderType" />
      </t-form-item>

      <t-form-item label="导入方式" name="import_type" help="">
        <wp-check-tag v-model="formData.import_type" :items="importType" />
      </t-form-item>

      <t-form-item label="导入格式" name="split_type">
        <wp-check-tag v-model="formData.split_type" :items="splitType" @actions="changeSplitType" />
      </t-form-item>

      <t-form-item v-if="formData.import_type === 1" label="虚拟卡内容" name="content" :style="{ width: '960px' }">
        <t-textarea v-model="formData.content" :placeholder="textareaPlaceholder" :style="{ height: '400px' }" tips="除了名称和内容之间有空格 其他地方不允许有空格 手动输入一次最多添加500张" />
      </t-form-item>

      <t-form-item v-if="formData.import_type === 2" label="TXT文件" name="file" help="">
        <t-upload v-model="formData.files" accept="text/plain" theme="custom" :auto-upload="false" :abridge-name="[10, 8]" draggable @progress="onProgress">
          <template #dragContent="params">
            <ul v-if="formData.files && formData.files.length" style="padding: 0">
              <li v-for="file in formData.files" :key="file.name" style="list-style-type: none">{{ file.name }}</li>
            </ul>
            <template v-else>
              <p v-if="params && params.dragActive">释放鼠标</p>
              <t-link v-else-if="progress < 1">拖拽文件至此或点击上传文件</t-link>
            </template>
            <t-button v-if="formData.files && formData.files.length" size="small" style="margin-top: 36px">更换文件</t-button>
            <!-- <span>数据状态：{{params}}</span> -->
          </template>
        </t-upload>
      </t-form-item>

      <t-form-item label="卡密前缀" name="is_pre" help="">
        <wp-check-tag v-model="formData.is_pre" :items="statusType" />
      </t-form-item>

      <t-form-item label="检查重复" name="check_card" help="">
        <wp-check-tag v-model="formData.check_card" :items="statusType" />
      </t-form-item>

      <t-form-item>
        <t-button theme="primary" class="form-submit-confirm" type="submit"> 提交 </t-button>
      </t-form-item>
    </t-form>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'GoodsCardAdd',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { add } from '@/api/merchant/goods/card';
import { goodList } from '@/api/merchant/goods/good';

const importType = [
  {
    label: '手动输入',
    value: 1,
  },
  {
    label: 'txt文件',
    value: 2,
  },
];

const splitType = [
  {
    label: '仅卡密',
    value: '',
  },
  {
    label: '卡号+逗号+卡密',
    value: ',',
  },
  {
    label: '卡号+“|”+卡密',
    value: '|',
  },
  {
    label: '卡号+“----”+卡密',
    value: '----',
  },
  {
    label: '卡号+____”+卡密',
    value: '_____',
  },
];

const orderType = [
  {
    label: '顺序插入',
    value: 1,
  },
  {
    label: '随机插入',
    value: 2,
  },
];

const statusType = [
  {
    label: '关闭',
    value: 0,
  },
  {
    label: '开启',
    value: 1,
  },
];

const router = useRouter();

const formData = reactive({
  goods_id: null,
  order_type: 1,
  import_type: 1,
  split_type: ',',
  files: [],
  is_pre: 0,
  check_card: 0,
  content: '',
});

const { query } = router.currentRoute.value as any;
Object.keys(query).forEach((key) => {
  if ((formData as any)[key] !== undefined) {
    (formData as any)[key] = Number(query[key]);
  }
});

const goodsList = ref([]);
const initGoodsList = async () => {
  const { data } = await goodList();
  goodsList.value = data;
};
const form = ref(null);
const FORM_RULES: Record<string, FormRule[]> = {
  goods_id: [{ required: true, message: '请选择商品', type: 'error' }],
  content: [{ required: true, message: '请输入虚拟卡内容', type: 'error' }],
  split_type: [{ required: false, message: '请选择导入格式', type: 'error' }],
};

const textareaPlaceholder = ref('请输入虚拟卡内容');
const changeSplitType = (e: any) => {
  if (e === ',') {
    textareaPlaceholder.value = `请输入虚拟卡内容，每行一个
    例如：
    卡号1111,卡密2222
    卡号3333,卡密4444`;
  } else if (e === '|') {
    textareaPlaceholder.value = `请输入虚拟卡内容，每行一个
    例如：
    卡号1111|卡密2222
    卡号3333|卡密4444`;
  } else if (e === '----') {
    textareaPlaceholder.value = `请输入虚拟卡内容，每行一个
    例如：
    卡号1111----卡密2222
    卡号3333----卡密4444`;
  } else if (e === '_____') {
    textareaPlaceholder.value = `请输入虚拟卡内容，每行一个
    例如：
    卡号1111_____卡密2222
    卡号3333_____卡密4444`;
  } else if (e === '') {
    textareaPlaceholder.value = `请输入虚拟卡内容，每行一个
    （卡号卡密是写在一起的形式，或者只有卡密、卡号）
    例如：
    卡号1111卡密2222
    卡号3333卡密4444
    卡密4444
    卡密5555555555`;
  }
};
onMounted(() => {
  initGoodsList();
});

const onSubmit = async () => {
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    const submitForm = {
      ...formData,
    };
    try {
      const result = await add(submitForm);
      if (result.code === 1) {
        MessagePlugin.success('新增成功');
        router.push('/merchant/goods/card');
      } else {
        MessagePlugin.error(`新增失败：${result.msg}`);
      }
    } catch (error) {
      MessagePlugin.error('新增失败');
    }
  }
};
const progress = ref(0);
const onProgress = (val: any) => {
  progress.value = val;
};
</script>

<style lang="less" scoped>
:deep(.t-upload__dragger) {
  width: 800px;
  height: 300px;
}
:deep(.t-input__help) {
  font-size: 11px;
  color: rgb(153, 153, 153);
  margin: 11px 0;
}
:deep(.t-textarea__inner) {
  height: 300px;
}
</style>

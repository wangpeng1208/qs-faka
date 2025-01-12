<template>
  <t-dialog v-model:visible="visible" theme="info" :close-on-overlay-click="false" header="用户注册协议和隐私政策" :close-btn="false" placement="top" confirm-btn="同意签署" cancel-btn="拒绝" :on-confirm="accept" :on-cancel="reject" width="900px">
    <template #body>
      <div class="content" v-html="agreement"></div>
      <!-- <t-link theme="primary" hover="color" blank="_target" @click="goArticlePage('article', siteConfig.goods_release_id)">《商品发布条例》</t-link>
      <t-link theme="primary" hover="color" blank="_target" @click="goArticlePage('article', siteConfig.register_agreement_id)">《用户注册协议》 </t-link>
      <t-link theme="primary" hover="color" blank="_target" @click="goArticlePage('article', siteConfig.privacy_policy_id)">《用户隐私政策》</t-link> -->

      <t-link theme="primary" hover="color" target="_blank" :href="siteConfig.goods_release_id">《商品发布条例》</t-link>
      <t-link theme="primary" hover="color" target="_blank" :href="siteConfig.register_agreement_id">《用户注册协议》 </t-link>
      <t-link theme="primary" hover="color" target="_blank" :href="siteConfig.privacy_policy_id">《用户隐私政策》</t-link>
    </template>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'AgreementPage',
};
</script>
<script setup lang="ts">
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

import { useSiteStore } from '@/store';

const router = useRouter();
const siteStore = useSiteStore();

const agreement = `
      <p>【审慎阅读】您在申请注册流程中点击同意前，应当认真阅读以下协议。请您务必审慎阅读、充分理解协议中相关条款内容，其中包括： </p> <p>1、与您约定免除或限制责任的条款； </p>
      <p>2、与您约定法律适用和管辖的条款； </p> 
      <p>3、其他以粗体下划线标识的重要条款。</p> 
      <p>如您对协议有任何疑问，可向平台客服咨询。当您按照注册页面提示填写信息、阅读并同意协议且完成全部注册程序后，即表示您已充分阅读、理解并接受协议的全部内容。如您因平台服务与本站发生争议的，适用《平台服务协议》处理。如您在使用平台服务过程中与其他用户发生争议的，依您与其他用户达成的协议处理。</p>
      <p>阅读协议的过程中，如果您不同意相关协议或其中任何条款约定，您应立即停止注册程序。</p>
      <p>【特别提示】您在注册之前，应当认真阅读并遵守《平台服务协议》及《平台隐私政策》等相关协议和规则，您点击同意本协议的，即视为您已阅读并同意上述协议和规则。</p>
  `;
const reject = () => {
  router.push({ path: '/' });
};

const emit = defineEmits(['success']);

const accept = () => {
  visible.value = false;
  emit('success');
};

const siteConfig = computed(() => siteStore.config);
const visible = ref(false);
const init = (val: boolean) => {
  visible.value = !val;
};

defineExpose({
  init,
});
</script>
<style lang="less" scoped>
.content {
  line-height: 30px;
}
</style>

<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :close-on-esc-keydown="false" :footer="false" width="80%" top="20px">
    <template #header>
      <div class="dialog-title">选择图标</div>
    </template>

    <div class="icon-grid">
      <div v-for="item in options" :key="item.stem" class="item" :class="{ active: icon === item.stem }" @click="check(item.stem)">
        <icon-font :name="`t-icon t-icon-${item.stem}`" :url="CDN_CSS" />
      </div>
    </div>
  </t-dialog>
</template>
<script setup lang="ts" name="MerchantMenuIcon">
import { IconFont } from 'tdesign-icons-vue-next';
import { manifest } from 'tdesign-icons-vue-next/lib/manifest'; // 只拿列表，不引入组件
import { ref } from 'vue';

const emit = defineEmits(['success']);

const CDN_CSS = 'https://tdesign.gtimg.com/icon/0.4.0/fonts/index.css';

const options = ref(manifest);
const visible = ref(false);
const icon = ref('');

const init = (ficon = '') => {
  icon.value = ficon;
  visible.value = true;
};

const check = (name: string) => {
  emit('success', name);
  visible.value = false;
};

defineExpose({ init });
</script>
<style lang="less" scoped>
.icon-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, 60px);
  gap: 5px;
  padding: 5px;
}
.item {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #f0f0f0;
  cursor: pointer;
  font-size: 28px;
  transition: all 0.3s;
  &.active {
    border: 3px solid #409eff;
  }
}
</style>

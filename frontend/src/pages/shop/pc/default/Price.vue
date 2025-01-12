<template>
  <t-dialog :visible="visible" :draggable="true" width="450" :close-on-overlay-click="true" :header="false" :cancel-btn="null" :on-confirm="closeDg" :close-btn="false">
    <template #body>
      <!-- detail -->
      <div class="info-block">
        <div class="info-item">数量* 单价 ：{{ formData.quantity }} * {{ price }} = {{ formData.quantity * price }}</div>

        <div v-if="smsPrice" class="info-item">短信费用：0.1</div>

        <div class="info-item">数量* 单价 ：{{ formData.quantity }} * {{ price }} = {{ formData.quantity * price }}</div>
      </div>
    </template>
  </t-dialog>
</template>

<script setup lang="ts">
import { toRefs } from 'vue';

const props = defineProps<{
  formData: any;
  price: any;
  smsPrice: any;
  visible: boolean;
}>();

const { formData, price, smsPrice, visible } = toRefs(props);
// 将visible变成响应式的
const emits = defineEmits(['update-show']);

const closeDg = () => {
  emits('update-show', false);
};
</script>

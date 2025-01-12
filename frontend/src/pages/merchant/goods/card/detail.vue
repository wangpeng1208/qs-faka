<template>
  <t-dialog v-model:visible="visible" width="600" :close-on-overlay-click="false" header="查看卡密" :on-confirm="onConfirm">
    <template #body>
      <div class="info-block">
        <div class="info-item">
          <h1>卡号：</h1>
          {{ row.number }}
        </div>
        <div class="info-item">
          <h1>卡密：</h1>
          {{ row.secret }}
        </div>
        <div class="info-item">
          <h1>卡密前缀：</h1>
          <p v-if="row.is_pre === 1">显示</p>
          <p v-else>不显示</p>
        </div>
      </div>
    </template>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'CardDetail',
};
</script>
<script setup lang="ts" default-name="Detail">
import { ref } from 'vue';

const row = ref({
  number: '',
  secret: '',
  is_pre: 0,
});

const visible = ref(false);

const init = (rowData: any) => {
  visible.value = true;
  row.value = { ...rowData };
};

const onConfirm = () => {
  visible.value = false;
};

defineExpose({
  init,
});
</script>

<style lang="less" scoped>
.info-block {
  column-count: 1;

  .info-item {
    padding: 12px 0;
    display: flex;
    color: var(--td-text-color-primary);

    h1 {
      width: 100px;
      font-weight: normal;
      font: var(--td-font-body-medium);
      color: var(--td-text-color-secondary);
      text-align: left;
      line-height: 22px;

      @media (max-width: @screen-sm-max) {
        width: 100px;
      }

      @media (min-width: @screen-md-min) and (max-width: @screen-md-max) {
        width: 120px;
      }
    }
  }
}
</style>

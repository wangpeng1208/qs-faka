<template>
  <t-space>
    <t-check-tag v-for="(item, index) in items" v-bind="$attrs" :key="index" :size="size" :variant="variant" :checked="item.value == checkedValue" @change="changeTag(item.value)">
      {{ item.label }}
    </t-check-tag>
  </t-space>
</template>

<script setup lang="ts">
import { SizeEnum } from 'tdesign-vue-next';
import { ref, watch } from 'vue';

interface Item {
  label: string;
  value: number;
}

const props = defineProps({
  items: {
    type: Array as () => Item[],
    required: true,
  },
  modelValue: {
    type: [String, Number, Array],
    required: true,
  },
  size: {
    type: String as () => SizeEnum,
    default: 'medium',
  },
  variant: {
    type: String,
    default: 'light-outline',
  },
});

const { items } = props;

const checkedValue = ref();
watch(
  () => props.modelValue,
  (newVal) => {
    if (Array.isArray(newVal)) {
      if (newVal.length > 0) {
        checkedValue.value = 1;
      } else {
        checkedValue.value = 0;
      }
    } else {
      checkedValue.value = newVal;
    }
  },
  { immediate: true },
);
const emit = defineEmits(['actions', 'update:modelValue']);
const changeTag = (value: number) => {
  checkedValue.value = value;
  if (Array.isArray(props.modelValue)) {
    emit('actions', value);
  } else {
    emit('actions', value);
    emit(`update:modelValue`, value);
  }
};
</script>

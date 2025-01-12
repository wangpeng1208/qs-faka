<template>
  <t-upload v-bind="$attrs" v-model="files" :action="imgUploadUrl" :headers="uploadHeader" :theme="theme" :accept="acceptValue" :format-response="formatResponse" clearable @remove="remove" />
</template>
<script lang="ts">
export default {
  name: 'WpUpload',
};
</script>

<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref, toRefs, watchEffect } from 'vue';

import { adminUpload, baseUrl, merchantUpload } from '@/api/admin/config/config';

const props = defineProps({
  theme: String as () => 'image' | 'file' | 'custom' | 'file-input' | 'file-flow' | 'image-flow',
  initial: Object,
  name: String,
  app: String,
  accept: String,
});
const { accept, app, theme } = toRefs(props);
const acceptValue = ref(accept.value);
const files = ref();

watchEffect(() => {
  // 如果 props.initial[props.name] 以http开头，则直接使用
  let url;
  if (props.initial[props.name] && props.initial[props.name].startsWith('http')) {
    url = props.initial[props.name];
  } else {
    url = baseUrl + props.initial[props.name];
  }
  if (props.initial && props.name && props.initial[props.name]) {
    switch (props.theme) {
      case 'image':
        acceptValue.value = 'image/*';
        files.value = [
          {
            // name: props.initial[props.name],
            url,
          },
        ];
        break;
      case 'file':
        acceptValue.value = 'file/*';
        files.value = [
          {
            name: props.initial[props.name],
            url,
          },
        ];
        break;
      case 'custom':
        files.value = [
          {
            name: props.initial[props.name],
            url,
          },
        ];
        break;
      case 'file-input':
        files.value = [
          {
            name: props.initial[props.name],
            url,
          },
        ];
        break;
      case 'file-flow':
        files.value = [
          {
            name: props.initial[props.name],
            url,
          },
        ];
        break;
      case 'image-flow':
        files.value = [
          {
            url,
          },
        ];
        break;
      default:
        acceptValue.value = 'image/*';
        files.value = [
          {
            url,
          },
        ];
    }
  } else {
    files.value = [];
  }
});
const emit = defineEmits(['update']);
const formatResponse = (res: any) => {
  if (res.code === 0) {
    MessagePlugin.error(res.msg);
    return null;
  }
  if (props.initial && props.name) {
    emit('update', { name: props.name, url: res.data.url });
  }

  return res.data;
};
const remove = () => {
  emit('update', { name: props.name, url: '' });
};
// 上传接口及请求头
const imgUploadUrl = ref();
// 上传类型
const initUploadUrl = () => {
  switch (app.value) {
    case 'admin':
      imgUploadUrl.value = `${baseUrl}${adminUpload}`;
      break;
    case 'merchant':
      imgUploadUrl.value = `${baseUrl}${merchantUpload}`;
      break;
    default:
      imgUploadUrl.value = `${baseUrl}${merchantUpload}`;
  }
};
initUploadUrl();
const user = localStorage.getItem(app.value);
const { accessToken: token } = JSON.parse(user);
const uploadHeader = ref({});
if (app.value !== undefined) {
  uploadHeader.value = {
    Authorization: `Bearer ${token}`,
  };
}
</script>

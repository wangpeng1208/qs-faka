<template>
  <t-dialog v-model:visible="visible" :header="title" width="800px" :destroy-on-close="true" :close-on-overlay-click="false">
    <div class="log-detail-container">
      <!-- 基本信息 -->
      <t-card title="基本信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">用户名</div>
            <div class="value">{{ logData.username }}</div>
          </div>
          <div class="info-item">
            <div class="label">访问链接</div>
            <div class="value">{{ logData.action }}</div>
          </div>
          <div class="info-item">
            <div class="label">IP地址</div>
            <div class="value">{{ logData.ip }}</div>
          </div>
          <div class="info-item">
            <div class="label">日志时间</div>
            <div class="value">{{ logData.create_at }}</div>
          </div>
        </div>
      </t-card>

      <!-- 请求参数 -->
      <t-card title="请求参数" class="detail-card">
        <div class="code-container">
          <pre class="code-block">{{ formatJson(logData.params) }}</pre>
        </div>
      </t-card>

      <!-- 返回结果 -->
      <t-card title="返回结果" class="detail-card">
        <div class="code-container">
          <pre class="code-block">{{ formatJson(logData.content) }}</pre>
        </div>
      </t-card>
    </div>

    <template #footer>
      <t-button theme="default" @click="visible = false">关闭</t-button>
    </template>
  </t-dialog>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';

const title = ref('日志详情');
const visible = ref(false);
const logData = reactive<any>({});

const init = (row: any) => {
  visible.value = true;
  Object.assign(logData, row);
};

const formatJson = (data: any) => {
  if (!data) return '无数据';

  try {
    // 如果是字符串，尝试解析为JSON
    if (typeof data === 'string') {
      const parsed = JSON.parse(data);
      return JSON.stringify(parsed, null, 2);
    }
    // 如果是对象，直接格式化
    return JSON.stringify(data, null, 2);
  } catch (error) {
    // 如果解析失败，返回原始字符串
    return data.toString();
  }
};

defineExpose({
  init,
});
</script>

<style scoped>
.log-detail-container {
  padding: 0;
}

.detail-card {
  margin-bottom: 16px;
  border: 1px solid #e7e7e7;
}

.detail-card:last-child {
  margin-bottom: 0;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px 24px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.label {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}

.value {
  font-size: 14px;
  color: #333;
  word-break: break-all;
}

.code-container {
  background-color: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 4px;
  padding: 16px;
  max-height: 300px;
  overflow-y: auto;
}

.code-block {
  margin: 0;
  font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
  font-size: 12px;
  line-height: 1.5;
  color: #333;
  white-space: pre-wrap;
  word-break: break-all;
}

@media (max-width: 768px) {
  .info-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
}
</style>

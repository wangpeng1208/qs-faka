<template>
  <t-row
    :gutter="[
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 40 },
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 40 },
    ]"
  >
    <t-col :span="3">
      <t-card title="商户今日流水排行" hover-shadow>
        <t-list :split="true">
          <t-list-item>
            <span style="width: 20%">排名</span>
            <span style="width: 45%">商户名称</span>
            <span style="width: 33%">交易额</span>
          </t-list-item>
          <t-list-item v-for="(item, index) in dayRank" :key="index">
            <span style="width: 20%">{{ index + 1 }}</span>
            <span style="width: 45%">{{ item.username }}</span>
            <span style="width: 33%">{{ item.transaction_money }}</span>
          </t-list-item>
        </t-list>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="商户周流水排行" hover-shadow>
        <t-list :split="true">
          <t-list-item>
            <span style="width: 20%">排名</span>
            <span style="width: 45%">商户名称</span>
            <span style="width: 33%">交易额</span>
          </t-list-item>
          <t-list-item v-for="(item, index) in weekRank" :key="index">
            <span style="width: 20%">{{ index + 1 }}</span>
            <span style="width: 45%">{{ item.username }}</span>
            <span style="width: 33%">{{ item.transaction_money }}</span>
          </t-list-item>
        </t-list>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="商户月流水排行" hover-shadow>
        <t-list :split="true">
          <t-list-item>
            <span style="width: 20%">排名</span>
            <span style="width: 45%">商户名称</span>
            <span style="width: 33%">交易额</span>
          </t-list-item>
          <t-list-item v-for="(item, index) in monthRank" :key="index">
            <span style="width: 20%">{{ index + 1 }}</span>
            <span style="width: 45%">{{ item.username }}</span>
            <span style="width: 33%">{{ item.transaction_money }}</span>
          </t-list-item>
        </t-list>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="总流水排行" hover-shadow>
        <t-list :split="true">
          <t-list-item>
            <span style="width: 20%">排名</span>
            <span style="width: 45%">商户名称</span>
            <span style="width: 33%">交易额</span>
          </t-list-item>
          <t-list-item v-for="(item, index) in allRank" :key="index">
            <span style="width: 20%">{{ index + 1 }}</span>
            <span style="width: 45%">{{ item.username }}</span>
            <span style="width: 33%">{{ item.transaction_money }}</span>
          </t-list-item>
        </t-list>
      </t-card>
    </t-col>
  </t-row>
</template>
<script setup lang="ts">
import { ref } from 'vue';

// import { userCollectionRank, userCollectionRankParams } from '@/api/admin/workbench';
import { userCollectionRank } from '@/api/admin/workbench';

const dayRank = ref([]);
const weekRank = ref([]);
const monthRank = ref([]);
const allRank = ref([]);
const fetchData = async () => {
  const res = await userCollectionRank();
  dayRank.value = res.data.today;
  weekRank.value = res.data.week;
  monthRank.value = res.data.month;
  allRank.value = res.data.all;
};
fetchData();
</script>
<style scoped>
:deep(.t-list-item) {
  padding: var(--td-comp-paddingTB-m) 0;
}
</style>

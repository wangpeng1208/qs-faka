import { computed, ref } from 'vue';

import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

const store = useSettingStore();
interface Options {
  fetchFun: (_arg: any) => Promise<any>;
  params?: Record<any, any>;
}

export function table(options: Options) {
  const { fetchFun, params = {} } = options;
  const dataLoading = ref(false);
  const lists = ref();
  const pagination = ref({
    current: 1,
    pageSize: 20,
    total: 0,
  });
  const fetchData = async () => {
    dataLoading.value = true;
    const value = {
      page: pagination.value.current,
      limit: pagination.value.pageSize,
      ...params,
    };
    const { data } = await fetchFun(value);
    lists.value = data.list;
    pagination.value = {
      ...pagination.value,
      total: data.total,
    };
    dataLoading.value = false;
  };
  const headerAffixedTop = computed(() => ({
    offsetTop: store.isUseTabsRouter ? 48 : 0,
    container: `.${prefix}-layout`,
  }));

  const rehandlePageChange = (curr: any) => {
    pagination.value.current = curr.current;
    pagination.value.pageSize = curr.pageSize;
    fetchData();
  };
  const searchData = async () => {
    pagination.value.current = 1;
    await fetchData();
  };
  return {
    pagination,
    fetchData,
    dataLoading,
    headerAffixedTop,
    rehandlePageChange,
    lists,
    searchData,
  };
}

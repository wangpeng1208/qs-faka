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
    defaultPageSize: 20,
    total: 0,
    defaultCurrent: 1,
  });
  const fetchData = async () => {
    dataLoading.value = true;
    const value = {
      page: pagination.value.defaultCurrent,
      limit: pagination.value.defaultPageSize,
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
    pagination.value.defaultCurrent = curr.current;
    pagination.value.defaultPageSize = curr.pageSize;
    fetchData();
  };
  const searchData = async () => {
    pagination.value.defaultCurrent = 1;
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

import { computed } from 'vue';
import { useRoute } from 'vue-router';

export const usePageName = () => {
  const route = useRoute();

  const pageName = computed(() => {
    return (route.meta.title as string) || '';
  });

  return pageName;
};

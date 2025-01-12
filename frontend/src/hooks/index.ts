import * as echarts from 'echarts/core';
import { onMounted, onUnmounted, Ref, ref } from 'vue';

/**
 * eChart hook
 * @param domId
 * @param chart
 */
export const useChart = (domId: string): Ref<echarts.ECharts> => {
  let chartContainer: HTMLCanvasElement;
  const selfChart = ref<echarts.ECharts | any>();
  const updateContainer = () => {
    // TODO resize 报错，响应式的问题，待处理
    selfChart.value.resize({
      width: chartContainer.clientWidth,
      height: chartContainer.clientHeight,
    });
  };

  onMounted(() => {
    if (!chartContainer) {
      chartContainer = document.getElementById(domId) as HTMLCanvasElement;
    }
    selfChart.value = echarts.init(chartContainer);
  });

  window.addEventListener('resize', updateContainer, false);

  onUnmounted(() => {
    window.removeEventListener('resize', updateContainer);
  });

  return selfChart;
};

/**
 * counter utils
 * @param duration
 * @returns
 */
export const useCounter = (duration = 60): [Ref<number>, () => void] => {
  let intervalTimer: ReturnType<typeof setInterval>;
  onUnmounted(() => {
    clearInterval(intervalTimer);
  });
  const countDown = ref(0);

  return [
    countDown,
    () => {
      countDown.value = duration;
      intervalTimer = setInterval(() => {
        if (countDown.value > 0) {
          countDown.value -= 1;
        } else {
          clearInterval(intervalTimer);
          countDown.value = 0;
        }
      }, 1000);
    },
  ];
};

/**
 * counter utils
 * @param expireAt 时间倒计时
 * [倒计时字符串, 清除定时器方法]
 */
export const expireTime = (): [Ref<string>, (expireAt: number) => void, () => void] => {
  let intervalTimer: ReturnType<typeof setInterval>;
  onUnmounted(() => {
    clearInterval(intervalTimer);
  });
  const countDown = ref('');
  const clearTimer = () => {
    clearInterval(intervalTimer);
  };
  return [
    countDown,
    async (expireAt: number) => {
      const endTime = new Date(expireAt).getTime();
      intervalTimer = await setInterval(() => {
        const now = Date.now();
        const diff = endTime - now;
        if (diff > 0) {
          const seconds = Math.floor((diff / 1000) % 60);
          const minutes = Math.floor((diff / 1000 / 60) % 60);
          const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
          const days = Math.floor(diff / (1000 * 60 * 60 * 24));
          countDown.value = `${days}天${hours}时${minutes}分${seconds}秒`;
        } else {
          clearInterval(intervalTimer);
          countDown.value = '已结束';
        }
      }, 1000);
    },
    clearTimer,
  ];
};

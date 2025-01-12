// 获取常用时间
import dayjs from 'dayjs';
import type { DateRangeValue } from 'tdesign-vue-next/es/date-picker/type';

export const LAST_7_DAYS: DateRangeValue = [dayjs().subtract(7, 'day').format('YYYY-MM-DD'), dayjs().subtract(1, 'day').format('YYYY-MM-DD')];

export const LAST_30_DAYS: DateRangeValue = [dayjs().subtract(30, 'day').format('YYYY-MM-DD'), dayjs().subtract(1, 'day').format('YYYY-MM-DD')];

// 年月日日分秒
export const YYYY_MM_DD_HH_MM_SS = 'YYYY-MM-DD HH:mm:ss';
// export const YYYY_MM_DD_HH_MM_SS = 'YYYY-MM-DD';

// 10位时间戳转换为年月日日分秒
export const formatTime = (time: any, format = YYYY_MM_DD_HH_MM_SS) => {
  // 如果是null
  if (!time) return '';
  // 如果time是时间格式的话不需要转换
  if (typeof time !== 'number') {
    return dayjs(time).format(format);
  }
  // 如果是数字的话转换为时间格式
  return dayjs(time * 1000).format(format);
};

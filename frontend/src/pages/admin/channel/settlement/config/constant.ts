const hours = (() => {
  const result = [];
  for (let i = 0; i < 24; i++) {
    result.push({
      label: `${i}时`,
      value: i,
    });
  }
  return result;
})();

export { hours };

export const settlementType = [
  {
    label: 'T1结算',
    value: 1,
  },
  {
    label: 'T0结算',
    value: 0,
  },
];
export const statusOptions = [
  {
    label: '开启',
    value: 1,
  },
  {
    label: '关闭',
    value: 0,
  },
];
export const cashTypeOptions = [
  {
    label: '支付宝收款',
    value: 1,
  },
  {
    label: '微信收款',
    value: 2,
  },
  {
    label: '银行卡收款',
    value: 3,
  },
];

export const cashFeeTypeOptions = [
  {
    label: '百分比',
    value: 100,
  },
  {
    label: '固定金额',
    value: 1,
  },
];
export const settlementFreezeEndtimeOptions = [
  {
    label: '截止今日24:00',
    value: 1,
  },
  {
    label: '订单完成时间+ 24小时',
    value: 2,
  },
];

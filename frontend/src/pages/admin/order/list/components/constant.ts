import { DialogPlugin, MessagePlugin, PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';

import { freeze, notify } from '@/api/admin/order/order';
import { formatTime } from '@/utils/date';

interface StatusOption {
  value: number;
  label: string;
  theme: 'default' | 'primary' | 'warning' | 'danger' | 'success';
}

export const statusOptions: StatusOption[] = [
  {
    label: '未支付',
    value: 0,
    theme: 'warning',
  },
  {
    label: '已支付',
    value: 1,
    theme: 'success',
  },
  {
    label: '已关闭',
    value: 2,
    theme: 'danger',
  },

  {
    label: '已退款',
    value: 3,
    theme: 'warning',
  },
];

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    width: '160px',
    colKey: 'trade_no',
    title: '订单号',
    fixed: 'left',
  },
  {
    colKey: 'merchant_info',
    width: '200px',
    title: '商户信息',
    cell: (h, { row }) => {
      return h('div', { class: 'merchant-info-cell' }, [h('div', { style: 'font-weight: 500; color: #0052d9; margin-bottom: 2px; font-size: 12px;' }, `店铺: ${row.shop.shop_name}`), h('div', { style: 'color: #333; margin-bottom: 2px; font-size: 12px;' }, `商品: ${row.goods_name}`), h('div', { style: 'color: #666; font-size: 12px;' }, `商户: ${row.user.username}`)]);
    },
  },
  {
    colKey: 'buyer_info',
    width: '180px',
    title: '买家资料',
    cell: (h, { row }) => {
      return h('div', { class: 'buyer-info-cell' }, [h('div', { style: 'color: #333; margin-bottom: 2px; font-size: 12px;' }, `联系: ${row.contact}`), h('div', { style: 'color: #666; font-size: 12px;' }, [`购买: ${row.quantity}件 `, h('span', { style: 'color: #e37318; font-weight: 500;' }, `¥${row.total_price}`)])]);
    },
  },
  {
    colKey: 'status_info',
    width: '140px',
    title: '状态信息',
    cell: (h, { row }) => {
      const statusOption = statusOptions.find((t) => t.value === row.status);
      const statusTag = h(
        Tag,
        {
          theme: statusOption.theme,
          variant: 'light',
          size: 'small',
        },
        () => statusOption?.label,
      );

      const cardTag = h(
        Tag,
        {
          theme: row.cards_count === row.quantity ? 'success' : 'warning',
          variant: 'light',
          size: 'small',
          style: 'margin-top: 4px;',
        },
        () => {
          if (row.cards_count === 0) return '未取卡';
          if (row.cards_count === row.quantity) return '已取卡';
          return '部分取卡';
        },
      );

      return h('div', { class: 'status-info-cell' }, [statusTag, cardTag]);
    },
  },
  {
    width: '140px',
    colKey: 'create_at',
    title: '下单时间',
    cell: (h, { row }) => formatTime(row.create_at),
  },
  {
    width: '60px',
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];

const handleAction = (row: TableRowData, action: Function, message: string) => {
  const confirmDialog = DialogPlugin.confirm({
    header: '提醒',
    body: message,
    confirmBtn: {
      content: '提交',
      theme: 'primary',
      loading: false,
    },
    closeOnOverlayClick: false,
    onConfirm: async () => {
      const res = await action({
        id: row.id,
      });
      if (res.code === 1) {
        MessagePlugin.success(res.msg);
        // 刷新单行列表数据
        row = Object.assign(row, res.data);
        confirmDialog.hide();
      } else {
        MessagePlugin.error(res.msg);
      }
    },
  });
};

export const hadleFreeze = (row: TableRowData) => {
  let content;
  if (row.is_freeze === 1) {
    content = `确认要解冻吗？`;
  } else {
    content = `确认要冻结吗？此处用于存在投诉争议的订单，手工冻结。冻结后，该订单将不会被自动退款，也不会被自动结算。`;
  }
  handleAction(row, freeze, content);
};

export const handleNotifyExport = (row: TableRowData) => {
  handleAction(row, notify, '确认要设置这个订单已支付吗？该操作不可恢复');
};

// 操作菜单处理函数
export const createOperateDropdown = (row: TableRowData, onDetail: (row: TableRowData) => void, onDelete: (row: TableRowData) => void, onNotify: (row: TableRowData) => void, onFreeze: (row: TableRowData) => void) => {
  const options = [
    {
      content: '详情',
      value: 'detail',
      onClick: () => onDetail(row),
    },
  ];

  // 根据订单状态添加补单选项
  if (row.status === 0) {
    options.push({
      content: '补单',
      value: 'notify',
      onClick: () => onNotify(row),
    });
  }

  // 根据订单状态添加冻结/解冻选项
  if (row.status === 1) {
    options.push({
      content: row.is_freeze ? '解冻' : '冻结',
      value: 'freeze',
      onClick: () => onFreeze(row),
    });
  }

  // 添加删除选项
  options.push({
    content: '删除',
    value: 'delete',
    onClick: () => onDelete(row),
  });

  return options;
};

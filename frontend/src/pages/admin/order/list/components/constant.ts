import { Button, DialogPlugin, Link, MessagePlugin, PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';
import { VNode } from 'vue';

import { freeze, notify, refund } from '@/api/admin/order/order';
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
    width: '180px',
    colKey: 'trade_no',
    title: '订单号',
    fixed: 'left',
  },
  {
    colKey: 'shop_name',
    width: '180px',
    title: '店铺名',
    cell: (h, { row }) => `${row.shop.shop_name}`,
  },
  {
    colKey: 'username',
    width: '180px',
    title: '商户名',
    cell: (h, { row }) => `${row.user.username}`,
  },
  {
    colKey: 'goods_name',
    width: '180px',
    title: '商品名',
  },
  {
    colKey: 'contact',
    width: '180px',
    title: '联系方式',
  },
  {
    colKey: 'quantity',
    width: '100px',
    title: '商品数量',
  },
  {
    colKey: 'total_price',
    title: '订单金额',
  },
  {
    colKey: 'fee',
    title: '手续费',
  },
  {
    colKey: 'rate',
    title: '手续费率',
    cell: (h, { row }) => `${(row.rate * 1000).toFixed(2)}‰`,
  },
  {
    colKey: 'channel',
    title: '支付渠道',
    cell: (h, { row }) => `${row.channel.title}`,
  },
  // status: 1 已支付, 2 已关闭, 3 已退款, 0 未支付
  {
    width: '150px',
    colKey: 'status',
    title: '订单状态',
    fixed: 'right',
    cell: (h, { row }) => {
      const statusOption = statusOptions.find((t) => t.value === row.status);
      const tag = h(
        Tag,
        {
          theme: statusOption.theme,
          variant: 'light',
        },
        () => statusOption?.label,
      );
      let html;
      if (row.status === 1) {
        html = h(
          Button,
          {
            vPerms: "['admin/order/order/refund']",
            hover: 'color',
            size: 'small',
            style: 'margin-left: 10px',
            onClick: () => {
              hadleRefund(row);
            },
          },
          () => '退款',
        );
      } else if (row.status === 0) {
        html = h(
          Button,
          {
            vPerms: "['admin/order/order/notify']",
            hover: 'color',
            size: 'small',
            onClick: () => {
              handleNotify(row);
            },
          },
          () => '补单',
        );
      } else {
        html = '';
      }
      return [tag, html];
    },
  },
  {
    colKey: 'cards_count',
    title: '取卡状态',
    fixed: 'right',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          theme: row.cards_count === row.quantity ? 'success' : 'warning',
          variant: 'light',
        },
        () => {
          if (row.cards_count === 0) {
            return '未取卡';
          }
          if (row.cards_count === row.quantity) {
            return '已取卡';
          }
          return '部分取卡';
        },
      );
    },
  },
  {
    colKey: 'is_freeze',
    title: '冻结',
    fixed: 'right',
    cell: (h, { row }): VNode | string => {
      let html: VNode | string = '';
      if (row.status === 1) {
        html = h(
          Link,
          {
            theme: row.is_freeze ? 'danger' : 'success',
            vPerms: "['admin/order/order/freeze']",
            hover: 'color',
            onClick: () => {
              hadleFreeze(row);
            },
          },
          () => (row.is_freeze ? '解冻' : '冻结'),
        );
      }
      return html;
    },
  },
  {
    colKey: 'create_ip',
    title: 'Ip',
  },
  {
    width: '200px',
    colKey: 'create_at',
    title: '下单时间',
    cell: (h, { row }) => formatTime(row.create_at),
  },
  {
    width: '100px',
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

const handleNotify = (row: TableRowData) => {
  handleAction(row, notify, '确认要设置这个订单已支付吗？该操作不可恢复');
};

const hadleRefund = (row: TableRowData) => {
  handleAction(row, refund, '确认要退款吗？该操作不可恢复');
};

const hadleFreeze = (row: TableRowData) => {
  let content;
  if (row.is_freeze === 1) {
    content = `确认要解冻吗？`;
  } else {
    content = `确认要冻结吗？此处用于存在投诉争议的订单，手工冻结。冻结后，该订单将不会被自动退款，也不会被自动结算。`;
  }
  handleAction(row, freeze, content);
};

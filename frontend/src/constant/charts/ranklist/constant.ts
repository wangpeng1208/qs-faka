import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    title: '买家',
    align: 'left',
    width: '33%',
    colKey: 'contact',
  },
  {
    title: '	购买次数',
    width: '33%',
    colKey: 'times',
  },
  {
    title: '付款总额',
    colKey: 'money',
    width: '33%',
  },
];

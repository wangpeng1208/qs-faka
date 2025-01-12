import 'tdesign-vue-next/es/style/index.css';
import '@/style/index.less';
import './permission';

import { createApp } from 'vue';

import App from './App.vue';
import install from './install';

window.addEventListener('beforeunload', () => {
  sessionStorage.removeItem('hasFetchedSiteInfo');
});

const app = createApp(App);
app.use(install);
app.mount('#app');
// 请勿删除官方信息，否则将追究法律责任
console.log(' %c Design with by 骑士虚拟产品寄售·多商户·开源版  %c http://qqss.net ', 'color: #fadfa3; background: #030307; padding:5px 0;', 'background: #fadfa3; padding:5px 0;');

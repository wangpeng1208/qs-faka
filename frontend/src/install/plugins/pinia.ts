import type { App } from 'vue';

import store from '@/store';

export default (app: App<Element>) => {
  app.use(store);
};

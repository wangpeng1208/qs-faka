import type { App } from 'vue';

import i18n from '@/locales';

export default (app: App<Element>) => {
  app.use(i18n);
};

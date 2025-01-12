import type { App } from 'vue';

import router from '@/router';

export default (app: App<Element>) => {
  const originalWarn = console.warn;
  console.warn = (message: string, ...args: any[]) => {
    if (message.startsWith('[Vue Router warn]: No match found for location with path')) {
      return;
    }
    originalWarn(message, ...args);
  };
  app.use(router);
};

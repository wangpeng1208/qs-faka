import type { App } from 'vue';

const modules = import.meta.glob('./**/*', { eager: true });

function install(app: App<Element>) {
  Object.keys(modules).forEach((key) => {
    const name = key.replace(/(.*\/)*([^.]+).*/gi, '$2');
    const type = key.replace(/^\.\/([\w-]+).*/gi, '$1');
    const module: any = modules[key];
    if (module.default) {
      switch (type) {
        // 用于注册全局指令
        case 'directives':
          app.directive(name, module.default);
          break;
        // 使用插件
        case 'plugins':
          if (typeof module.default === 'function') {
            module.default(app);
          }
          break;
        default:
          app.component(name, module.default);
          break;
      }
    }
  });
}

export default {
  install,
};

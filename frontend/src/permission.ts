import 'nprogress/nprogress.css'; // progress bar style

import NProgress from 'nprogress'; // progress bar
// import { MessagePlugin } from 'tdesign-vue-next';
import { RouteRecordRaw } from 'vue-router';

import router from '@/router';
import { getPermissionStore, getSiteStore, useAdminUserStore, useUserStore } from '@/store';
import { setTitleFromRoute } from '@/utils/common';
import { PAGE_NOT_FOUND_ROUTE } from '@/utils/route/constant';

NProgress.configure({ showSpinner: false });

router.beforeEach(async (to, from, next) => {
  NProgress.start();
  const templateStore = getSiteStore();
  // 如果本地不存在site则请求网站基础信息
  if (!sessionStorage.getItem('hasFetchedSiteInfo')) {
    await templateStore.getSiteConfig();
    sessionStorage.setItem('hasFetchedSiteInfo', 'true');
  }
  if (to.path === '/merchant/login' || to.path === '/admin/login') {
    next();
    return;
  }
  const permissionStore = getPermissionStore();
  const userStore = useUserStore();
  const adminUserStore = useAdminUserStore();

  const { whiteListRouters } = permissionStore;

  // 默认为商家端
  let app = 'merchant';
  // 假设有其他应用 ，并用数组存储
  const appList = ['admin'];
  // to.path中第一个/后的字符串,作为当前应用名称
  const toPathStart = to.path.split('/')[1];
  // to.path.split('/')[1] 不在appList中，则默认为商家端
  if (appList.includes(toPathStart)) {
    app = toPathStart;
  }

  // 通过app到对应的状态管理中获取对应的accessToken和accessType
  // switch语句根据app的值，选择对应的状态管理，方便后续扩展
  let appStore;
  switch (app) {
    case 'admin':
      appStore = adminUserStore;
      break;
    default:
      appStore = userStore;
  }
  // 从状态管理中获取accessToken
  const { accessToken } = appStore;
  if (accessToken) {
    const { asyncRoutes } = permissionStore;
    // 加载动态路由
    if (asyncRoutes && asyncRoutes.length === 0) {
      const routeList: Array<RouteRecordRaw> = await permissionStore.buildAsyncRoutes(app);
      routeList.forEach((item: RouteRecordRaw) => {
        router.addRoute(item);
      });
      // 如果只有一个路由且没有name，则跳转到500页面
      if (to.name === undefined && routeList.length === 1) {
        // 为当前路由地址设置组件500页面
        const notFoundRoute = {
          path: to.fullPath,
          name: 'NotFound',
          component: () => import('@/pages/common/result/500/index.vue'),
        };
        router.addRoute(notFoundRoute);
      }
      if (to.name === PAGE_NOT_FOUND_ROUTE.name) {
        // 动态添加路由后，此处应当重定向到fullPath，否则会加载404页面内容
        next({ path: to.fullPath, replace: true, query: to.query });
      } else {
        const redirect = decodeURIComponent((from.query.redirect || to.path) as string);
        next(to.path === redirect ? { ...to, replace: true } : { path: redirect });
        return;
      }
    }
    if (router.hasRoute(to.name)) {
      next();
    } else {
      next(`/`);
    }
  } else if (whiteListRouters.indexOf(to.name as string) !== -1) {
    next();
  } else {
    next({
      path: '/404',
      // query: { redirect: encodeURIComponent(to.fullPath) },
    });
  }
  NProgress.done();
});

router.afterEach((to) => {
  // 设置浏览器标题
  setTitleFromRoute();
  NProgress.done();
});

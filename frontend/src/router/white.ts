export default [
  {
    path: '/',
    name: 'index',
    component: () => import('@/pages/home/base/index.vue'),
    meta: {
      title: '',
    },
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/pages/home/base/about.vue'),
    meta: {
      title: '关于我们',
    },
  },
  {
    path: '/order',
    name: 'order',
    component: () => import('@/pages/home/base/order.vue'),
    meta: {
      title: '卡密查询',
    },
  },
  {
    path: '/cate/:alias?/:page?',
    name: 'news_cate',
    component: () => import('@/pages/home/base/article_list.vue'),
    meta: {
      title: '文章列表',
    },
  },
  {
    path: '/article/:id',
    name: 'article',
    component: () => import('@/pages/home/base/article_info.vue'),
    meta: {
      title: '文章',
    },
  },
  {
    path: '/merchant/login',
    name: 'login',
    component: () => import('@/pages/home/base/login.vue'),
    meta: {
      title: '商户登录',
    },
  },
  {
    path: '/links/:token',
    name: 'links',
    component: () => import('@/pages/shop/index.vue'),
    meta: {
      title: '购卡页',
    },
  },
  {
    path: '/callback',
    name: 'callback',
    component: () => import('@/pages/home/pay/callback.vue'),
    meta: {
      title: '支付结果',
    },
  },
  {
    path: '/admin/login',
    name: 'adminLogin',
    component: () => import('@/pages/admin/login/index.vue'),
    meta: {
      title: '管理登陆',
    },
  },
  {
    path: '/404',
    name: '404',
    component: () => import('@/pages/common/result/404/index.vue'),
    meta: {
      title: '404 Not Found',
    },
  },
  // 404Page
  // {
  //   path: '/:catchAll(.*)',
  //   redirect: '/404',
  // },
];

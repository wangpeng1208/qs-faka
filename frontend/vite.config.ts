import vue from '@vitejs/plugin-vue';
import vueJsx from '@vitejs/plugin-vue-jsx';
import path from 'path';
import AutoImport from 'unplugin-auto-import/vite';
import { TDesignResolver } from 'unplugin-vue-components/resolvers';
import Components from 'unplugin-vue-components/vite';
import { ConfigEnv, loadEnv, UserConfig } from 'vite';
import svgLoader from 'vite-svg-loader';

const CWD = process.cwd();

// https://vitejs.dev/config/
export default ({ mode }: ConfigEnv): UserConfig => {
  const { VITE_BASE_URL } = loadEnv(mode, CWD);
  return {
    base: VITE_BASE_URL,
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './src'),
      },
    },

    css: {
      preprocessorOptions: {
        less: {
          modifyVars: {
            hack: `true; @import (reference) "${path.resolve('src/style/variables.less')}";`,
          },
          math: 'strict',
          javascriptEnabled: true,
        },
      },
    },

    plugins: [
      vue(),
      vueJsx(),
      svgLoader(),
      AutoImport({
        resolvers: [
          TDesignResolver({
            library: 'vue-next',
          }),
        ],
      }),
      Components({
        resolvers: [
          TDesignResolver({
            library: 'vue-next',
          }),
        ],
      }),
    ],
    server: {
      port: 3003,
      host: '0.0.0.0',
    },
    build: {
      chunkSizeWarningLimit: 2000,
      sourcemap: false,
      // 完成后复制到 web文件夹  需要手动把 web/assets 目录下的文件复制到 web 目录下
      assetsDir: 'web/assets',
      rollupOptions: {
        output: {
          manualChunks: {
            vue: ['vue', 'vue-router', 'vue-i18n', 'vue-clipboard3'],
            libs: ['axios', 'dayjs', 'lodash', 'nprogress', 'qs'],
            echarts: ['vue-echarts'],
            wangeditor: ['@wangeditor/editor', '@wangeditor/editor-for-vue'],
            plugins: ['pinia', 'pinia-plugin-persistedstate'],
            others: ['@fingerprintjs/fingerprintjs', 'crypto-js', 'echarts', 'pusher-js', 'qrcode.vue', 'tvision-color'],
          },
        },
      },
    },
  };
};

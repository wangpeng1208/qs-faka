import { defineStore } from 'pinia';
import { MessagePlugin } from 'tdesign-vue-next';

import { getSiteConfig } from '@/api/home/index';
import { store } from '@/store';

export const useSiteStore = defineStore('site', {
  state: () => ({
    config: {
      site_name: '',
      pc_template: '',
      mobile_template: '',
      site_status: 1,
      site_logo: '',
      merchant_logo: '',
      merchant_logo_sm: '',
      site_domain: '',
      site_info_qq: '',
      site_info_email: '',
      site_info_qq_desc: '',
      privacy_policy_id: '', //       隐私政策
      register_agreement_id: '', // 注册协议
      goods_release_id: '', // 商品发布条例
      prohibited_catalog_id: '', // 禁售目录
      infringement_report_id: '', // 侵权举报
      site_info_copyright: '', // 版权信息
      site_shop_copyright: '', // 版权信息
      site_info_icp: '', // 备案信息
    },
  }),
  getters: {
    getPcTemplate: (state) => state.config?.pc_template,
    getMobileTemplate: (state) => state.config?.mobile_template,
    getSiteLogo: (state) => state.config?.site_logo,
    getSiteMerchantLogo: (state) => state.config?.merchant_logo,
    getSiteMerchantLogoSm: (state) => state.config?.merchant_logo_sm,
    getSiteStatus: (state) => state.config?.site_status,
    getSiteUrl: (state) => state.config?.site_domain,
  },
  actions: {
    async getSiteConfig() {
      try {
        const { data } = await getSiteConfig();
        this.config = { ...this.config, ...data };
      } catch (e) {
        MessagePlugin.error(e.message);
      }
    },
  },
  persist: {},
});

export function getSiteStore() {
  return useSiteStore(store);
}

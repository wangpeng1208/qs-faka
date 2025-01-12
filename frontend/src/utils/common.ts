import { MessagePlugin } from 'tdesign-vue-next';
import { nextTick } from 'vue';
import useClipboard from 'vue-clipboard3';

import router from '@/router/index';

/**
 * 复制
 * @param text
 */
export function copyText(text: string) {
  const { toClipboard } = useClipboard();
  toClipboard(text)
    .then(() => {
      MessagePlugin.closeAll();
      MessagePlugin.success('复制成功');
    })
    .catch(() => {
      MessagePlugin.closeAll();
      MessagePlugin.error('复制失败');
    });
}

const hexList: string[] = [];
for (let i = 0; i <= 15; i++) {
  hexList[i] = i.toString(16);
}

/**
 * 设置浏览器标题
 */
export async function setTitleFromRoute() {
  if (router.currentRoute.value.path === '/') {
    // 如果是首页
    const response = await fetch(window.location.origin);
    const html = await response.text();
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const title = doc.querySelector('title')?.textContent || '';
    nextTick(() => {
      document.title = title;
    });
    return;
  }
  if (typeof router.currentRoute.value.meta.title !== 'string') {
    return;
  }
  nextTick(() => {
    const webTitle = router.currentRoute.value.meta.title as string;
    document.title = `${webTitle}`;
  });
}

// 金钱格式化 取2位小数
export function formatMoney(money: number) {
  return Number(money).toFixed(2);
}

// 加载更多 IntersectionObserver
export function loadMore(el: HTMLElement, callback: (entry: IntersectionObserverEntry) => void, options?: IntersectionObserverInit) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        callback(entry);
      }
    });
  }, options);

  observer.observe(el);
}

export function downloadFile(url: string) {
  const a = document.createElement('a');
  a.href = url;
  a.download = '';
  a.style.display = 'none';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

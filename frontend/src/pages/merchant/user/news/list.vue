<template>
  <t-card title="公告列表" class="basic-container" :bordered="false">
    <!-- <t-button>标记全部已读</t-button> -->
    <div class="secondary-notification">
      <t-list v-if="newsList.length > 0" class="secondary-msg-list" :split="true">
        <t-list-item v-for="(item, index) in newsList" :key="index">
          <p :class="['content', { unread: !item.is_read, read: item.is_read }]" @click="goDetail(item)">
            <t-tag size="medium" variant="light">
              {{ item.cate_name }}
            </t-tag>
            {{ item.title }}
          </p>
          <template #action>
            <span class="msg-date">{{ formatTime(item.create_at) }}</span>

            <div class="msg-action">
              <t-tooltip class="set-read-icon" :overlay-style="{ margin: '6px' }" :content="item.is_read ? '设为已读' : '设为未读'">
                <span class="msg-action-icon" @click="setReadStatus(item)">
                  <t-icon v-if="!!item.is_read" name="queue" size="16px" />
                  <t-icon v-else name="chat" />
                </span>
              </t-tooltip>
            </div>
          </template>
        </t-list-item>
        <template #footer>
          <t-pagination v-model="pagination.defaultCurrent" v-model:pageSize="pagination.defaultPageSize" :total="pagination.total" :show-page-size="false" @current-change="fetchData" />
        </template>
      </t-list>
      <div v-else class="secondary-msg-list__empty-list">
        <empty-icon></empty-icon>
        <p>暂无内容</p>
      </div>
    </div>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'DetailSecondary',
};
</script>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { getNewsList, read } from '@/api/merchant/user/news';
import EmptyIcon from '@/assets/assets-empty.svg?component';
import { formatTime } from '@/utils/date';

const router = useRouter();

const newsList = ref<NotificationItem[]>([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const fetchData = async () => {
  const { data } = await getNewsList({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  });
  newsList.value = data.data;
  pagination.value.total = data.total;
};
fetchData();
// /user/userNoticeDetail/292 格式
interface NotificationItem {
  id: string;
  title: string;
  content: string;
  cate_name: string;
  create_at: string;
  top: boolean;
  is_read: boolean;
}
const goDetail = (item: NotificationItem) => {
  router.push({
    name: 'merchantUserNews_detail/:id',
    params: {
      id: item.id,
    },
  });
};
const setReadStatus = async (item: NotificationItem) => {
  const res = await read({ id: item.id });
  if (res.code === 1) {
    fetchData();
  }
};

/* const handleClickDeleteBtn = (item: NotificationItem) => {
    visible.value = true;
    selectedItem.value = item;
  };
  
  const setReadStatus = (item: NotificationItem) => {
    const changeMsg = msgData.value;
    changeMsg.forEach((e: NotificationItem) => {
      if (e.id === item.id) {
        e.is_read = !e.is_read;
      }
    });
    store.setMsgData(changeMsg);
  };
  
 */
</script>

<style lang="less" scoped>
.secondary-notification {
  // background-color: var(--td-bg-color-container);
  // border-radius: var(--td-radius-medium);
  // padding: var(--td-comp-paddingTB-xxl) var(--td-comp-paddingLR-xxl);

  .t-tabs__content {
    padding-top: 0;
  }
}

.secondary-msg-list {
  height: 70vh;

  .t-list-item {
    cursor: pointer;
    padding: var(--td-comp-paddingTB-l) 0;
    transition: 0.2s linear;

    &:hover {
      background-color: var(--td-bg-color-container-hover);

      .msg-date {
        display: none;
      }

      .msg-action {
        display: flex;
        align-items: center;

        &-icon {
          display: flex;
          align-items: center;
        }
      }
    }

    :deep(.t-tag) {
      margin-right: var(--td-comp-margin-l);
    }

    .t-tag.t-size-s {
      margin-right: var(--td-comp-margin-s);
      margin-left: 0;
    }
  }

  .content {
    font: var(--td-font-body-medium);
    color: var(--td-text-color-placeholder);
    text-align: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .unread {
    color: var(--td-text-color-primary);
  }

  .msg-action {
    display: none;
    margin-right: var(--td-comp-margin-xxl);
    transition: 0.2s linear;

    .set-read-icon {
      margin-right: var(--td-comp-margin-l);
    }
  }

  &__empty-list {
    min-height: 443px;
    padding-top: 170px;
    text-align: center;
    color: var(--td-text-color-primary);
  }
}
</style>

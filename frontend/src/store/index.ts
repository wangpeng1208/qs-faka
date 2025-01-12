import { createPinia } from 'pinia';
import { createPersistedState } from 'pinia-plugin-persistedstate';

const store = createPinia();
store.use(createPersistedState());

export { store };

export * from './modules/admin';
export * from './modules/message';
export * from './modules/permission';
export * from './modules/setting';
export * from './modules/shop';
export * from './modules/site';
export * from './modules/tabs-router';
export * from './modules/user';

export default store;

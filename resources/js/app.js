import './bootstrap';

import { createApp } from 'vue';
import TaskLists from './components/TaskLists.vue';

const app = createApp({});
app.component('task-lists', TaskLists);
app.mount('#app');

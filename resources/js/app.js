import './bootstrap';

import { createApp } from 'vue';
import TaskLists from './components/TaskLists.vue';

const app = createApp({
    components: {
        'task-lists': TaskLists
    }
});

app.mount('#app');

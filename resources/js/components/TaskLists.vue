<template>
    <div>
        <h2>Mijn Takenlijsten</h2>
        <input v-model="newList" placeholder="Nieuwe lijst toevoegen">
        <button @click="addList">Toevoegen</button>

        <ul>
            <li v-for="list in taskLists" :key="list.id">
                {{ list.name }}
                <button @click="deleteList(list.id)">🗑️</button>
                <TaskList :list="list"/>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';
import TaskList from './TaskList.vue';

export default {
    components: { TaskList },
    data() {
        return {
            taskLists: [],
            newList: ''
        };
    },
    mounted() {
        axios.get('/api/tasklists').then(res => this.taskLists = res.data);
    },
    methods: {
        addList() {
            axios.post('/api/tasklists', { name: this.newList }).then(res => {
                this.taskLists.push(res.data);
                this.newList = '';
            });
        },
        deleteList(id) {
            axios.delete(`/api/tasklists/${id}`).then(() => {
                this.taskLists = this.taskLists.filter(l => l.id !== id);
            });
        }
    }
};
</script>

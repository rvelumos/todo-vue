<template>
    <div>
        <h2>Mijn Takenlijsten</h2>
        <input v-model="newList" placeholder="Nieuwe lijst toevoegen">
        <button @click="addList">Toevoegen</button>

        <ul v-if="taskLists.length">
            <li v-for="list in taskLists" :key="list.id">
                {{ list.name }}
                <button @click="deleteList(list.id)">🗑️</button>
            </li>
        </ul>
        <p v-else>No task lists found.</p>
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
        axios.get('/api/tasklists')
            .then(res => {
                console.log("Received data:", res.data);
                this.taskLists = res.data;
            })
            .catch(err => console.error("Error fetching tasklists:", err));
    },
    methods: {
        addList() {
            axios.post('/api/tasklists', { name: this.newList }).then(res => {
                this.taskLists.push(res.data);
                this.newList = '';
            });
        },
        deleteList(id) {
            axios.delete(`/tasklists/${id}`).then(() => {
                this.taskLists = this.taskLists.filter(l => l.id !== id);
            });
        }
    }
};
</script>

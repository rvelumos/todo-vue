<template>
    <div class="task-list">
        <h3>{{ list.name }}</h3>

        <input v-model="newTask" placeholder="Nieuwe taak toevoegen">
        <button @click="addTask">Toevoegen</button>

        <!-- Taken weergeven -->
        <ul>
            <li v-for="task in list.tasks" :key="task.id">
                <input type="checkbox" v-model="task.completed" @change="toggleComplete(task)">
                <input v-model="task.title" @blur="updateTask(task)">
                <button @click="deleteTask(task.id)">🗑️</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['list'],
    data() {
        return {
            newTask: '',
        };
    },
    methods: {
        addTask() {
            axios.post('/api/tasks', {
                title: this.newTask,
                task_list_id: this.list.id
            }).then(res => {
                this.list.tasks.push(res.data);
                this.newTask = '';
            });
        },
        updateTask(task) {
            axios.put(`/api/tasks/${task.id}`, {
                title: task.title,
                completed: task.completed
            });
        },
        toggleComplete(task) {
            axios.put(`/api/tasks/${task.id}`, {
                title: task.title,
                completed: task.completed
            });
        },
        deleteTask(id) {
            axios.delete(`/api/tasks/${id}`).then(() => {
                this.list.tasks = this.list.tasks.filter(t => t.id !== id);
            });
        }
    }
};
</script>

<style scoped>
.task-list {
    border: 1px solid #ddd;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
}
</style>

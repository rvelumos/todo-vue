<template>
    <template>
        <div class="task-list-container">
            <h2 class="title">{{ list.name }}</h2>
            <ul class="task-list">
                <li v-for="task in list.tasks" :key="task.id" class="task-item">
                    {{ task.title }}
                    <button @click="deleteTask(task.id)" class="delete-btn">🗑️</button>
                </li>
            </ul>
            <button @click="addTask" class="add-btn">+ Add Task</button>
        </div>
    </template>

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
            axios.post('/tasks', {
                title: this.newTask,
                task_list_id: this.list.id
            }).then(res => {
                this.list.tasks.push(res.data);
                this.newTask = '';
            });
        },
        updateTask(task) {
            axios.put(`/tasks/${task.id}`, {
                title: task.title,
                completed: task.completed
            });
        },
        toggleComplete(task) {
            axios.put(`/tasks/${task.id}`, {
                title: task.title,
                completed: task.completed
            });
        },
        deleteTask(id) {
            axios.delete(`/tasks/${id}`).then(() => {
                this.list.tasks = this.list.tasks.filter(t => t.id !== id);
            });
        }
    }
};
</script>

<style scoped>
.task-list-container {
    background: #fff;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: transform 0.2s ease-in-out;
}

.task-list-container:hover {
    transform: scale(1.02);
}

.title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 12px;
}

.task-list {
    list-style: none;
    padding: 0;
}

.task-item {
    display: flex;
    justify-content: space-between;
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 8px;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
}

.delete-btn {
    background: #ff4d4d;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

.delete-btn:hover {
    background: #e60000;
}

.add-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 10px;
    display: block;
    width: 100%;
    text-align: center;
    transition: background 0.2s;
}

.add-btn:hover {
    background: #0056b3;
}
</style>

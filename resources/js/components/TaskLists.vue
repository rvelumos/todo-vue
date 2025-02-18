<template>
    <div class="tasklists-container">
        <h1 class="title">Your Task Lists</h1>

        <div class="add-tasklist">
            <input v-model="newList" placeholder="New task list..." />
            <button @click="addList">+ Add</button>
        </div>

        <ul class="tasklists">
            <li v-for="list in taskLists" :key="list.id" class="tasklist-item">
                <div class="tasklist-header">
                    <span class="tasklist-name">{{ list.name }}</span>
                    <button @click="deleteList(list.id)" class="delete-btn">🗑️</button>
                </div>
            </li>
        </ul>

        <p v-if="loading">Loading...</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            taskLists: [],
            newList: '',
            loading: false
        };
    },
    mounted() {
        this.fetchTaskLists();
    },
    methods: {
        fetchTaskLists() {
            this.loading = true;
            axios.get('/api/tasklists')
                .then(res => {
                    console.log("Received data:", res.data);
                    this.taskLists = res.data;
                })
                .catch(err => console.error("Error fetching tasklists:", err))
                .finally(() => {
                    this.loading = false;
                });
        },
        addList() {
            if (!this.newList.trim()) return;
            axios.post('/api/tasklists', { name: this.newList })
                .then(res => {
                    this.taskLists.push(res.data);
                    this.newList = '';
                })
                .catch(err => console.error("Error adding tasklist:", err));
        },
        deleteList(id) {
            axios.delete(`/api/tasklists/${id}`)
                .then(() => {
                    this.taskLists = this.taskLists.filter(l => l.id !== id);
                })
                .catch(err => console.error("Error deleting tasklist:", err));
        }
    }
};
</script>

<style scoped>
.tasklists-container {
    max-width: 600px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.title {
    text-align: center;
    font-size: 1.8rem;
}

.add-tasklist {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
}

.add-tasklist input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.add-tasklist button {
    padding: 8px 16px;
    border: none;
    background: #007bff;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}

.tasklists {
    list-style: none;
    padding: 0;
}

.tasklist-item {
    background: #f9f9f9;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.delete-btn {
    background: none;
    border: none;
    color: #ff4d4d;
    font-size: 1.2rem;
    cursor: pointer;
}

.delete-btn:hover {
    color: #e60000;
}
</style>

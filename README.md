# Laravel Vue Task Manager

A simple task management application built with **Laravel 11** (backend) and **Vue 3** (frontend) using **Sanctum authentication**.

---

## 🚀 Features
- User authentication (Sanctum)
- Task lists (CRUD operations)
- Tasks inside task lists (CRUD operations)
- Authorization policies to protect task lists
- Vue 3 frontend with API integration
- PHPUnit tests for authentication, task lists, and tasks
- Docker setup for local development

---

## 🛠 Installation

### Clone the Repository
```sh
git clone https://github.com/rvelumos/todo_vue.git
cd your-project-directory
```

### Setup Laravel Backend
```sh
composer install
cp .env.example .env
php artisan key:generate
```

### Configure Database
Update `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```
Then, run migrations and seeders:
```sh
php artisan migrate --seed
```

### Install Frontend Dependencies
```sh
npm install
npm run dev
```

###  Run the Application
```sh
php artisan serve
```
Now, open `http://127.0.0.1:8000` in your browser.

---

##  Authentication
Laravel Sanctum is used for API authentication.
- Register: `POST /api/register`
- Login: `POST /api/login`
- Logout: `POST /api/logout`

Example login request:
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

---

##  API Endpoints

### Task Lists
- `GET /api/tasklists` → Fetch user's task lists
- `POST /api/tasklists` → Create a new task list
- `PUT /api/tasklists/{id}` → Update a task list
- `DELETE /api/tasklists/{id}` → Delete a task list

### Tasks
- `POST /api/tasks` → Create a task inside a task list
- `PUT /api/tasks/{id}` → Update a task
- `DELETE /api/tasks/{id}` → Delete a task

---

##  Running Tests
To run **PHPUnit tests**:
```sh
php artisan test
```

---

##  Docker Setup
To use Docker for local development:
```sh
docker-compose up -d
```
This will spin up a container with PHP 8.4, MySQL, and Nginx.



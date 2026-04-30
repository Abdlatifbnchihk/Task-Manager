# 📋 TaskManager

A Laravel-based personal task management application with categories, statuses, and filtering.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)

## 🎯 Overview

TaskManager allows authenticated users to manage their personal tasks with complete data isolation. Each user can create, edit, delete, and filter tasks by status and category.

## ✨ Key Features

- ✅ User authentication (Laravel Breeze)
- ✅ Complete task CRUD operations
- ✅ Task categorization
- ✅ Status management (To Do, In Progress, Completed)
- ✅ Advanced filtering
- ✅ Quick status updates
- ✅ Due date tracking
- ✅ Responsive design
- ✅ Complete user isolation

## 🚀 Quick Start

```bash
# Clone repository
git clone https://github.com/yourusername/taskmanager.git
cd taskmanager

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate --seed

# Start server
php artisan serve



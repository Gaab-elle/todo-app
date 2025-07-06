# 📋  To-Do App

Modern and elegant To-Do application built with Laravel, Tailwind CSS, and Dark Mode support.

![Laravel](https://img.shields.io/badge/Laravel-v10-red?style=flat&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-v3-blue?style=flat&logo=tailwindcss)
![Dark Mode](https://img.shields.io/badge/Dark%20Mode-✅-yellow?style=flat)
![License](https://img.shields.io/badge/License-MIT-green?style=flat)

## ✨ Features

- 🌙 **Dark Mode** - Toggle between light and dark themes with localStorage persistence
- ✅ **Task Management** - Create, edit, delete, and mark tasks as complete
- 🎯 **Priority System** - Organize tasks by High, Medium, and Low priority
- 🔍 **Advanced Filters** - Filter by status and priority
- 📊 **Real-time Statistics** - Track your progress with live stats
- 📈 **Progress Bar** - Visual progress tracking
- 📅 **Due Dates** - Set and track task deadlines
- 🎨 **Modern Design** - Glassmorphism effects and smooth animations
- 📱 **Responsive** - Works perfectly on desktop and mobile
- 💾 **Data Persistence** - All tasks saved in SQLite database

## 🚀 Tech Stack

- **Backend**: Laravel 10 with PHP 8+
- **Frontend**: Tailwind CSS 3 + Alpine.js
- **Build Tool**: Vite for fast development
- **Database**: SQLite (easily changeable to MySQL/PostgreSQL)
- **Icons**: Heroicons SVG icons
- **Styling**: Custom CSS with dark mode support

## 🛠️ Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Gaab-elle/sistema-os.git
   cd sistema-os
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   # For SQLite (recommended for development)
   touch database/database.sqlite
   
   # For MySQL, configure your .env file with database credentials
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=todo_app
   # DB_USERNAME=root
   # DB_PASSWORD=
   
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   # For development
   npm run dev
   
   # For production
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Visit the application**
   
   Open your browser and go to `http://localhost:8000`

## 🎨 Features Overview

### Task Management
- **Create Tasks**: Add tasks with title, description, priority level, and optional due dates
- **Edit Tasks**: Modify existing task details
- **Complete Tasks**: Mark tasks as done with satisfying animations
- **Delete Tasks**: Remove tasks with confirmation dialog
- **Priority Levels**: Organize tasks by High (red), Medium (yellow), and Low (green) priority

### Dark Mode
- **Auto Detection**: Automatically detects system dark mode preference
- **Manual Toggle**: Switch between light and dark themes with a single click
- **Persistent Storage**: Remembers your theme preference using localStorage
- **Smooth Transitions**: Beautiful animations when switching themes
- **Full Coverage**: All components and colors adapted for both themes

### Filtering & Organization
- **Status Filters**: View All, Pending, or Completed tasks
- **Priority Filters**: Filter by High, Medium, or Low priority
- **Real-time Stats**: Live counters for total, completed, pending, and high-priority tasks
- **Progress Tracking**: Visual progress bar showing completion percentage

### Modern UI/UX
- **Glassmorphism Design**: Modern frosted glass effects
- **Responsive Layout**: Optimized for desktop, tablet, and mobile devices
- **Smooth Animations**: Hover effects, transitions, and micro-interactions
- **Intuitive Interface**: Clean and user-friendly design

## 📂 Project Structure

```
sistema-os/
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php
│   └── Models/
│       └── Task.php
├── database/
│   └── migrations/
│       └── create_tasks_table.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── tasks/
│           └── index.blade.php
├── routes/
│   └── web.php
└── tailwind.config.js
```

## 🔧 Configuration

### Database Configuration
The application uses SQLite by default for easy setup. To use MySQL:

1. Update your `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. Create the database and run migrations:
   ```bash
   php artisan migrate
   ```

### Tailwind Configuration
The project uses a custom Tailwind configuration with dark mode support:

```javascript
// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  // ... rest of configuration
}
```

## 📱 Usage Guide

### Creating Tasks
1. Fill in the task title (required)
2. Select priority level from dropdown
3. Add optional description
4. Set due date if needed
5. Click "Criar Tarefa" to save

### Managing Tasks
- **Complete**: Click the circle icon next to a task
- **Delete**: Hover over a task and click the trash icon
- **Filter**: Use the filter buttons to organize your view

### Dark Mode
- Click the moon/sun icon in the header to toggle themes
- Your preference is automatically saved and restored

## 🚀 Deployment

### Production Setup
1. Set up your production environment
2. Configure your `.env` file for production
3. Run production commands:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Environment Variables
Key environment variables for production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## 🤝 Contributing

We welcome contributions! Here's how you can help:

1. **Fork the project**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Make your changes**
4. **Commit with descriptive messages**
   ```bash
   git commit -m "✨ Add amazing new feature"
   ```
5. **Push to your branch**
   ```bash
   git push origin feature/amazing-feature
   ```
6. **Open a Pull Request**

### Development Guidelines
- Follow PSR-12 coding standards for PHP
- Use meaningful commit messages with emojis
- Add comments for complex logic
- Test your changes before submitting

## 🐛 Known Issues

- None at the moment! 🎉

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

```
MIT License

Copyright (c) 2024 Gaab-elle

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 🔗 Links

- **Repository**: [https://github.com/Gaab-elle/sistema-os](https://github.com/Gaab-elle/todo-app)
- **Issues**: [Report a bug or request a feature](https://github.com/Gaab-elle/sistema-os/issues)
- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)
- **Tailwind CSS**: [https://tailwindcss.com](https://tailwindcss.com)

## 🙏 Acknowledgments

- **Laravel Team** - For the incredible PHP framework
- **Tailwind CSS Team** - For the utility-first CSS framework
- **Alpine.js** - For lightweight JavaScript functionality
- **Heroicons** - For beautiful SVG icons
- **Vite** - For fast and modern build tooling

## 🌟 Show Your Support

If this project helped you, please consider:

- ⭐ **Starring this repository**
- 🍴 **Forking it for your own projects**
- 💬 **Sharing it with others**
- 🐛 **Reporting issues** to help improve it

---

**Built with ❤️ by [Gaab-elle](https://github.com/Gaab-elle)**

*Happy coding! 🚀*

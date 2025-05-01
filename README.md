# 📚 Laravel Digital Bookstore

A modern Laravel-based digital bookstore where users can browse, purchase, and enjoy eBooks, audiobooks, and printed books. The platform supports online payments, subscriptions, and user-friendly book discovery. Ideal for readers who want to access content in multiple formats.

## ✨ Features

-   Browse books by category, author, or format (eBook, Audiobook, Printed)
-   Listen to or read purchased books directly in the app
-   Add books to favorites and continue where you left off
-   Online payment integration + Cash on Delivery
-   Paid subscriptions to remove ads and unlock additional features
-   Admin dashboard to manage books, authors, publishers, and users

## 📁 Tech Stack

-   **Backend**: Laravel 12
-   **Frontend**: Blade, Bootstrap (dark theme)
-   **Database**: MySQL
-   **Authentication**: Laravel Breeze (or Jetstream)
-   **Audio Streaming**: Laravel File Streaming
-   **Payments**: myfatoora

---

## 🚀 Installation Steps (First Time)

> Prerequisites: PHP 8.1+, Composer, MySQL, Node.js, npm, Git

1. **Clone the Repository**
    ```bash
    git https://github.com/asmaa905/digitalbook_laravel.git
    cd digitalbook_laravel
    ```
    2- \*\*install dependances

```bash
composer install
```

3- Set Up Environment
--- run this commands in git bash

```bash
cp .env.example .env
php artisan key:generate
```

4- **Configure .env**

    Set your database credentials:

    ```bash
    DB_DATABASE=your_db
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

5-

```bash
 php artisan migrate:refresh --seed

```

```bash

```

6- Install NPM Dependencies

```bash
npm install
npm run dev
```

7- Serve the App

    ```bash
    php artisan serve
    ```

8- Open your browser:

```bash
http://127.0.0.1:8000
```

9- Storage Link (for audio and images)

```bash
php artisan storage:link
```

10- Queue for Notifications or Audio Processing (if used)

```bash
php artisan queue:work
```

==================================================================================
**\*You can login to admin within this link**

```bash
  http://127.0.0.1:8000/admin/login
```

You can register to admin within this link

```bash
  http://127.0.0.1:8000/admin/register
```

and when register use should wrte this verification code

ADMIN_REGISTRATION_CODE=123456

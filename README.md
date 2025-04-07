# 📚 Laravel Digital Bookstore

A modern Laravel-based digital bookstore where users can browse, purchase, and enjoy eBooks, audiobooks, and printed books. The platform supports online payments, subscriptions, and user-friendly book discovery. Ideal for readers who want to access content in multiple formats.

## ✨ Features

- Browse books by category, author, or format (eBook, Audiobook, Printed)
- Listen to or read purchased books directly in the app
- Add books to favorites and continue where you left off
- Online payment integration + Cash on Delivery
- Paid subscriptions to remove ads and unlock additional features
- Admin dashboard to manage books, authors, publishers, and users

## 📁 Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade, Bootstrap (dark theme)
- **Database**: MySQL
- **Authentication**: Laravel Breeze (or Jetstream)
- **Audio Streaming**: Laravel File Streaming
- **Payments**: Stripe

---

## 🚀 Installation Steps (First Time)

> Prerequisites: PHP 8.1+, Composer, MySQL, Node.js, npm, Git

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/digital-bookstore.git
   cd digital-bookstore
2- **install dependances
  ```bash
    composer install
3- Set Up Environment
   ```bash
    cp .env.example .env
    php artisan key:generate
4- **Configure .env**

    Set your database credentials:
    
    ```bash
    DB_DATABASE=your_db
    DB_USERNAME=root
    DB_PASSWORD=your_password

5- 
    ```bash
    php artisan migrate
    
    ```bash
    php artisan db:seed
6- Install NPM Dependencies

    ```bash
    npm install
    npm run dev

7- Serve the App
    
    ```bash
    php artisan serve

8- Open your browser:

```bash
http://127.0.0.1:8000


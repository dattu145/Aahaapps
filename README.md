# Aaha Apps - Laravel Foundation

A production-grade Laravel web application foundation.

## Foundation & Architecture

- **Framework**: Laravel 11.x
- **Database**: SQLite (Local), ready for MySQL/Postgres (Production)
- **Authentication**: Laravel Breeze (Admin Only)
- **Frontend**: Blade + Tailwind CSS (via Vite)

## Setup Instructions

1.  **Clone & Install Dependencies**
    ```bash
    git clone ...
    cd aahaapps
    composer install
    npm install && npm run build
    ```

2.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database & Seeding**
    The project uses SQLite by default.
    ```bash
    touch database/database.sqlite
    php artisan migrate:fresh --seed
    ```
    This will create a default admin user:
    - **Email**: admin@aahaapps.com
    - **Password**: password

4.  **Serve**
    ```bash
    php artisan serve
    ```

## Architecture Notes

### Security
- **CSRF Protection**: Enabled globally via default middleware.
- **Authentication**: Admin-only routes under `/admin`.
- **Registration**: Public registration is **disabled**.
- **Rate Limiting**: Enabled on API and Auth routes.

### Admin Access
- Access the dashboard at `/admin/dashboard`.
- Any attempt to access protected resources will redirect to the login page.
- Once logged in, you are redirected to the admin dashboard.

## Production Deployment
To deploy to production:
1.  Update `.env` with production database credentials (`DB_CONNECTION=mysql`, etc.).
2.  Set `APP_ENV=production` and `APP_DEBUG=false`.
3.  Run `php artisan optimize`.

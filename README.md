# PresenceEngine

Real-time presence tracking system for multi-section teams.

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql\&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Active-brightgreen)


## Overview

PresenceEngine is a lightweight, framework-free PHP application that tracks user presence across multiple sections of an organization in real time.

It provides administrators with a live dashboard showing:

* Who is currently online
* When users logged in
* Which section they belong to
* Historical presence activity

All activity is persisted to a MySQL database for historical reporting.

The system is built on a custom MVC architecture using PDO for database access and Workerman for WebSocket communication, delivering sub-second updates without page refreshes.


## Features

* Role-based access control (Admin / User)
* Live presence dashboard with real-time WebSocket updates
* User management: create accounts, enable/disable accounts, and assign sections
* Automatic login and logout timestamp tracking
* IP address logging per session
* Full historical audit log of presence events
* CSRF protection on all state-changing forms
* Secure session handling with `HttpOnly` and `SameSite=Strict`
* Password hashing with bcrypt
* Minimal, responsive dark UI built with vanilla CSS and JavaScript
* No frontend framework dependencies


## Screenshots

<p align="center">
  <img src="https://github.com/user-attachments/assets/e67a5644-493c-47b4-821a-6f4b68b1810b" width="24%" style="border-radius: 12px;" />
  <img src="https://github.com/user-attachments/assets/318305ab-c822-446c-833c-cd87b8a08972" width="24%" style="border-radius: 12px;" />
  <img src="https://github.com/user-attachments/assets/05178255-235e-4d06-a0d2-eeeaa195e341" width="24%" style="border-radius: 12px;" />
  <img src="https://github.com/user-attachments/assets/8a719eb5-b73f-4301-9c9a-6853e26dc3d6" width="24%" style="border-radius: 12px;" />
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/793fb10d-d1f2-495a-a285-277a60a7d13b" width="24%" style="border-radius: 12px;" />
  <img src="https://github.com/user-attachments/assets/c266f132-95ff-453a-be92-3c470ab7c8d2" width="24%" style="border-radius: 12px;" />
</p>


## Tech Stack

| Layer          | Technology                          |
| -------------- | ----------------------------------- |
| Backend        | PHP 8.1+ (Custom MVC, no framework) |
| Database       | MySQL 5.7+ / MariaDB 10.3+          |
| DB Access      | PDO with prepared statements        |
| WebSocket      | Workerman 4.x                       |
| Frontend       | Vanilla JavaScript, Inter font      |
| Authentication | Session-based with CSRF tokens      |
| Configuration  | vlucas/phpdotenv                    |


## Architecture

```
+-------------------+
|    Web Browser    |
|   (Admin / User)  |
+---------+---------+
          |
          |
   +------+------+
   |             |
  HTTP        WebSocket
   |             |
   v             v
+---------+   +-----------+
| Apache  |   | Workerman |
| / Nginx |   |           |
| public/ |   | ws-server |
+----+----+   +-----+-----+
     |              |
     +------+-------+
            |
            v
+-----------------------------+
|       MySQL Database        |
|                             |
|  users      presence_logs   |
+-----------------------------+
```


## Requirements

* PHP 8.1 or higher
* PHP extensions:

  * `pdo`
  * `pdo_mysql`
  * `zip`
* MySQL 5.7+ or MariaDB 10.3+
* Composer
* Apache or Nginx
* A terminal capable of running long-lived processes for the WebSocket server
* PHP built-in server can be used for development


## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/fouad-salehi/PresenceEngine.git
cd PresenceEngine
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Edit `.env`:

```env
APP_NAME=PresenceEngine
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=presence_engine
DB_USER=root
DB_PASS=your_password
DB_CHARSET=utf8mb4

WS_HOST=0.0.0.0
WS_PORT=8080

SESSION_LIFETIME=7200
```

### 4. Import the Database Schema

```bash
mysql -u root -p < database/migrations/001_create_tables.sql
```

### 5. Create the Initial Admin Account

Generate a bcrypt password hash:

```bash
php -r "echo password_hash('your-secure-password', PASSWORD_DEFAULT);"
```

Insert the admin user into the database:

```sql
INSERT INTO users (
    username,
    email,
    password_hash,
    section,
    role
) VALUES (
    'admin',
    'admin@example.com',
    '$2y$10$...your_generated_hash...',
    NULL,
    'admin'
);
```

### 6. Start the WebSocket Server

Open a dedicated terminal window. This process must remain running.

```bash
php ws-server.php start
```

### 7. Start the Web Server

Point your web server's document root to the `public/` directory.

For Apache, the included `.htaccess` handles URL rewriting.

For development, you can use PHP's built-in server:

```bash
php -S localhost:8000 -t public
```

### 8. Open the Application

Open:

```text
http://localhost:8000
```

Log in using the admin credentials created in step 5.


## Project Structure

```text
PresenceEngine/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── AdminController.php
│   │   └── UserController.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   └── PresenceLog.php
│   │
│   ├── Views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── admin/
│   │   ├── user/
│   │   └── errors/
│   │
│   ├── Core/
│   │   ├── Router.php
│   │   ├── Database.php
│   │   ├── Model.php
│   │   ├── Controller.php
│   │   ├── Session.php
│   │   ├── Config.php
│   │   └── View.php
│   │
│   └── Middleware/
│       ├── AuthMiddleware.php
│       ├── AdminMiddleware.php
│       └── GuestMiddleware.php
│
├── public/
│   ├── index.php
│   └── .htaccess
│
├── database/
│   └── migrations/
│       └── 001_create_tables.sql
│
├── storage/
│   └── logs/
│
├── ws-server.php
├── composer.json
└── .env.example
```


## Database Schema

### `users`

| Column          | Type           | Description                            |
| --------------- | -------------- | -------------------------------------- |
| `id`            | `INT UNSIGNED` | Primary key                            |
| `username`      | `VARCHAR(50)`  | Unique login name                      |
| `email`         | `VARCHAR(100)` | Unique email address                   |
| `password_hash` | `VARCHAR(255)` | Bcrypt password hash                   |
| `section`       | `VARCHAR(50)`  | Section assignment (`NULL` for admins) |
| `role`          | `ENUM`         | `admin` or `user`                      |
| `is_active`     | `TINYINT(1)`   | Account enabled flag                   |
| `created_at`    | `TIMESTAMP`    | Creation timestamp                     |
| `updated_at`    | `TIMESTAMP`    | Last update timestamp                  |

### `presence_logs`

| Column        | Type              | Description                         |
| ------------- | ----------------- | ----------------------------------- |
| `id`          | `BIGINT UNSIGNED` | Primary key                         |
| `user_id`     | `INT UNSIGNED`    | Foreign key to `users`              |
| `section`     | `VARCHAR(50)`     | Section at login time               |
| `login_time`  | `DATETIME`        | Login timestamp                     |
| `logout_time` | `DATETIME`        | Logout timestamp (`NULL` if online) |
| `is_online`   | `TINYINT(1)`      | Current presence flag               |
| `ip_address`  | `VARCHAR(45)`     | Client IP address (IPv4 or IPv6)    |
| `created_at`  | `TIMESTAMP`       | Record creation timestamp           |


## Security

PresenceEngine implements several security measures:

* Passwords hashed with bcrypt via `password_hash()`
* All SQL queries use PDO prepared statements
* CSRF tokens required on all POST requests
* Session cookies configured with `HttpOnly` and `SameSite=Strict`
* Role-based middleware guards protected routes
* Output escaping with `htmlspecialchars()`
* Deactivated accounts are rejected during authentication


## Usage

### Admin

1. Log in with an admin account.
2. Access the dashboard at `/admin` to view live presence.
3. Navigate to `/admin/users` to manage accounts.
4. Use `/admin/history` to review historical activity.
5. Create new users at `/admin/users/create`.

### User

1. Log in with a standard account.
2. View personal status at `/me`.
3. The session is automatically logged on login and logout.


## Deployment Notes

* Set `APP_DEBUG=false` in production.
* Use HTTPS in production environments.
* The WebSocket server must run as a persistent process.
* On Windows, use a process manager such as NSSM to run the WebSocket server as a service.
* On Linux, use systemd or Supervisor.


## Roadmap

* [ ] Audio notification on user login
* [ ] Section-based filtering in live dashboard
* [ ] CSV export of historical logs
* [ ] Idle timeout for inactive sessions
* [ ] Rate limiting on authentication endpoint
* [ ] Docker Compose configuration
* [ ] Automated test suite


## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.


## Author

**Fouad Salehi**

GitHub: [@fouad-salehi](https://github.com/fouad-salehi)


## Acknowledgements

* [Workerman](https://www.workerman.net/) for the WebSocket server
* [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) for environment configuration
* [Inter](https://fonts.google.com/specimen/Inter) typeface

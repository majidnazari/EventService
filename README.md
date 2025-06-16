# EventService

A Laravel 12 microservice for storing and exporting events, using queues, clean code, and SOLID principles.

---

## 🚀 Prerequisites

- PHP 8.2+
- Composer
- MySQL (or any relational database)
- Node.js & NPM (optional if you need frontend assets)
- Git

---

## 🚀 Setup Instructions

### 1️⃣ Clone the repository

```bash
git clone https://github.com/majidnazari/EventService.git
cd EventService

### 2️⃣ Install PHP dependencies

composer install

### 3️⃣ Create and configure .env

cp .env.example .env

Edit .env and set your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_service
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

QUEUE_CONNECTION=database


4️⃣ Generate application key

php artisan key:generate


5️⃣ Run database migrations

php artisan migrate

Migrations will create:

    -events table
    -jobs table (for queue)
    -failed_jobs table

6️⃣ Start queue worker

php artisan queue:work

7️⃣ API Endpoints

Store Event
Method: POST

URL: /api/v1/event

Request body example:

{
  "user_id": 123,
  "event_name": "clicked_button",
  "payload": {
    "key1": "value1",
    "key2": "value2"
  }
}


Export Events
Method: GET

URL: /api/v1/events?from=2024-01-01&limit=100&page=1&user_id=123

Query parameters:

from (optional): start date filter (YYYY-MM-DD)

limit (optional): number of records per page (default 50)

page (optional): pagination page number (default 1)

user_id (optional): filter by user ID


8️⃣ Run Unit Tests

php artisan test


9️⃣ Postman Collection
Import the Postman collection from:





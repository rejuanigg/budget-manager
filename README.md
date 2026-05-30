## Budget Manager
Budget Manager is a REST API for personal finance management.
The app can save the user transactions with their categories.

### Features

- **Create Transactions** -- Create,update and delete transactions with amount and description. 
- **Categories** -- Organize users transactions by custom categories
- **Authentication** -- Users can log in and register using Sanctum.

### Installation
You can clone the repository and next install dependencies:
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

### API Endpoints
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/transactions | Create a transaction |
| GET | /api/transactions | List all transactions |
| POST | /api/categories | Create a category |


### Stack
- PHP | Laravel
- Sanctum

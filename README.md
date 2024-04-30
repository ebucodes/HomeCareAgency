# Set Up Instructions

## Frontend

1. In your command line, navigate to the directory of the web:
2. Run npm install to install dependencies:npm run install
3. Install additional dependencies:npm install axios, npm install sweetalert2, npm install vuex
4. Start the development server:npm run serve

## Backend (PHP version 8.2.6)

1. Open a new tab in your command line and navigate to the directory of the API:
2. If the .env file is not found, create it in the root folder:
3. Create a database in your MySQL console named "homecareagency" (or any name of your choice if .env is not found).

4. Run the following commands in your command line:
- Update Composer dependencies:
  ```
  composer update
  ```
  or
  ```
  composer install
  ```
- Run database migrations:
  ```
  php artisan migrate
  ```
- Seed the database:
  ```
  php artisan db:seed
  ```
- Generate an application key:
  ```
  php artisan key:generate
  ```
- Start the Laravel development server:
  ```
  php artisan serve
  ```

## Admin Credentials

To configure the application, use the following admin credentials:
- Username: testadmin
- Password: password

## Default URL

Access the application at: http://localhost:8080/

## User Registration

- Register as a client: http://localhost:8080/register/client
- Register as a health care worker: http://localhost:8080/register/health-care-worker

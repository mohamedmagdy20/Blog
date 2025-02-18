# Laravel Project Setup Guide

## Prerequisites

Make sure you have the following installed on your system:

- PHP (>=8.1 recommended)
- Composer
- MySQL or any other supported database
- Node.js & NPM (for frontend dependencies)
- Laravel CLI
- Git

## Clone the Repository

```sh
git clone <your-repository-url>
cd <your-project-folder>
```

## Install Dependencies

```sh
composer install
```

## Create Environment File

Copy the `.env.example` file and rename it to `.env`:

```sh
cp .env.example .env
```

## Generate Application Key

```sh
php artisan key:generate
```

## Configure Database

Update the `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Run Migrations

```sh
php artisan migrate
```



## Serve the Application

```sh
php artisan serve
```


Your Laravel project should now be running at `http://127.0.0.1:8000/`.

## Additional Commands

- To clear caches:
  ```sh
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```
- To run tests:
  ```sh
  php artisan test
  ```

## Contributing

Feel free to fork and submit pull requests. Ensure your code follows Laravel best practices.

## License

This project is licensed under the MIT License.


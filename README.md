# Backend PHP

This is a PHP backend project.

## Requirements

- PHP >= 7.0
- Composer
- MySQL

## Configuration

### 1. Copy Environment File

Create a file named `.env` in the root of the project and configure the necessary environment variables. You can find an example in the `.env.example` file.

```plaintext
DATABASE_HOST=localhost
DATABASE_USER=root
DATABASE_PASSWORD=password
DATABASE_NAME=my_database
```

### 2. Install Composer Dependencies 

Run the following command to install all necessary dependencies:

```bash
composer install
```

### 3. Running the Server

To start the backend server, run the following command in the root of the project:

```bash
php -S localhost:8000
```

## Important!
The url for backend server should be added in the front end project in the .env file 






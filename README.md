# Inventory Management System

The Inventory Management System is a web application built using Laravel 7. It provides a comprehensive solution for managing inventory, including user management, product management, categories, comments, feedback, and more.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- User Management
- Product Management
- Category Management
- Comment and Feedback System
- Product Images
- Product Attributes and SKU Management
- Product Category Management

## Requirements

- PHP >= 7.2.5
- Laravel Framework 7.29
- Composer
- MySQL

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/ajaylove1shi/inventory-management-system.git
    cd inventory-management-system
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Create a copy of the `.env` file:
    ```bash
    cp .env.example .env
    ```

4. Generate an application key:
    ```bash
    php artisan key:generate
    ```

5. Configure your database settings in the `.env` file.

6. Run the database migrations:
    ```bash
    php artisan migrate
    ```

7. Serve the application:
    ```bash
    php artisan serve
    ```

## Usage

Once the application is installed and running, you can access it at `http://localhost:8000`.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any changes.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

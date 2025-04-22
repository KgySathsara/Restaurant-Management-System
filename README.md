# Restaurant Management System

A PHP-based web application for managing concessions, orders, and kitchen operations in a restaurant environment.

## Features

### Concession Management
- **Create, edit, and delete concessions**  
  Fields: Name (required), Description, Image (required), Price (required).

### Order Management
- **Create orders** by selecting multiple concessions and setting a "Send to Kitchen Time".
- **Automatic/Manual dispatch**: Orders are sent to the kitchen automatically at the scheduled time or manually via a button.
- **Order status**: Defaults to "Pending", changes to "In-Progress" when sent to the kitchen.

### Kitchen Management
- **Queue-based system** for incoming orders.
- **Update order status** (Pending → In-Progress → Completed).
- **Order details**: Displays order ID, total cost, and status.

## Tech Stack
- **Backend**: PHP (Laravel/CodeIgniter)
- **Database**: MySQL
- **Design Pattern**: Repository Pattern (optional)
- **Frontend**: HTML, CSS, JavaScript (minimal for core functionality)

## Prerequisites
- PHP 7.4+
- Composer (for Laravel)
- MySQL 5.7+
- Web server (Apache/Nginx) or PHP built-in server

## Installation

### 1. Clone the Repository
### 2. composer update
### 3. .env file DB name set
### 4. php artisan migrate   and   php artisan db:seed   run this commands
### 5. php artisan storage:link   command run

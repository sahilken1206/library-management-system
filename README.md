
# Library & Book Management System

A web-based Library & Book Management System developed using PHP and MySQL as part of a TYBCA internship project.

## Technologies Used

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- XAMPP for local development

## Features

- Admin login and authentication
- Dashboard displaying library statistics
- Add, view, update, search and delete books
- Manage library members
- Issue books to registered members
- Record book loan dates and due dates
- Record book returns
- Display loan and overdue information
- Database queries using prepared statements for supported operations
- Basic input validation and output escaping

## Database Tables

- `users` — login accounts
- `authors` — author records
- `books` — book information and quantities
- `members` — registered library members
- `loans` — book loans, due dates and return dates

The `books` table stores the author's name as text. The `authors` table is separate in the current schema.

## Installation and Setup

1. Install XAMPP and start Apache and MySQL.
2. Copy the project folder into the XAMPP `htdocs` directory.
3. Open phpMyAdmin at `http://localhost/phpmyadmin/`.
4. Create a new database named `library`.
5. Select the `library` database and open the Import tab.
6. Import the project's `schema.sql` file into the empty database.
7. Configure `db.php` with your own local database connection details.
8. Open `http://localhost/library-system/` in your browser.
9. Sign in using an administrator account that has been created securely.

## Security Notes

- Do not commit database passwords or other private credentials to GitHub.
- Keep `db.php` out of public repositories if it contains credentials.
- Passwords should be stored as secure hashes generated with PHP's `password_hash()` function and checked with `password_verify()`.
- Do not upload temporary password-generation scripts such as `generate_hash.php`.
- Validate input and escape displayed user-supplied data.

## Project Purpose

This project demonstrates database management, CRUD operations, authentication, input validation and basic web application security using PHP and MySQL.

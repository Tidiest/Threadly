# Threadly

**A Reddit-inspired community forum built with PHP and MySQL.**

Threadly is a web-based forum application where users can create communities, publish posts, interact through comments and likes, and manage their own profiles.

The project was developed independently as a full-stack web development project.

## Features

### Communities
- Create, edit and delete communities
- Add descriptions and assign categories
- Browse communities created by other users
- Search communities by name, description or author
- Sort communities by name, date, user or popularity
- Pin posts within a community

### Posts & Comments
- Create, edit and delete posts
- Comment on posts and manage your own comments
- Like and unlike posts
- Display post likes and comment counts
- Close or reopen comments on individual posts

### User Accounts
- User registration and login
- Form validation
- Password hashing
- Password changes
- Individual user profiles
- Custom profile pictures
- Editable profile descriptions
- Browse users' communities and posts

### Administration
- Dedicated admin panel
- Manage forum categories
- Browse and manage registered users
- User moderation

### User Permissions

The application distinguishes between three levels of access:

- **Guests:** Browse communities, posts and comments.
- **Registered users:** Create content, interact with posts and comments, and manage their own content.
- **Administrators:** Access administrative tools and moderate forum content.

## Demo Accounts

The database includes preconfigured accounts so you can explore the application without registering.

| Account | Email | Password |
|---|---|---|
| Administrator | `admin@gmail.com` | `Admin_111` |
| Test user | `testlogin@lol` | `TestLoginLol1!` |

The administrator account provides access to the admin panel and moderation features.

The test account allows you to explore the application with regular user permissions.

**These credentials are intended exclusively for the local Threadly demo database.**

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP | Backend logic |
| MySQL / MariaDB | Database |
| MySQLi | Database connectivity |
| HTML5 | Page structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive interface |
| Popper.js | UI component positioning |

## Local Setup

Threadly was developed and tested locally using XAMPP.

### Requirements
- XAMPP or another Apache + MySQL environment
- PHP
- MySQL or MariaDB
- MySQLi PHP extension

### Installation

1. Clone this repository.
2. Copy the project folder into XAMPP's `htdocs` directory.
3. Start Apache and MySQL.
4. Create a database named `forum2pr`.
5. Import `forum2pr.sql` using phpMyAdmin.
6. If necessary, update the database connection settings in `config.php` to match your local MySQL configuration.
7. Open the application:

   `http://localhost/Threadly/show_thread.php`

Log in using one of the demo accounts above or register a new account.

## Project Structure

The project uses a straightforward PHP structure, with separate files handling authentication, communities, posts, comments, user profiles, administration and database operations.

## Project Status

Completed educational project.

This project demonstrates practical experience with server-side PHP development, relational databases, authentication, user-generated content and CRUD operations.

It is not intended for production deployment without additional security improvements.

## Project Information

- **Type:** Individual school project
- **Development period:** 2025

## Author

**Oleksandr Krotov**

[GitHub Profile](https://github.com/Tidiest)
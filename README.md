# ZephaChat App

ZephaChat is a lightweight, real-time web chat application built with PHP, JavaScript, and HTML. It enables users to register, log in, engage in public conversations, and conduct private one-on-one chats with other online users.

## Features

- User Authentication – Secure registration and login system
- Session Management – Persistent user sessions
- Real-Time Messaging – Send and receive messages instantly
- Private Chat – Direct messaging between users
- Online Users List – View other active users
- User Profiles – View and manage user profiles
- Database Integration – MySQL database schema included
- Icon Support – Custom icons for enhanced UI
- Keep-Alive Mechanism – Ping script to maintain active connections

## Tech Stack

- Backend: PHP
- Frontend: HTML, JavaScript
- Database: MySQL
- Server: Apache / Nginx

## Project Structure

```
zephachat-app/
├── config.php           # Database & app configuration
├── database.sql         # SQL schema for tables
├── fetch.php            # Fetch new messages
├── icons.js             # Icon definitions
├── index.html           # Main chat interface
├── login.html           # Login page
├── login.php            # Login handler
├── logout.php           # Logout handler
├── people.php           # List online users
├── ping.php             # Keep session alive
├── private_chat.php     # Private messaging logic
├── profile.html         # User profile view
├── profile.php          # Profile update handler
├── register.php         # User registration
├── send.php             # Send message handler
└── session.php          # Session validation
```

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/samax-labs/zephachat-app.git
   ```

2. Set up the database:
   - Create a MySQL database
   - Import `database.sql` to create the required tables

3. Configure the app:
   - Edit `config.php` with your database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'your_database');
     ```

4. Run the application:
   - Place the project folder in your web server's root directory
   - Access via `http://localhost/zephachat-app/`

## Usage

1. Register a new account via `register.php`
2. Login using your credentials (`login.html`)
3. Chat publicly from the main `index.html` interface
4. Start a private chat by selecting a user from the online list (`people.php`)
5. Update your profile via `profile.html`

## Contributing

Contributions, issues, and feature requests are welcome. Feel free to check the issues page.

## Authors

- **Orono Sam** - [samax-labs](https://github.com/samax-labs)
- **Orono Samuel** - [oronosamuel207](https://github.com/oronosamuel207)

## License

This project is currently unlicensed. All rights reserved by the authors.

## Show Your Support

Give a star if this project helped you.

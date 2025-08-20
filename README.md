Simple PHP Blog System

A lightweight blog application built with **PHP** and **MySQL**, featuring user authentication and session management.  

 🚀 Features
- User Registration with **secure password hashing** (`password_hash`, `password_verify`).
- User Login & Logout using PHP sessions.
- Basic blog structure with multiple pages (`home`, `login`, `register`).
- MySQL database integration.

 🛠️ Requirements
- PHP ≥ 7.4  
- MySQL (or MariaDB)  
- Web server (Apache, Nginx, or PHP built-in server)  

📂 Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   ```

2. Import the database:
   - Create a database named `blog`.  
   - Import the `users` table:
     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(100) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL
     );
     ```

3. Update database settings inside `PHPCode.php`:
   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "blog";
   ```

4. Run the project:
   ```bash
   php -S localhost:8000
   ```
   Visit **http://localhost:8000/PHPCode.php?page=home**

 📌 Roadmap
- Add post creation/editing/deletion.  
- Add comments system.  
- Improve UI with Bootstrap/Tailwind.  

 🤝 Contributing
Contributions are welcome! Please open an issue or submit a pull request. 

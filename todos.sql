CREATE TABLE
    todos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        todo_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
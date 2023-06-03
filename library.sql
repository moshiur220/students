CREATE TABLE
    library (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        location VARCHAR(255) NOT NULL,
        noBooks INT NOT NULL,
        phone VARCHAR(20) NOT NULL
    );
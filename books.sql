CREATE TABLE
    books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booksName VARCHAR(255) NOT NULL,
        authorName VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        image VARCHAR(255) NOT NULL
    );
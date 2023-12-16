<?php

include('db.php');

// users table
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(191) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    stripe_customer_id VARCHAR(255) NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";


if ($conn->query($sqlUsers) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table users: " . $conn->error;
}

// products table
$sqlProducts = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INTEGER DEFAULT 0,
    stripe_product_key VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";


if ($conn->query($sqlProducts) === TRUE) {
    echo "Table products created successfully";
} else {
    echo "Error creating table products: " . $conn->error;
}

// carts table
$sqlCarts = "CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";


if ($conn->query($sqlCarts) === TRUE) {
    echo "Table carts created successfully";
} else {
    echo "Error creating table carts: " . $conn->error;
}

// payments table
$sqlPayments = "CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cart_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_reference VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL,
    amount_paid DECIMAL(10,2) NOT NULL,
    invoice VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (cart_id) REFERENCES carts(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";


if ($conn->query($sqlPayments) === TRUE) {
    echo "Table payments created successfully";
} else {
    echo "Error creating table payments: " . $conn->error;
}

$conn->close();
?>

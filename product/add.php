<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];

    // Validate input
    if (empty($name) || empty($price)) {
        echo "Product name and price are required.";
    } else {
        // Insert product into the database
        $insertQuery = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssd", $name, $description, $price);

        if ($stmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>
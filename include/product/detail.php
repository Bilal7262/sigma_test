<?php
if (isset($_GET['id'])) {
    include('db.php'); // Assuming your database connection code is in 'db.php'

    $productId = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }

    $conn->close();
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .product-details {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-details p {
        color: #666;
    }

    .product-details form {
        margin-top: 10px;
    }
</style>
<body>

    <h2><?php echo $product['name']; ?> Details</h2>

    <div class="product-details">
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <form action="cart" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1" required>
            <input type="submit" value="Add to Cart">
        </form>
    </div>

</body>
</html>

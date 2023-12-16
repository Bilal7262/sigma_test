<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Validate the product ID and quantity (you may want to add more validation)
    if (!is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
        echo "Invalid product ID or quantity.";
        exit;
    }

    // Check if the product exists
    $checkProductQuery = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($checkProductQuery);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product exists, proceed to add it to the cart
        $userId = 1; // Assuming a static user ID for demonstration purposes

        $addToCartQuery = "INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($addToCartQuery);
        $stmt->bind_param("iii", $userId, $productId, $quantity);

        if ($stmt->execute()) {
            echo "Product added to cart successfully.";
        } else {
            echo "Error adding product to cart: " . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
}

// Retrieve cart items for the current user
$userId = 1; // Assuming a static user ID for demonstration purposes
$getCartItemsQuery = "SELECT products.*, carts.quantity as cart_quantity, carts.id as cart_id ,carts.product_id FROM products JOIN carts ON products.id = carts.product_id WHERE carts.user_id = ?";
$stmt = $conn->prepare($getCartItemsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$cartItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// print_r($cartItems);
// exit;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $removeCartId = $_POST['remove_item'];

    // Validate the product ID
    if (!is_numeric($removeCartId)) {
        echo "Invalid product ID.";
        exit;
    }

    // Remove the product from the cart
    $removeFromCartQuery = "DELETE FROM carts WHERE id = ?";
    $stmt = $conn->prepare($removeFromCartQuery);
    $stmt->bind_param("i", $removeCartId);

    if ($stmt->execute()) {
        header("Location: $link_path");
            exit();
    } else {
        echo "Error removing product from cart: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
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

        .cart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cart-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .cart-item h3 {
            color: #333;
        }

        .cart-item p {
            color: #666;
        }
        .cart-item button {
            margin-top: 10px;
            padding: 8px;
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cart-item button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

    <h2>Your Cart</h2>

    <div class="cart-container">
        <?php if (!empty($cartItems)) : ?>
            <?php foreach ($cartItems as $cartItem) : ?>
                <div class="cart-item">
                    <h3><?php echo $cartItem['name']; ?></h3>
                    <p>Price: $<?php echo $cartItem['price']; ?></p>
                    <p>Quantity in Cart: <?php echo $cartItem['cart_quantity']; ?></p>
                    <form method="post" action="<?php echo $link_path; ?>">
                        <input type="hidden" name="remove_item" value="<?php echo $cartItem['cart_id']; ?>">
                        <button type="submit" name="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>

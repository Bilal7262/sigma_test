<?php

if(isset($_REQUEST['productId']) && isset($_REQUEST['productName']) && isset($_REQUEST['productPrice'])){


\Stripe\Stripe::setApiKey('sk_test_51MMRybSIDk2ewbQpqmh4DsjtaYqF69B4PQOyAN7VK65RgMM0v2CzIRjK3mGr23ECyg3jSULWRpmpRsjWyb7eKhRz00CAE6Jw37');

$productId = $_GET['productId'];
$productName = $_GET['productName'];
$productPrice = $_GET['productPrice'];

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $productName,
            ],
            'unit_amount' => $productPrice * 100, 
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/sigma_test/dashboard', 
    'cancel_url' => 'http://localhost/sigma_test/dashboard',
]);

// Redirect to Checkout
header('Location: ' . $checkout_session->url);
exit;
}


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
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
.productsWrapper{
    display: flex;
    column-gap: 50px;
    width: 100%;
    justify-content:center;
}
        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            max-width:400px;
            width: 100%;
            flex-direction: column;
            align-items: center;
        }

        .product h3 {
            color: #333;
        }

        .product p {
            color: #666;
        }

        .product-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .buy-button,
        .add-to-cart-button {
            padding: 8px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .buy-button:hover,
        .add-to-cart-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Products</h2>
<div class="productsWrapper">
<div class="productsWrapper">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="product">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
                <div class="product-buttons">
                    <!-- Add a form around the "Buy" button -->
                    <form method="get">
                        <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="productName" value="<?php echo $row['name']; ?>">
                        <input type="hidden" name="productPrice" value="<?php echo $row['price']; ?>">
                        <button type="submit" class="buy-button">Buy</button>
                    </form>
                    <button class="view-details-button" onclick="viewDetails(<?php echo $row['id']; ?>)">View Details</button>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No products found.";
    }
    ?>
</div>
</div>
    <script>
        function buyProduct(productId) {
            // Implement the logic to handle the "Buy" button click
            alert('Buying product with ID: ' + productId);
        }

        function viewDetails(productId) {
            // Redirect to the product-details URL
            window.location.href = 'http://localhost/sigma_test/product-details?id=' + productId;
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Validate input
    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
    } else {
        $selectQuery = "SELECT id, name, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                echo "Login successful!";
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    }
}

$conn->close();
?>
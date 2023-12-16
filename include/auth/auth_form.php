<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            color: red;
            margin-top: 0;
        }
    </style>
</head>
<body>

<?php
 if ($link=='register'){ 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errors = [];

    // Validate name, email, password, confirm password (same as before)

    if (empty($errors)) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost/sigma_test/api/register',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'name' => $name,
            'email' => $email,
            'password' => $password
          ),
          CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=jbq4106fea7n68j3435jtsg9br'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        echo "Registration response: " . $response;

        // Check if registration was successful
        if (strpos($response, 'Registration successful') !== false) {
            // Redirect to the dashboard
            header("Location: $link_path");
            exit();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }

}
}
if($link == 'login'){


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    // Validate name, email, password, confirm password (same as before)

    if (empty($errors)) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost/sigma_test/api/login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'email' => $email,
            'password' => $password
          ),
          CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=jbq4106fea7n68j3435jtsg9br'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        echo "Login response: " . $response;

        // Check if registration was successful
        if (strpos($response, 'Login successful') !== false) {
            // Redirect to the dashboard
            header("Location: http://localhost/sigma_test/dashboard");
            exit();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }

}

}
?>

<?php if ($link=='register'){ ?>
<!-- Registration Form -->
<form method="post" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" required>
    <br>
    <input type="submit" value="Register">
</form>
<?php } ?>


<?php if ($link=='login'){ ?>
<form method="post" action="">
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Login">
</form>
<?php } ?>

</body>
</html>

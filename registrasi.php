<?php
session_start();
require 'koneksi.php'; 

$error_register = false;

if (isset($_POST["register"])) {
    $username = strtolower(stripslashes($_POST["username"]));
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        $error_register = "Username sudah terdaftar. Silakan gunakan username lain.";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, email, password, phone) VALUES('$username', '$email', '$password', '$phone')";
        mysqli_query($conn, $query);
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f0f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .register-card {
            background-color: #ffffff;
            width: 600px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #2c7f7b;
        }
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 50px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #2c7f7b;
            font-size: 1.2rem;
        }
        .register-button {
            background-color: #2c7f7b;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .register-button:hover {
            background-color: #236b67;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <h2>Create an Account</h2>
            <?php if (!empty($error_register)): ?>
                <div class="error">
                    <?php echo $error_register; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="phone" placeholder="Phone" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="register" class="register-button">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>

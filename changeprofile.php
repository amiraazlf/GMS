<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'koneksi.php';

$username = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $new_username = $_POST["username"];
    $new_email = $_POST["email"];
    $new_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $new_phone = $_POST["phone"];
    $query = "UPDATE user SET username = '$new_username', email = '$new_email', password = '$new_password', phone = '$new_phone' WHERE username = '$username'";
    mysqli_query($conn, $query);

    $_SESSION['username'] = $new_username;

    header("Location: changeprofile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
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
        .profile-card {
            background-color: #ffffff;
            width: 850px;
            display: flex;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-container {
            flex: 1;
            padding: 50px;
        }
        .form-container h2 {
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
        .update-button {
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
        .update-button:hover {
            background-color: #236b67;
        }
        .profile-image {
            flex: 1;
            background: linear-gradient(135deg, #2c7f7b 0%, #4fc3a1 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .login-image {
            flex: 1;
            background: linear-gradient(135deg, #2c7f7b 0%, #4fc3a1 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .login-image img {
            width: 280px;
        }
        .login-image .gms-text {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <div class="form-container">
                <h2>Update Profile</h2>
                <form action="" method="post">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" value="<?= $user['username']; ?>" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" value="<?= $user['email']; ?>" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="New Password" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phone" placeholder="Phone Number" value="<?= $user['phone']; ?>" required>
                    </div>
                    <button type="submit" name="update" class="update-button">Update Profile</button>
                </form>
            </div>
            <div class="login-image">
                <img src="gms.png" alt="GMSHub">
                <div class="gms-text">GMSHub</div>
            </div>
        </div>
    </div>
</body>
</html>

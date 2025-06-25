<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'koneksi.php';

$username = $_SESSION['username'];
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $new_username = $_POST["username"];
    $new_email = $_POST["email"];
    $new_password = password_hash($_POST["password"], PASSWORD_DEFAULT); 
    $new_phone = $_POST["phone"];

    $query = "UPDATE admin SET username = ?, email = ?, password = ?, phone = ? WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $new_username, $new_email, $new_password, $new_phone, $username);
    mysqli_stmt_execute($stmt);

    $_SESSION['username'] = $new_username;

    header("Location: changeprofile_admin.php");
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
            height: 100vh;
        }

        .navbar-side {
            position: fixed;
            top: 0;
            left: 0;
            width: 70px;
            height: 100%;
            background-color: #243642;
            color: white;
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .navbar-side:hover {
            width: 250px;
        }

        .navbar-side a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
            margin: 5px 10px;
            white-space: nowrap;
            overflow: hidden;
        }

        .navbar-side a span {
            margin-left: 10px;
            opacity: 0; 
            transition: opacity 0.3s ease;
        }

        .navbar-side:hover a span {
            opacity: 1;
        }

        .navbar-side a:hover {
            background-color: #e2f1e7;
            color: black;
        }

        .navbar-side a.active {
            background-color: #387478;
        }

        .navbar-side i {
            font-size: 20px;
        }

        .navbar-side a.logout {
            margin-top: auto; 
            margin-bottom: 30px;
            text-align: center;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            margin-left: 70px; 
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

        .login-button {
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

        .login-button:hover {
            background-color: #236b67;
        }

        .profile-image {
            flex: 1;
            background: linear-gradient(135deg, #2c7f7b 0%, #4fc3a1 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-image img {
            width: 280px;
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

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                margin-left: 0;
            }

            .navbar-side {
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 10px 0;
                overflow-x: auto;
            }

            .navbar-side a span {
                display: none;
            }

            .profile-card {
                width: 100%;
                flex-direction: column;
            }

            .form-container {
                padding: 20px;
            }

            .login-image img {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .form-container h2 {
                font-size: 1.5rem;
            }

            .input-group input {
                font-size: 0.9rem;
            }

            .login-button {
                font-size: 0.9rem;
                padding: 12px;
            }

            .login-image .gms-text {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .input-group input {
                padding: 10px 10px 10px 40px;
            }

            .login-image img {
                width: 150px;
            }

            .login-image .gms-text {
                font-size: 1.2rem;
            }

            .navbar-side a {
                padding: 8px 10px;
                margin: 2px 5px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar-side">
        <a href="admin_dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="event-admin.php">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
        <a href="seats-admin.php">
            <i class="fas fa-chair"></i>
            <span>Seats</span>
        </a>
        <a href="rsvp-admin.php">
            <i class="fas fa-user-check"></i>
            <span>RSVP</span>
        </a>
        <a href="changeprofile_admin.php" class="active">
            <i class="fas fa-user-cog"></i>
            <span>Change Profile</span>
        </a>
        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
    <div class="container">
        <div class="profile-card">
            <div class="form-container">
                <h2>Change Profile</h2>
                <form action="" method="post">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input placeholder="Username" type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required />
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input placeholder="Email" type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required />
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input placeholder="New Password" type="password" name="password" required />
                    </div>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input placeholder="Phone number" type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required />
                    </div>
                    <button type="submit" name="update" class="login-button">Update Profile</button>
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
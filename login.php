<?php
session_start();
require 'koneksi.php';

$error_login = false;
$error_register = false;

$form_type = isset($_GET['form']) && in_array($_GET['form'], ['login', 'signup']) ? $_GET['form'] : 'login';

if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $queries = [
        'admin' => "SELECT * FROM admin WHERE username = '$username'",
        'user' => "SELECT * FROM user WHERE username = '$username'"
    ];

    foreach ($queries as $role => $query) {
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["role"] = $role;

                $redirect = $role === 'admin' ? 'admin_dashboard.php' : 'gmsaflog.php';
                header("Location: $redirect");
                exit;
            } else {
                $error_login = "Password salah. Silakan coba lagi.";
            }
        }
    }

    $error_login = "Username tidak ditemukan. Silakan coba lagi.";
}

if (isset($_POST["register"])) {
    $username = strtolower(stripslashes($_POST["username"]));
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        $error_register = "Username sudah terdaftar!";
    } else {

        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (username, email, password, phone) VALUES('$username', '$email', '$password', '$phone')";
        mysqli_query($conn, $query);

        header("Location: login.php?form=login");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Gaya CSS */
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
        .login-card {
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
        .tab {
            display: flex;
            margin-bottom: 30px;
        }
        .tab div {
            flex: 1;
            text-align: center;
            padding: 12px;
            font-weight: bold;
            cursor: pointer;
        }
        .tab div.active {
            border-bottom: 3px solid #2c7f7b;
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
        .forgot-password {
            margin-top: 10px;
            text-align: right;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .forgot-password a {
            color: #2c7f7b;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
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
        <div class="login-card">
            <div class="form-container">
                <h2>Welcome to GMSHub</h2>
                <div class="tab">
                    <div id="login-tab" class="<?php echo $form_type === 'login' ? 'active' : ''; ?>" onclick="showLogin()">Login</div>
                    <div id="signup-tab" class="<?php echo $form_type === 'signup' ? 'active' : ''; ?>" onclick="showSignUp()">Sign Up</div>
                </div>

                <!-- Login Form -->
                <div id="login-form" style="display: <?php echo $form_type === 'login' ? 'block' : 'none'; ?>;">
                    <form action="" method="post">
                        <?php if ($error_login): ?>
                            <div class="error"><?php echo $error_login; ?></div>
                        <?php endif; ?>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="forgot-password">
                            <a href="forgot_password.php">Forgot Password?</a>
                        </div>
                        <button type="submit" name="login" class="login-button">Login</button>
                    </form>
                </div>

                <!-- Signup Form -->
                <div id="signup-form" style="display: <?php echo $form_type === 'signup' ? 'block' : 'none'; ?>;">
                    <form action="" method="post">
                        <?php if ($error_register): ?>
                            <div class="error"><?php echo $error_register; ?></div>
                        <?php endif; ?>
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
                        <button type="submit" name="register" class="login-button">Sign Up</button>
                    </form>
                </div>
            </div>
            <div class="login-image">
                <img src="gms.png" alt="GMSHub">
                <div class="gms-text">GMSHub</div>
            </div>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('signup-tab').classList.remove('active');
        }
        function showSignUp() {
            document.getElementById('signup-form').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('signup-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
        }
    </script>
</body>
</html>

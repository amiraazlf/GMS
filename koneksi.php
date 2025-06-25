<?php
$host = 'localhost';
$username = 'root';
$password = ''; 
$dbname = 'gmsproject';

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sign_up($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = mysqli_real_escape_string($conn, $data["email"]);
    $phone = mysqli_real_escape_string($conn, $data["phone"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);

    $result = mysqli_query($conn, "SELECT username FROM admin WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('USERNAME SUDAH TERDAFTAR')</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user (username, email, phone) VALUES ('$username', '$email', '$phone')");
    $user_id = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO admin (username, email, password, phone, user_id, role) VALUES ('$username', '$email', '$password', '$phone', $user_id, 'user')");

    return mysqli_affected_rows($conn);
}
?>
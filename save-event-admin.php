<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    die("Error: Only admins can access this page.");
}

$event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
$event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
$event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
$event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
$number_of_chairs = mysqli_real_escape_string($conn, $_POST['number_of_chairs']);
$admin_id = $_SESSION['admin_id'];
$user_id = $_SESSION['user_id']; 

// Validasi input
if (empty($event_name) || empty($event_description) || empty($event_date) || empty($event_location) || empty($number_of_chairs)) {
    die("Error: All fields are required.");
}

$query_insert = "INSERT INTO events (event_name, event_description, event_date, event_location, number_of_chairs, admin_id, user_id)
                 VALUES ('$event_name', '$event_description', '$event_date', '$event_location', '$number_of_chairs', $admin_id, $user_id)";

if (mysqli_query($conn, $query_insert)) {
    echo "<script>
    alert('Event added successfully!');
    window.location.href = 'event-admin.php';
    </script>";
} else {
    $error_message = mysqli_real_escape_string($conn, mysqli_error($conn)); 
    echo "<script>
    alert('Error adding event: $error_message');
    window.location.href = 'event-admin.php';
    </script>";
}
?>


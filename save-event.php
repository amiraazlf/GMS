<?php
session_start(); 
require 'koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    echo "Error: User is not logged in. Please login first.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_location = $_POST['event_location'];
    $number_of_chairs = $_POST['number_of_chairs'];
    $seating_arrangement = $_POST['seating_arrangement'];

    $stmt = $conn->prepare("INSERT INTO events (user_id, event_name, event_description, event_date, event_location, number_of_chairs, seating_arrangement) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssis", $user_id, $event_name, $event_description, $event_date, $event_location, $number_of_chairs, $seating_arrangement);

    if ($stmt->execute()) {
        echo "Event created successfully!";
        header("Location: event-admin.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

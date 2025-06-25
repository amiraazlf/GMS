<?php
session_start();
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $guest_name = $_POST['guest_name'];
    $guest_email = $_POST['guest_email'];
    $attendance = $_POST['attendance'];

    $stmt = $conn->prepare("INSERT INTO rsvp (event_id, guest_name, guest_email, attendance) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $event_id, $guest_name, $guest_email, $attendance);

    if ($stmt->execute()) {
        if ($attendance == 'yes') {
            header("Location: pilihkursi.php?event_id=" . $event_id); 
            exit();
        } else {
            echo "Thank you for your response!";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

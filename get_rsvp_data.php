<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Access denied']);
    exit();
}

if (isset($_GET['rsvp_id'])) {
    $rsvp_id = intval($_GET['rsvp_id']);

    $query = "SELECT 
                rsvp.id,
                rsvp.event_id,
                rsvp.attendance,
                events.event_name
              FROM rsvp 
              JOIN events ON rsvp.event_id = events.id 
              WHERE rsvp.id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $rsvp_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'id' => $row['id'],
            'event_id' => $row['event_id'],
            'attendance' => $row['attendance'],
            'event_name' => $row['event_name']
        ]);
    } else {
        echo json_encode(['error' => 'RSVP not found']);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'No RSVP ID provided']);
}

mysqli_close($conn);
?>
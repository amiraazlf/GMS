<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

if (!isset($_GET['event_id'])) {
    echo "Event ID is required.";
    exit();
}

$event_id = intval($_GET['event_id']);

$query_event = "SELECT * FROM events WHERE id = $event_id";
$result_event = mysqli_query($conn, $query_event);
if (!$result_event || mysqli_num_rows($result_event) === 0) {
    echo "Event not found.";
    exit();
}

$event = mysqli_fetch_assoc($result_event);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $number_of_chairs = intval($_POST['number_of_chairs']);

    $query_update = "
        UPDATE events 
        SET 
            event_name = '$event_name', 
            event_description = '$event_description', 
            event_date = '$event_date', 
            event_location = '$event_location', 
            number_of_chairs = $number_of_chairs
        WHERE id = $event_id
    ";
    mysqli_query($conn, $query_update) or die('Query Error: ' . mysqli_error($conn));
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="" method="POST">
        <label>Event Name:</label><br>
        <input type="text" name="event_name" value="<?= htmlspecialchars($event['event_name']) ?>" required><br><br>

        <label>Event Description:</label><br>
        <textarea name="event_description" required><?= htmlspecialchars($event['event_description']) ?></textarea><br><br>

        <label>Event Date:</label><br>
        <input type="datetime-local" name="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required><br><br>

        <label>Event Location:</label><br>
        <input type="text" name="event_location" value="<?= htmlspecialchars($event['event_location']) ?>" required><br><br>

        <label>Number of Chairs:</label><br>
        <input type="number" name="number_of_chairs" value="<?= $event['number_of_chairs'] ?>" required><br><br>

        <button type="submit">Update Event</button>
    </form>
</body>
</html>

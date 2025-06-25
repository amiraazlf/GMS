<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied: Only admins can access this page.");
}

if (!isset($_GET['event_id'])) {
    die("Error: Event ID not provided.");
}

$event_id = intval($_GET['event_id']);

$query_event = "SELECT * FROM events WHERE id = $event_id";
$result_event = mysqli_query($conn, $query_event);
if (!$result_event || mysqli_num_rows($result_event) === 0) {
    die("Error: Event not found.");
}

$event = mysqli_fetch_assoc($result_event);

if (isset($_POST['update'])) {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $number_of_chairs = mysqli_real_escape_string($conn, $_POST['number_of_chairs']);

    if (empty($event_name) || empty($event_description) || empty($event_date) || empty($event_location) || empty($number_of_chairs)) {
        $error_message = "All fields are required.";
    } else {
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
        if (mysqli_query($conn, $query_update)) {
            header("Location: event-admin.php?success=Event updated successfully!");
            exit();
        } else {
            $error_message = "Error updating event: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #27ae60;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Event</h1>
        <?php if (isset($error_message)): ?>
        <p class="error"><?= $error_message ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <input type="text" name="event_name" id="event_name" value="<?= htmlspecialchars($event['event_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="event_description">Event Description</label>
                <textarea name="event_description" id="event_description" rows="5" required><?= htmlspecialchars($event['event_description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input type="date" name="event_date" id="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required>
            </div>
            <div class="form-group">
                <label for="event_location">Event Location</label>
                <input type="text" name="event_location" id="event_location" value="<?= htmlspecialchars($event['event_location']) ?>" required>
            </div>
            <div class="form-group">
                <label for="number_of_chairs">Number of Chairs</label>
                <input type="number" name="number_of_chairs" id="number_of_chairs" value="<?= htmlspecialchars($event['number_of_chairs']) ?>" required>
            </div>
            <div class="form-group">
                <input type="submit" name="update" value="Update Event">
            </div>
        </form>
    </div>
</body>
</html>

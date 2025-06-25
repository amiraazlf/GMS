<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied: Only admins can access this page.");
}

if (!isset($_GET['rsvp_id'])) {
    die("Error: RSVP ID not provided.");
}

$rsvp_id = intval($_GET['rsvp_id']);

$query_rsvp = "SELECT * FROM rsvp WHERE id = $rsvp_id";
$result_rsvp = mysqli_query($conn, $query_rsvp);
if (!$result_rsvp || mysqli_num_rows($result_rsvp) === 0) {
    die("Error: RSVP not found.");
}

$rsvp = mysqli_fetch_assoc($result_rsvp);

if (isset($_POST['update'])) {
    $event_id = intval($_POST['event_id']);
    $attendance = mysqli_real_escape_string($conn, $_POST['attendance']);

    if (empty($event_id) || empty($attendance)) {
        $error_message = "All fields are required.";
    } else {
        $query_update = "
            UPDATE rsvp
            SET event_id = '$event_id', attendance = '$attendance'
            WHERE id = $rsvp_id
        ";

        if (mysqli_query($conn, $query_update)) {
            header("Location: rsvp-admin.php?success=RSVP updated successfully!");
            exit();
        } else {
            $error_message = "Error updating RSVP: " . mysqli_error($conn);
        }
    }
}

$query_events = "SELECT id, event_name FROM events";
$result_events = mysqli_query($conn, $query_events);
if (!$result_events) {
    die("Query Error (Events for Dropdown): " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RSVP</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container select, .form-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit RSVP</h2>
        <?php if (isset($error_message)): ?>
        <div class="message error"><?= $error_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="event_id">Event</label>
            <select name="event_id" required>
                <?php while ($event = mysqli_fetch_assoc($result_events)): ?>
                    <option value="<?= $event['id'] ?>" <?= $event['id'] == $rsvp['event_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['event_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="attendance">Attendance</label>
            <select name="attendance" required>
                <option value="yes" <?= $rsvp['attendance'] == 'yes' ? 'selected' : '' ?>>Attending</option>
                <option value="no" <?= $rsvp['attendance'] == 'no' ? 'selected' : '' ?>>Not Attending</option>
            </select>

            <input type="submit" name="update" value="Update RSVP">
        </form>
    </div>
</body>
</html>

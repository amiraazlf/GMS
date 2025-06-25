<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied: Only admins can access this page.");
}

if (!isset($_GET['seat_id'])) {
    die("Error: Seat ID not provided.");
}

$seat_id = intval($_GET['seat_id']);

$query_seat = "SELECT * FROM seats WHERE id = $seat_id";
$result_seat = mysqli_query($conn, $query_seat);
if (!$result_seat || mysqli_num_rows($result_seat) === 0) {
    die("Error: Seat not found.");
}

$seat = mysqli_fetch_assoc($result_seat);

if (isset($_POST['update'])) {
    $event_id = intval($_POST['event_id']);
    $seat_number = mysqli_real_escape_string($conn, $_POST['seat_number']);
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    if (empty($seat_number) || empty($event_id)) {
        $error_message = "All fields are required.";
    } else {
        $query_update = "
            UPDATE seats
            SET event_id = '$event_id', seat_number = '$seat_number', is_available = $is_available
            WHERE id = $seat_id
        ";

        if (mysqli_query($conn, $query_update)) {
            header("Location: seats-admin.php?success=Seat updated successfully!");
            exit();
        } else {
            $error_message = "Error updating seat: " . mysqli_error($conn);
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
    <title>Edit Seat</title>
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
        .form-container select, .form-container input[type="text"], .form-container input[type="checkbox"], .form-container input[type="submit"] {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            font-size: 16px;
        }
        .form-container input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #27ae60;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Seat</h2>

        <?php if (isset($error_message)): ?>
        <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="event_id">Event</label>
            <select name="event_id" required>
                <?php while ($event = mysqli_fetch_assoc($result_events)): ?>
                    <option value="<?= $event['id'] ?>" <?= $event['id'] == $seat['event_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['event_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="seat_number">Seat Number</label>
            <input type="text" name="seat_number" value="<?= htmlspecialchars($seat['seat_number']) ?>" required>

            <label>
                <input type="checkbox" name="is_available" <?= $seat['is_available'] ? 'checked' : '' ?>> Available
            </label>

            <input type="submit" name="update" value="Update Seat">
        </form>
    </div>
</body>
</html>

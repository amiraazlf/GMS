<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

if (!isset($_GET['seat_id'])) {
    echo "Seat ID is required.";
    exit();
}

$seat_id = intval($_GET['seat_id']);

$query_seat = "SELECT * FROM seats WHERE id = $seat_id";
$result_seat = mysqli_query($conn, $query_seat);
if (!$result_seat || mysqli_num_rows($result_seat) === 0) {
    echo "Seat not found.";
    exit();
}

$seat = mysqli_fetch_assoc($result_seat);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat_number = mysqli_real_escape_string($conn, $_POST['seat_number']);
    $is_available = intval($_POST['is_available']);

    $query_update = "
        UPDATE seats 
        SET 
            seat_number = '$seat_number', 
            is_available = $is_available
        WHERE id = $seat_id
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
    <title>Edit Seat</title>
</head>
<body>
    <h1>Edit Seat</h1>
    <form action="" method="POST">
        <label>Seat Number:</label><br>
        <input type="text" name="seat_number" value="<?= htmlspecialchars($seat['seat_number']) ?>" required><br><br>

        <label>Is Available:</label><br>
        <select name="is_available" required>
            <option value="1" <?= $seat['is_available'] == 1 ? 'selected' : '' ?>>Available</option>
            <option value="0" <?= $seat['is_available'] == 0 ? 'selected' : '' ?>>Unavailable</option>
        </select><br><br>

        <button type="submit">Update Seat</button>
    </form>
</body>
</html>

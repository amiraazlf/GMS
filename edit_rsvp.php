<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

if (!isset($_GET['rsvp_id'])) {
    echo "RSVP ID is required.";
    exit();
}

$rsvp_id = intval($_GET['rsvp_id']);

$query_rsvp = "SELECT * FROM rsvp WHERE id = $rsvp_id";
$result_rsvp = mysqli_query($conn, $query_rsvp);
if (!$result_rsvp || mysqli_num_rows($result_rsvp) === 0) {
    echo "RSVP not found.";
    exit();
}

$rsvp = mysqli_fetch_assoc($result_rsvp);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance = mysqli_real_escape_string($conn, $_POST['attendance']);

    $query_update = "
        UPDATE rsvp 
        SET 
            attendance = '$attendance'
        WHERE id = $rsvp_id
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
    <title>Edit RSVP</title>
</head>
<body>
    <h1>Edit RSVP</h1>
    <form action="" method="POST">
        <label>Attendance:</label><br>
        <select name="attendance" required>
            <option value="yes" <?= $rsvp['attendance'] === 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= $rsvp['attendance'] === 'no' ? 'selected' : '' ?>>No</option>
        </select><br><br>

        <button type="submit">Update RSVP</button>
    </form>
</body>
</html>

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "Error: User is not logged in. Please login first.";
    exit();
}

$event_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo "Error: Event not found or you do not have permission to edit this event.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_location = $_POST['event_location'];
    $number_of_chairs = $_POST['number_of_chairs'];
    $seating_arrangement = $_POST['seating_arrangement'];

    $update_stmt = $conn->prepare("UPDATE events SET event_name = ?, event_description = ?, event_date = ?, event_location = ?, number_of_chairs = ?, seating_arrangement = ? WHERE id = ? AND user_id = ?");
    $update_stmt->bind_param("ssssiisi", $event_name, $event_description, $event_date, $event_location, $number_of_chairs, $seating_arrangement, $event_id, $_SESSION['user_id']);

    if ($update_stmt->execute()) {
        echo "Event updated successfully!";
        header("Location: history.php");
        exit();
    } else {
        echo "Error updating event: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Style Global */
        :root {
        --dark: #243642;
        --sage: #387478;
        --green: #629584;
        --light: #e2f1e7;
      }
        body {
            font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: var(--sage);
        min-height: 50vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        z-index: 0;
        overflow-x: hidden;
        overflow-y: auto;
        position: relative;
        }

        .container {
            max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: var(--light);
        border: 1px solid #ccc;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        justify-content: center;
        margin-top: 50px;
        }

        h1 {
            border-bottom: 2px solid var(--dark);
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        font-size: 28px;
        margin: 0;
        color: black;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: var(--dark);
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #00a99d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-align: center;
        }

        .btn:hover {
            background-color: #008f82;
        }

        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 169, 157, 0.3);
        }
        .submit-btn {
        display: flex;
        justify-content: center;
        width: 100%;
      }
      .submit-btn button {
        padding: 10px 20px;
        background-color: var(--dark);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: auto;
      }
      .submit-btn button:hover {
        background-color: var(--green);
        color: white;
      }
    </style>
</head>
<body>
    <div class="navbar-side" id="navbarSide">
        <a href="admin_dashboard.php" class="active">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="event-admin.php">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>
        <a href="seats-admin.php">
            <i class="fas fa-chair"></i>
            <span>Seats</span>
        </a>
        <a href="rsvp-admin.php">
            <i class="fas fa-user-check"></i>
            <span>RSVP</span>
        </a>
        <a href="changeprofile_admin.php">
            <i class="fas fa-user-cog"></i>
            <span>Change Profile</span>
        </a>
    </div>

    <div class="container">
        <h1>Edit Event</h1>
        <form action="" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>" required>

            <label for="event_description">Event Description:</label>
            <input type="text" id="event_description" name="event_description" value="<?php echo $event['event_description']; ?>" required>

            <label for="event_date">Date and Time:</label>
                <input type="text" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>


            <label for="event_location">Event Location:</label>
            <input type="text" id="event_location" name="event_location" value="<?php echo $event['event_location']; ?>" required>

            <label for="number_of_chairs">Number of Chairs:</label>
            <input type="text" id="number_of_chairs" name="number_of_chairs" value="<?php echo $event['number_of_chairs']; ?>" required>

            <div class="submit-btn">
            <button type="submit" class="btn">Update Event</button>
            </div>
        </form>
    </div>
</body>
</html>

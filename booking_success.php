<?php

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$booking_code = isset($_GET['booking_code']) ? $_GET['booking_code'] : '';

require 'koneksi.php';
$event_sql = "SELECT event_name, event_date, location FROM events WHERE id = ?";
$event_stmt = $conn->prepare($event_sql);
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_data = $event_result->fetch_assoc();
$conn->close();

if (!$event_data) {
    echo "Event tidak ditemukan!";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
            width: 90%;
        }

        h1 {
            color: #28a745;
        }

        .booking-code {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .event-details {
            text-align: left;
            font-size: 18px;
        }

        .back-home {
            margin-top: 20px;
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-home:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Successful!</h1>
        <p class="booking-code">Your Booking Code: <?= $booking_code ?></p>
        <div class="event-details">
            <p><strong>Event Name:</strong> <?= htmlspecialchars($event_data['event_name']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($event_data['event_date']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($event_data['location']) ?></p>
        </div>
        <a href="index.php" class="back-home">Back to Home</a>
    </div>
</body>
</html>

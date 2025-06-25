<?php
session_start();
require 'koneksi.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM events WHERE user_id = '$user_id' ORDER BY event_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event History</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Style global */
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
        }

        .navbar {
            background-color: var(--dark);
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .navbar .menu-icon {
            font-size: 24px;
            margin-right: 20px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 10px;
            transition: background-color 0.3s;
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

        table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 10px;
        table-layout: fixed;
        }
        table, th, td {
        border: 1px solid #ccc;
        }

        th, td {
        padding: 15px;
        text-align: left;
        word-wrap: break-word; 
        word-break: break-all; 
        }

        th {
        background-color: var(--dark);
        color: white;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }

        tr:hover {
        background-color: #f1f1f1;
        }

        td a {
            text-decoration: none;
            color:var(--dark);
            background-color: #e8f5f3;
            padding: 8px 12px;
            border: 1px solid var(--dark);
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        td a:hover {
            background-color: var(--dark);
            color: white;
        }
        .navbar .nav-links a:hover {
            background-color: var(--light);
            color: black;
        }
        .navbar .nav-links a.active {
        background-color: var(--light);
        color: black;
      }

      .navbar .nav-links a.active:hover {
        background-color: var(--dark);
        color: white;
      }
    </style>
</head>
<body>
    <div class="navbar">
        <i class="fas fa-bars menu-icon"></i>
        <div class="nav-links">
            <a href="gmsaflog.php">Main Dashboard</a>
            <a href="organizer.php">Home</a>
            <a href="create-event.php">Create Event</a>
            <a href="inviteguest.php">Invite Guest</a>
            <a href="guest-presence.php">Track Attendace</a>
            <a href="history.php" class="active">Event History</a>
        </div>
    </div>

    <div class="container">
        <h1>Event History</h1>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Number of Chairs</th>
                <th>Seating Arrangement</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['event_name']}</td>
                            <td>{$row['event_description']}</td>
                            <td>{$row['event_date']}</td>
                            <td>{$row['event_location']}</td>
                            <td>{$row['number_of_chairs']}</td>
                            <td>{$row['seating_arrangement']}</td>
                            <td>
                                <a href='edit-event.php?id={$row['id']}'>Edit</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align: center;'>No events found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>



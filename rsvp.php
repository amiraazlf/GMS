<?php
session_start();
require 'koneksi.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form RSVP
    $event_id = $_POST['event_id'];
    $guest_name = $_POST['guest_name'];
    $guest_email = $_POST['guest_email'];
    $attendance = $_POST['attendance'];

    $stmt = $conn->prepare("INSERT INTO rsvp (event_id, guest_name, guest_email, attendance) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $event_id, $guest_name, $guest_email, $attendance);

    if ($stmt->execute()) {
        if ($attendance == 'yes') {
            header("Location: pilihkursi.php?event_id=" . $event_id); 
            exit();
        } else {
            echo "Thank you for your response!";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Event</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        :root {
        --dark: #243642;
        --sage: #387478;
        --green: #629584;
        --light: #e2f1e7;
      }
        body, html {
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

        .navbar {
        background-color: var(--dark);
        color: white;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        width: 100%;
        box-sizing: border-box;
        flex-wrap: wrap;
        margin-top: -4rem;
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


        .rsvp-form {
            max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: var(--light);
        border: 1px solid #ccc;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        justify-content: center;
        margin-top: 50px;
        }

        .rsvp-form h2 {
            text-align: center;
            margin: 10px 0 20px;
            color: #333;
            font-size: 24px;
            border-bottom: 2px solid var(--dark);
            padding-bottom: 10px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 0.5rem 0 0.3rem;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        select {
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid black;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: black;
            outline: none;
            background-color: white;
            color: black;
        }

        .submit-btn {
        padding: 10px 20px;
        width: auto;
        max-width: 200px;
        margin: 0 auto;
        background-color: var(--dark);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: var(--green);
        }

        footer {
            text-align: center;
            padding: 2rem;
            background-color: #333;
            color: white;
            margin-top: 3rem;
        }

        .social-links a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <i class="fas fa-bars menu-icon"></i>
            <div class="nav-links">
                <a href="gmsaflog.php">Main Dashboard</a>
                <a href="guest.php">Home</a>
                <a href="rsvp.php"class="active">RSVP</a>
                <a href="pilihkursi.php">Select Seat</a>
            </div>
        </div>
    </header>

    <section class="rsvp-form">
    <h2>RSVP Form</h2>
    <form id="rsvpForm" action="submit-rsvp.php" method="POST">
        <label for="event">Select Event:</label>
        <select id="event" name="event_id" required>
            <option value="">-- Select an Event --</option>
            <?php
            require 'koneksi.php';
            $sql = "SELECT id, event_name FROM events ORDER BY event_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['event_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No events available</option>";
            }

            $conn->close();
            ?>
        </select>

        <label for="guest_name">Name:</label>
        <input type="text" id="guest_name" name="guest_name" placeholder="Enter your name" required>

        <label for="guest_email">Email:</label>
        <input type="email" id="guest_email" name="guest_email" placeholder="Enter your email" required>

        <label for="attendance">Will you attend?</label>
        <select id="attendance" name="attendance" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <button type="submit" class="submit-btn">Submit RSVP</button>
    </form>
</section>

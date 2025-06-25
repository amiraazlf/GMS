<?php
require 'koneksi.php'; 

$events_sql = "SELECT id, event_name FROM events ORDER BY event_date DESC";
$events_result = $conn->query($events_sql);

$selected_event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$rsvp_result = null;

if ($selected_event_id > 0) {
    $rsvp_sql = "SELECT guest_name, guest_email, attendance FROM rsvp WHERE event_id = ?";
    $stmt = $conn->prepare($rsvp_sql);
    $stmt->bind_param("i", $selected_event_id);
    $stmt->execute();
    $rsvp_result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Presence</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
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
        .header {
            border-bottom: 2px solid var(--dark);
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        }
        .header h1 {
            font-size: 28px;
        margin: 0;
        color: black;
        font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        td {
            background-color: #f9f9f9;
        }
        .event-select {
            margin-bottom: 20px;
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
            <a href="guest-presence.php" class="active">Track Attendance</a>
            <a href="history.php">Event History</a>
        </div>
    </div>

    <div id="guest-presence" class="container">
        <div class="header">
            <h1>Guest Presence</h1>
        </div>

        <form action="guest-presence.php" method="GET" class="event-select">
            <label for="event_id">Select Event:</label>
            <select id="event_id" name="event_id" onchange="this.form.submit()">
                <option value="">-- Select an Event --</option>
                <?php if ($events_result->num_rows > 0): ?>
                    <?php while ($event = $events_result->fetch_assoc()): ?>
                        <option value="<?= $event['id'] ?>" <?= $selected_event_id == $event['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($event['event_name']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </form>

        <?php if ($selected_event_id > 0 && $rsvp_result && $rsvp_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Guest Name</th>
                        <th>Email</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $rsvp_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['guest_name']) ?></td>
                            <td><?= htmlspecialchars($row['guest_email']) ?></td>
                            <td><?= htmlspecialchars($row['attendance']) === 'yes' ? 'Attending' : 'Not Attending' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No RSVP responses for this event yet, or no event selected.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = " WHERE events.event_name LIKE '%$search%' OR events.event_location LIKE '%$search%'";
}

$limit = 10;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query_rsvp = "
    SELECT 
        events.event_name,
        events.event_location,
        COUNT(rsvp.id) AS total_guests,
        SUM(CASE WHEN rsvp.attendance = 'yes' THEN 1 ELSE 0 END) AS guests_attending,
        SUM(CASE WHEN rsvp.attendance = 'no' THEN 1 ELSE 0 END) AS guests_not_attending,
        rsvp.id AS rsvp_id
    FROM 
        events
    LEFT JOIN 
        rsvp 
    ON 
        events.id = rsvp.event_id
    $search_query
    GROUP BY 
        events.id
    LIMIT $limit OFFSET $offset
";
$result_rsvp = mysqli_query($conn, $query_rsvp);
if (!$result_rsvp) {
    die("Query Error (RSVP): " . mysqli_error($conn));
}

$query_count = "
    SELECT COUNT(DISTINCT events.id) AS total_count
    FROM events
    LEFT JOIN rsvp ON events.id = rsvp.event_id
    $search_query
";
$result_count = mysqli_query($conn, $query_count);
$total_rows = mysqli_fetch_assoc($result_count)['total_count'];

if (isset($_GET['delete_rsvp'])) {
    $rsvp_id = intval($_GET['delete_rsvp']);
    $query_delete_rsvp = "DELETE FROM rsvp WHERE id = $rsvp_id";
    mysqli_query($conn, $query_delete_rsvp) or die('Query Error: ' . mysqli_error($conn));
    header("Location: rsvp-admin.php");
    exit();
}

if (isset($_POST['submit'])) {
    $event_id = intval($_POST['event_id']);
    $attendance = mysqli_real_escape_string($conn, $_POST['attendance']);

    if (empty($event_id) || empty($attendance)) {
        $error_message = "All fields are required.";
    } else {
$query_insert = "INSERT INTO rsvp (event_id, attendance) 
                 VALUES ('$event_id', '$attendance')";

if (mysqli_query($conn, $query_insert)) {
    echo "<script>
    alert('RSVP added successfully!');
    window.location.href = 'rsvp-admin.php';
    </script>";
} else {
    echo "<script>
    alert('Error adding RSVP: " . mysqli_error($conn) . "');
    window.location.href = 'rsvp-admin.php';
    </script>";
}

    }
}

$query_events = "SELECT id, event_name FROM events";
$result_events = mysqli_query($conn, $query_events);
if (!$result_events) {
    die("Query Error (Events for Dropdown): " . mysqli_error($conn));
}

if (isset($_POST['submit_edit'])) {
    $rsvp_id = intval($_POST['rsvp_id']);
    $event_id = intval($_POST['event_id']);
    $attendance = mysqli_real_escape_string($conn, $_POST['attendance']);

    if (empty($event_id) || empty($attendance)) {
        $error_message = "All fields are required.";
    } else {
        $query_update = "UPDATE rsvp SET 
                        event_id = '$event_id',
                        attendance = '$attendance'
                        WHERE id = $rsvp_id";
                        
        if (mysqli_query($conn, $query_update)) {
            echo "<script>
                alert('RSVP updated successfully!');
                window.location.href = 'rsvp-admin.php';
            </script>";
        } else {
            echo "<script>
                alert('Error updating RSVP: " . mysqli_error($conn) . "');
                window.location.href = 'rsvp-admin.php';
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP Data</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

:root {
    --dark: #243642; 
    --sage: #387478; 
    --green: #629584; 
    --light: #e2f1e7; 
    --highlight: #89a894;
    --error: #e74c3c; 
    --success: #2ecc71;
}



body {
        font-family: 'Arial', sans-serif;
        background-color: var(--light);
        margin: 0;
        padding: 0;
        color: var(--dark);
    margin-left: 70px;
    }

        .navbar-side {
            position: fixed;
            top: 0;
            left: 0;
            width: 70px;
            height: 100%;
            background-color: var(--dark);
            color: white;
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .navbar-side:hover {
            width: 250px;
        }

        .navbar-side a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
            margin: 5px 10px;
            white-space: nowrap;
            overflow: hidden;
        }

        .navbar-side a span {
            margin-left: 10px;
            opacity: 0; 
            transition: opacity 0.3s ease;
        }

        .navbar-side:hover a span {
            opacity: 1; 
        }

        .navbar-side a:hover {
            background-color: var(--light);
            color: black;
        }

        .navbar-side a.active {
            background-color: var(--sage);
        }

        .navbar-side i {
            font-size: 20px;
        }

        
        .navbar-side a.logout {
    margin-top: auto;
    margin-bottom: 30px;
    text-align: center;
    padding: 10px 15px;
    border-radius: 5px;
}


.navbar-side a.logout i {
    font-size: 24px;
}

.navbar-side a.logout span {
    margin-left: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
}

.navbar-side:hover a.logout span {
    opacity: 1;
}

.navbar-side a.logout:hover {
    background-color: var(--light);
    color: black;
}

        /* Main content */
        .container {
            margin: 20px auto;
        padding: 20px;
        margin-top: -20px;
        max-width: 1200px;
        background-color: var(--sage);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: black;
        text-align: center;
        padding-top: 3px;
        padding-bottom: 15px;
        }

        h2 {
        color: white;
        text-align: left;
        margin-top: 4px;
    }

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: var(--light);
    border: 2px solid black;
}

table td, table th {
    border: 1px solid black; 
    padding: 4px; 
    text-align: left;
    line-height: 1.1;
}


/* Styling Baris Header */
table thead tr {
    background-color: var(--green);
    color: white; 
    font-weight: bold;
    text-align: center;
}

table thead th {
    text-align: center;
    vertical-align: middle; 
    padding: 10px;
    background-color: var(--green); 
    color: white; 
    font-weight: bold;
}

table tbody td:last-child {
    text-align: center;
    vertical-align: middle; 
}

table tbody td:last-child button {
    margin: 0 5px; 
}

    .action-buttons a {
        display: inline-block;
    padding: 6px 12px;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s
    }

    .action-buttons .button {
        background-color: var(--sage);
        color: white;
        height: 24px;       
        margin-top: 5px;

    }

    .action-buttons .button:hover {
        background-color: var(--green);
    }

    .action-buttons .button-delete {
        background-color: #dc3545;
    border: 1px solid #dc3545;
    color: white;
    height: 11px;
    line-height: 1; 
    vertical-align: middle; 
    margin-left: 3px; 
    margin-bottom: 4px;
    }

    .action-buttons .button-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

        .form-container {
            margin: 20px auto;
        padding: 20px;
        max-width: 1200px;
        background-color: var(--sage);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: white;
        text-align: left;
        margin-top: -5px;
        }

        .form-container input, .form-container select {
            display: block;
    width: 100%; 
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid var(--green);
    border-radius: 5px;
    background-color: #fff;
    font-size: 14px;
    transition: border-color 0.3s ease-in-out;
        }

        .form-container input[type="submit"] {
            width: 30%;
    height: 30px;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block; 
    margin: 0 auto;
    border-radius: 5px;
    padding-top: 7px;
        }

        .form-container input[type="submit"]:hover {
            background-color: var(--light);
            color: black;
            padding-top: 7px;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .success {
            color: #2ecc71;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .search-bar {
    display: flex; 
    align-items: center; 
    gap: 10px; 
    justify-content: right;
    margin-top: -51px;
    
}

.search-bar input[type="text"],
.search-bar input[type="submit"] {
    padding: 5px 10px;
    margin-right: 10px;
    border: 1px solid var(--dark);
    border-radius: 5px;
    font-size: 12px;
    width: 200px; 
    height: 35px; 
    box-sizing: border-box; 
    line-height: normal; 
}

.search-bar input[type="submit"] {
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.pagination a {
    padding: 5px 10px;
    background-color: var(--light);
    color: black;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: var(--green);
    color: white;
}

.pagination a.active {
    background-color: var(--green);
    color: white; 
    font-weight: bold; 
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: var(--light);
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.modal-content h2 {
    text-align: center;
    margin-bottom: 20px;
    color: black;
}

.modal-content select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid var(--green);
    border-radius: 5px;
}

.modal-content input[type="submit"] {
    width: 30%;
    height: 30px;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    margin: 0 auto;
    display: block;
    transition: background-color 0.3s ease;
}

.modal-content input[type="submit"]:hover {
    background-color: var(--sage);
}

.close {
    position: absolute;
    right: 15px;
    top: 5px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: var(--sage);
}
    </style>
</head>
<body>
    <div class="navbar-side" id="navbarSide">
        <a href="admin_dashboard.php">
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
        <a href="rsvp-admin.php" class="active">
            <i class="fas fa-user-check"></i>
            <span>RSVP</span>
        </a>
        <a href="changeprofile_admin.php">
            <i class="fas fa-user-cog"></i>
            <span>Change Profile</span>
        </a>
        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <h1>Manage RSVP</h1>

    <div class="container">
    <h2>RSVP List</h2>
        <?php if (isset($success_message)): ?>
        <div class="message success"><?= $success_message ?></div>
        <?php elseif (isset($error_message)): ?>
        <div class="message error"><?= $error_message ?></div>
        <?php endif; ?>
        <div class="search-bar">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search event name or location..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <input type="submit" value="Search">
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Location</th>
                    <th>Total Guests</th>
                    <th>Attending</th>
                    <th>Not Attending</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rsvp = mysqli_fetch_assoc($result_rsvp)): ?>
                <tr>
                    <td><?= htmlspecialchars($rsvp['event_name']) ?></td>
                    <td><?= htmlspecialchars($rsvp['event_location']) ?></td>
                    <td><?= htmlspecialchars($rsvp['total_guests']) ?></td>
                    <td><?= htmlspecialchars($rsvp['guests_attending']) ?></td>
                    <td><?= htmlspecialchars($rsvp['guests_not_attending']) ?></td>
                    <td class="action-buttons">
    <button type="button" class="button" onclick="showEditModal(<?= $rsvp['rsvp_id'] ?>)">
        Edit
    </button>
    <a href="?delete_rsvp=<?= urlencode($rsvp['rsvp_id']) ?>" class="button button-delete" 
       onclick="return confirm('Are you sure you want to delete this RSVP entry?')">Delete</a>
</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $page ? 'class="active"' : '';
                echo "<a href='?page=$i&search=" . htmlspecialchars($_GET['search'] ?? '') . "' $active>$i</a>";
            }
            ?>
        </div>
        </div>
                <div class="form-container">
            <h2>Add New RSVP</h2>
            <form action="" method="POST">
                <select name="event_id" required>
                    <option value="">Select Event</option>
                    <?php while ($event = mysqli_fetch_assoc($result_events)): ?>
                        <option value="<?= htmlspecialchars($event['id']) ?>"><?= htmlspecialchars($event['event_name']) ?></option>
                    <?php endwhile; ?>
                </select>
                <select name="attendance" required>
                    <option value="">Select Attendance</option>
                    <option value="yes">Attending</option>
                    <option value="no">Not Attending</option>
                </select>
                <input type="submit" name="submit" value="Add RSVP">
            </form>
        </div>
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit RSVP</h2>
        <form id="editForm" method="POST" action="rsvp-admin.php">
            <input type="hidden" name="rsvp_id" id="rsvp_id">
            <select name="event_id" id="event_id" required>
                <option value="">Select Event</option>
                <?php
                $events_query = "SELECT id, event_name FROM events";
                $events_result = mysqli_query($conn, $events_query);
                while ($event = mysqli_fetch_assoc($events_result)): ?>
                    <option value="<?= htmlspecialchars($event['id']) ?>"><?= htmlspecialchars($event['event_name']) ?></option>
                <?php endwhile; ?>
            </select>
            <select name="attendance" id="attendance" required>
                <option value="">Select Attendance</option>
                <option value="yes">Attending</option>
                <option value="no">Not Attending</option>
            </select>
            <input type="submit" name="submit_edit" value="Update RSVP">
        </form>
    </div>
</div>

<script>
function showEditModal(rsvpId) {
    document.getElementById("editModal").style.display = "block";
    document.getElementById("rsvp_id").value = rsvpId;
    
    // Mengambil data RSVP yang ada
    fetch('get_rsvp_data.php?rsvp_id=' + rsvpId)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById("event_id").value = data.event_id;
                document.getElementById("attendance").value = data.attendance;
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data');
        });
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById("editModal")) {
        closeModal();
    }
}
</script>
</body>
</html>
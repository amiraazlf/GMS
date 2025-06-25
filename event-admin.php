<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

if (isset($_POST['submit'])) {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $number_of_chairs = mysqli_real_escape_string($conn, $_POST['number_of_chairs']);

    if (empty($event_name) || empty($event_description) || empty($event_date) || empty($event_location) || empty($number_of_chairs)) {
        $error_message = "All fields are required.";
    } else {
        $query_insert = "INSERT INTO events (event_name, event_description, event_date, event_location, number_of_chairs, user_id) 
                         VALUES ('$event_name', '$event_description', '$event_date', '$event_location', '$number_of_chairs', {$_SESSION['user_id']})";
       
       
if (mysqli_query($conn, $query_insert)) {
    echo "<script>
    alert('Event added successfully!');
    window.location.href = 'events-admin.php';
    </script>";
} else {
    $error_message = mysqli_real_escape_string($conn, mysqli_error($conn)); 
    echo "<script>
    alert('Error adding event: $error_message');
    window.location.href = 'events-admin.php';
    </script>";
}
        
    }
}

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query_total = "SELECT COUNT(*) AS total FROM events WHERE event_name LIKE '%$search%'";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_rows = $row_total['total'];

$total_pages = ceil($total_rows / $limit);

$query_events = "
    SELECT 
        events.id AS event_id,
        user.username AS created_by,
        events.event_name,
        events.event_description,
        events.event_date,
        events.event_location,
        events.number_of_chairs,
        events.created_at
    FROM 
        events
    JOIN 
        user 
    ON 
        events.user_id = user.id
    WHERE 
        events.event_name LIKE '%$search%'
    LIMIT $limit OFFSET $offset
";
$result_events = mysqli_query($conn, $query_events);
if (!$result_events) {
    die("Query Error (Events): " . mysqli_error($conn));
}

if (isset($_GET['delete_event'])) {
    $event_id = intval($_GET['delete_event']);
    $query_delete_event = "DELETE FROM events WHERE id = $event_id";
    mysqli_query($conn, $query_delete_event) or die('Query Error: ' . mysqli_error($conn));
    header("Location: event-admin.php");
    exit();
}

if (isset($_POST['submit_edit'])) {
    $event_id = $_POST['event_id'];
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $number_of_chairs = mysqli_real_escape_string($conn, $_POST['number_of_chairs']);

    if (empty($event_name) || empty($event_description) || empty($event_date) || empty($event_location) || empty($number_of_chairs)) {
        $error_message = "All fields are required.";
    } else {
        $query_update = "UPDATE events SET 
                        event_name = '$event_name',
                        event_description = '$event_description',
                        event_date = '$event_date',
                        event_location = '$event_location',
                        number_of_chairs = '$number_of_chairs'
                        WHERE id = $event_id";
                  if (mysqli_query($conn, $query_update)) {
                    echo "<script>
                    alert('Event updated successfully!');
                    window.location.href = 'event-admin.php';
                    </script>";
                  } else {
                    echo "<script>
                    alert('Error updating event: " . mysqli_error($conn) . "');
                    window.location.href = 'event-admin.php';
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
    <title>Events Data</title>
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

        .container {
    margin-top: 8px; 
    transform: translateY(-20px); 
}

    body {
        font-family: 'Arial', sans-serif;
        background-color: var(--light);
        margin: 0;
        padding: 0;
        color: var(--dark);
    margin-left: 70px; 
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
        margin-top: -5px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-container h2 {
    margin: 0;
    font-size: 24px;
    color: white;
}

.search-box {
    display: flex; 
    align-items: center; 
    gap: 10px; 
}

.search-box input[type="text"],
.search-box input[type="submit"] {
    padding: 5px 10px; 
    border: 1px solid var(--dark);
    border-radius: 5px;
    font-size: 12px;
    width: 200px; 
    height: 35px; 
    box-sizing: border-box; 
    line-height: normal; 
}

.search-box input[type="submit"] {
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}



    .container {
        margin: 20px auto;
        padding: 20px;
        max-width: 1200px;
        background-color: var(--sage);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .form-container input, 
    .form-container textarea {
        width: 98%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid var(--green);
        border-radius: 5px;
        background-color: #fff;
        font-size: 14px;
        transition: border-color 0.3s ease-in-out;
    }

    .form-container input:focus, 
    .form-container textarea:focus {
        outline: none;
        border-color: var(--highlight);
    }

    .form-container input[type="submit"] {
    width: 50%;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block; 
    margin: 0 auto; 
}


    .form-container input[type="submit"]:hover {
        background-color: var(--light);
    }


    .search-box {
        display: flex;
        justify-content: right;
    }

    .search-box input {
        padding: 10px;
        border: 1px solid var(--dark);
        border-radius: 5px;
        margin-right: 10px;
        font-size: 14px;
        width: 300px;
    }

    .search-box input[type="submit"] {
        padding: 10px 20px;
        background-color: var(--dark);
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-box input[type="submit"]:hover {
        background-color: var(--light);
        color: black;
    }


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
    padding: 10px; 
    text-align: left; 
}

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
    padding: 10x 15px;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s
    }

    .action-buttons .button {
        background-color: var(--sage);
        color: white;
        height: 18px;      
        padding: 5px 6px; 
    line-height: 6px;  
    margin-right: 3px; 
    }

    .action-buttons .button:hover {
        background-color: var(--highlight);
    }

    .action-buttons .button-delete {
        background-color: #dc3545;
    border: 1px solid #dc3545;
    color: white;
    height: 17px;
    width: 50px;
    line-height: 1.5; 
    vertical-align: middle; 
    margin-left: 3px;  
    font-size: 12px;
    }

    .action-buttons .button-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

.message.success {
    background-color: var(--success);
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 10px;
}

.message.error {
    background-color: var(--error);
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 10px;
}

.form-container input[type="submit"]{
    width: 30%;
    height: 30px;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block; 
    border-radius: 5px;
    
  line-height: 10px; 
}
.form-container input[type="submit"]:hover {
    background-color: var(--light);
    color: var(--dark);
    width: 30%;
    
    height: 30px;
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
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}


.modal-content {
    background-color: var(--light);
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 1000px;
    position: absolute; 
    top: 33%;
    left: 52%;
    transform: translateX(-50%) translateY(-30%); 
}

.modal-content h2 {
        text-align: center;
        margin-bottom: 20px;
        color: black;
    }

.modal-content label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .modal-content input, .modal-content textarea {
        margin-bottom: 15px;
        padding: 8px;
        font-size: 14px;
        width: 98%;
    }

    .modal-content input[type="submit"] {
        width: 30%;
    height: 30px;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block;
    border-radius: 5px;
    line-height: 10px; 
    margin: 0 auto; 
    }

    .modal-content input[type="submit"]:hover {
        background-color: var(--sage);
    color: white;
    width: 30%;
    height: 30px;
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
        <a href="event-admin.php" class="active">
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
        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>


    <h1>Manage Events</h1>

    <div class="container">
    <div class="header-container">
        <h2>Event List</h2>
        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="Search event name..." value="<?= htmlspecialchars($search) ?>" />
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Created By</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = mysqli_fetch_assoc($result_events)): ?>
            <tr>
                <td><?= htmlspecialchars($event['event_id']) ?></td>
                <td><?= htmlspecialchars($event['created_by']) ?></td>
                <td><?= htmlspecialchars($event['event_name']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?></td>
                <td><?= htmlspecialchars($event['event_location']) ?></td>
                <td class="action-buttons">
                        <button type="button" class="button" onclick="showEditModal(<?php echo $event['event_id']; ?>, '<?php echo $event['event_name']; ?>', '<?php echo $event['event_description']; ?>', '<?php echo $event['event_date']; ?>', '<?php echo $event['event_location']; ?>', <?php echo $event['number_of_chairs']; ?>)">
                            Edit
                        </button>
                        <a href="?delete_event=<?php echo $event['event_id']; ?>" class="button-delete">Delete</a>
                    </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

</div>

    <?php if (isset($success_message)): ?>
    <div class="message success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)): ?>
    <div class="message error"><?= $error_message ?></div>
    <?php endif; ?>
    <div class="container">
    <h2>Add New Event</h2>
    <div class="form-container">
        <form action="save-event-admin.php" method="POST">
            <input type="text" name="event_name" placeholder="Event Name" required>
            <textarea name="event_description" rows="5" placeholder="Event Description" required></textarea>
            <input type="date" name="event_date" required>
            <input type="text" name="event_location" placeholder="Event Location" required>
            <input type="number" name="number_of_chairs" placeholder="Number of Chairs" required>
            <input type="text" name="seating_arrangement" placeholder="Seating Arrangement" required>
            <input type="submit" name="submit" value="Add Event">
        </form>
    </div>
</div>
</div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Event</h2>
            <form id="editForm" method="POST" action="event-admin.php">
                <input type="hidden" name="event_id" id="event_id">
                <label for="event_name">Event Name:</label>
                <input type="text" name="event_name" id="event_name" required>
                <label for="event_description">Event Description:</label>
                <textarea name="event_description" id="event_description" required></textarea>
                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" id="event_date" required>
                <label for="event_location">Event Location:</label>
                <input type="text" name="event_location" id="event_location" required>
                <label for="number_of_chairs">Number of Chairs:</label>
                <input type="number" name="number_of_chairs" id="number_of_chairs" required>
                <input type="submit" name="submit_edit" value="Update Event">
            </form>
        </div>
    </div>
    <script>
        function showEditModal(event_id, event_name, event_description, event_date, event_location, number_of_chairs) {
            document.getElementById("editModal").style.display = "block";
            document.getElementById("event_id").value = event_id;
            document.getElementById("event_name").value = event_name;
            document.getElementById("event_description").value = event_description;
            document.getElementById("event_date").value = event_date;
            document.getElementById("event_location").value = event_location;
            document.getElementById("number_of_chairs").value = number_of_chairs;
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
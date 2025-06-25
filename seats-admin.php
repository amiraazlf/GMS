<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

if (isset($_POST['submit'])) {
    $event_id = intval($_POST['event_id']);
    $seat_number = mysqli_real_escape_string($conn, $_POST['seat_number']);
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    if (empty($seat_number) || empty($event_id)) {
        $error_message = "All fields are required.";
    } else {
$query_insert = "INSERT INTO seats (event_id, seat_number, is_available) 
                 VALUES ('$event_id', '$seat_number', '$is_available')";

if (mysqli_query($conn, $query_insert)) {
    echo "<script>
    alert('Seat added successfully!');
    window.location.href = 'seats-admin.php';
    </script>";
} else {
    echo "<script>
    alert('Error adding seat: " . mysqli_error($conn) . "');
    window.location.href = 'seats-admin.php';
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

$query_total = "SELECT COUNT(*) AS total FROM seats 
                JOIN events ON seats.event_id = events.id 
                WHERE seats.seat_number LIKE '%$search%'";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_rows = $row_total['total'];

$total_pages = ceil($total_rows / $limit);

$query_seats = "
    SELECT 
        seats.id AS seat_id,
        events.event_name,
        events.event_location,
        seats.seat_number,
        CASE WHEN seats.is_available = 1 THEN 'Available' ELSE 'Unavailable' END AS seat_status
    FROM 
        seats
    JOIN 
        events 
    ON 
        seats.event_id = events.id
    WHERE 
        seats.seat_number LIKE '%$search%'
    LIMIT $limit OFFSET $offset
";
$result_seats = mysqli_query($conn, $query_seats);
if (!$result_seats) {
    die("Query Error (Seats): " . mysqli_error($conn));
}

if (isset($_GET['delete_seat'])) {
    $seat_id = intval($_GET['delete_seat']);
    $query_delete_seat = "DELETE FROM seats WHERE id = $seat_id";
    mysqli_query($conn, $query_delete_seat) or die('Query Error: ' . mysqli_error($conn));
    header("Location: seats-admin.php");
    exit();
}

$query_events = "SELECT id, event_name FROM events";
$result_events = mysqli_query($conn, $query_events);
if (!$result_events) {
    die("Query Error (Events for Dropdown): " . mysqli_error($conn));
}

if (isset($_POST['submit_edit'])) {
    $seat_id = intval($_POST['seat_id']);
    $event_id = intval($_POST['event_id']);
    $seat_number = mysqli_real_escape_string($conn, $_POST['seat_number']);
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    if (empty($seat_number) || empty($event_id)) {
        $error_message = "All fields are required.";
    } else {
        $query_update = "UPDATE seats SET 
                        event_id = '$event_id',
                        seat_number = '$seat_number',
                        is_available = '$is_available'
                        WHERE id = $seat_id";

if (mysqli_query($conn, $query_update)) {
    echo "<script>alert('Seat updated successfully!');</script>";
} else {
    echo "<script>alert('Error updating seat: " . mysqli_error($conn) . "');</script>";
}

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seats Data</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
 :root {
    --dark: #243642; 
    --sage: #387478; 
    --green: #629584;
    --light: #e2f1e7;
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
        padding-top: 24px;
        margin-bottom: -5px;
    }

    h2 {
        color: white;
        text-align: left;
        margin-top: -5px;
    }

    .container {
    margin-top: 8px; 
    transform: translateY(-20px); 
}

table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: var(--light);
    border: 2px solid black;
    margin-top: 20px; 
}

table td, table th {
    border: 1px solid black; 
    padding: 10px; 
    text-align: left;
}

table td:last-child, table th:last-child {
    border: 0.0001px solid #666; 
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

.btn {
    display: inline-block;
    padding: 6px 12px;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s
}

.btn-primary {
    background-color: var(--sage);
    color: white;
    text-align: center;
}

.btn-primary:hover {
    background-color: var(--green);
}

.btn-danger {
    background-color: #dc3545;
    border: 1px solid #dc3545;
    color: white;
    height: 12px;
    line-height: 1; 
    vertical-align: middle; 
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-sm {
    font-size: 12px;
    padding: 4px 10px;
    text-align: center;
}

.action-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
}

.action-buttons a {
    margin-right: 10px; 
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

    flex-grow: 1; 
        }

.form-container select {
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

.form-container input[type="text"] {
    display: block;
    width: 98.2%; 
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
}
        .form-container input[type="submit"]:hover {
            background-color: var(--light);
            color: black;
        }

        .available-label {
    color: white;
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

.search-container {
    margin: 20px auto;
        padding: 20px;
        max-width: 1200px;
        background-color: var(--sage);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        justify-content: space-between;  
        align-items: center; 
}

    .search-box {
        display: flex;
        justify-content: right;
        justify-content: flex-end;  
    }

.search-box input {
    padding: 5px; /* Reduced padding */
    border: 1px solid var(--dark);
    border-radius: 5px;
    margin-right: 10px;
    font-size: 12px;
    width: 188px; 
    height: 23px;
    
}

.search-box input[type="submit"] {
    padding: 5px 15px;
    background-color: var(--dark);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 12px;
    height: 35px;
    width: 200px;
}

.search-box input[type="submit"]:hover {
    background-color: var(--light);
    color: black;
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

.search-container h2 {
    margin: 0;
    margin-top: 3px;
    margin-bottom: -30px;
    font-size: 24px;
    color: white;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
    transition: all 0.3s ease;
}

.modal-content {
    background-color: var(--light);
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    position: absolute;
    top: 33%;
    left: 52%;
    transform: translateX(-50%) translateY(-30%);
    transition: all 0.3s ease;
}

.modal-content h2 {
    text-align: center;
    margin-bottom: 20px;
    color: black;
}

.modal-content select {
    display: block;
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid var(--green);
    border-radius: 5px;
}


.modal-content input[type="text"] {
    display: block;
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid var(--green);
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

.modal-content .available-label {
    display: block;
    margin-bottom: 15px;
    color: black;
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
        <a href="seats-admin.php" class="active">
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

    <div class="container">
        <h1>Manage Seats</h1>
        <?php if (isset($success_message)): ?>
        <div class="message success"><?= $success_message ?></div>
        <?php elseif (isset($error_message)): ?>
        <div class="message error"><?= $error_message ?></div>
        <?php endif; ?>

<div class="search-container">
<h2>Seat List</h2>
    <div class="search-box">
        <form action="" method="GET">
            <input type="text" name="search" value="<?= $search ?>" placeholder="  Search by seat number...">
            <input type="submit" value="Search">
        </form>
    </div>

        <table>
            <thead>
                <tr>
                    <th>Seat ID</th>
                    <th>Event Name</th>
                    <th>Location</th>
                    <th>Seat Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($seat = mysqli_fetch_assoc($result_seats)): ?>
                <tr>
                    <td><?= htmlspecialchars($seat['seat_id']) ?></td>
                    <td><?= htmlspecialchars($seat['event_name']) ?></td>
                    <td><?= htmlspecialchars($seat['event_location']) ?></td>
                    <td><?= htmlspecialchars($seat['seat_number']) ?></td>
                    <td><?= htmlspecialchars($seat['seat_status']) ?></td>
                    <td style="display:none;" class="event-name"><?= htmlspecialchars($seat['event_name']) ?></td>
                    <td class="action-buttons">
                    <a href="#" onclick="showEditModal(<?= $seat['seat_id'] ?>, this)" class="btn btn-primary btn-sm">Edit</a>
    <a href="?delete_seat=<?= urlencode($seat['seat_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this seat?')">Delete</a>
</td>


                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=1&search=<?= urlencode($search) ?>">First</a>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Prev</a>
    <?php endif; ?>

    <?php
        // Calculate the start and end page numbers to display
        $start_page = max(1, $page - 5);  
        $end_page = min($total_pages, $page + 4);  
        for ($i = $start_page; $i <= $end_page; $i++):
    ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
        <a href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>">Last</a>
    <?php endif; ?>
</div>

        </div>
                <div class="form-container">
    <h2>Add New Seat</h2>
    <form action="" method="POST">
        <select name="event_id" required>
            <option value="">Select Event</option>
            <?php while ($event = mysqli_fetch_assoc($result_events)): ?>
                <option value="<?= htmlspecialchars($event['id']) ?>"><?= htmlspecialchars($event['event_name']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="seat_number" placeholder="Seat Number" required>
        <label class="available-label">
            <input type="checkbox" name="is_available"> Available
        </label>
        <input type="submit" name="submit" value="Add Seat">
    </form>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Seat</h2>
        <form id="editForm" method="POST" action="seats-admin.php">
            <input type="hidden" name="seat_id" id="edit_seat_id">
            <select name="event_id" id="edit_event_id" required>
                <option value="">Select Event</option>
                <?php 
                mysqli_data_seek($result_events, 0); // Reset pointer hasil query events
                while ($event = mysqli_fetch_assoc($result_events)): 
                ?>
                    <option value="<?= htmlspecialchars($event['id']) ?>">
                        <?= htmlspecialchars($event['event_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="seat_number" id="edit_seat_number" placeholder="Seat Number" required>
            <label class="available-label">
                <input type="checkbox" name="is_available" id="edit_is_available"> Available
            </label>
            <input type="submit" name="submit_edit" value="Update Seat">
        </form>
    </div>
</div>

<script>

function showEditModal(seatId, button) {
    var modal = document.getElementById("editModal");
    var row = button.closest('tr');
    var cells = row.getElementsByTagName('td');
    document.getElementById("edit_seat_id").value = seatId;
    document.getElementById("edit_seat_number").value = cells[3].textContent;
    document.getElementById("edit_is_available").checked = cells[4].textContent.trim() === 'Available';

    var eventDropdown = document.getElementById("edit_event_id");
    var eventName = cells[1].textContent; 

    for(var i = 0; i < eventDropdown.options.length; i++) {
        if(eventDropdown.options[i].text === eventName) {
            eventDropdown.selectedIndex = i;
            break;
        }
    }

    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("editModal");
    var form = document.getElementById("editForm");
    modal.style.display = "none";
    form.reset();
}

window.onclick = function(event) {
    var modal = document.getElementById("editModal");
    var form = document.getElementById("editForm");
    if (event.target == modal) {
        modal.style.display = "none";
        form.reset();
    }
}

</script>
</body>
</html>

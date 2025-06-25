<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "Access Denied: Only admins can access this page.";
    exit();
}

$query_events = "
    SELECT 
        events.id AS event_id,
        user.username AS created_by,
        events.event_name,
        events.event_description,
        events.event_date,
        events.event_location,
        events.number_of_chairs,
        events.seating_arrangement,
        events.created_at
    FROM 
        events
    JOIN 
        user 
    ON 
        events.user_id = user.id
";
$result_events = mysqli_query($conn, $query_events);
if (!$result_events) {
    die("Query Error (Events): " . mysqli_error($conn));
}

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
";
$result_seats = mysqli_query($conn, $query_seats);
if (!$result_seats) {
    die("Query Error (Seats): " . mysqli_error($conn));
}

$event_locations = [];
$chairs_per_location = [];
while ($event = mysqli_fetch_assoc($result_events)) {
    $location = $event['event_location'];
    $chairs = $event['number_of_chairs'];

    if (isset($event_locations[$location])) {
        $event_locations[$location]++;
        $chairs_per_location[$location] += $chairs;
    } else {
        $event_locations[$location] = 1;
        $chairs_per_location[$location] = $chairs;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background-color: var(--light);
            min-height: 50vh;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
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

        .navbar-side a.logout span {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .navbar-side:hover a.logout span {
            opacity: 1;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin-left: 80px;
        }

        .chart-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .chart-item {
            background-color: var(--sage);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .chart-item canvas {
            max-height: 500px;
            max-width: 200%;
        }

        .chart-item h2 {
            color: white;
            margin-bottom: 10px;
        }

        canvas {
            margin: auto;
            max-width: 100%;
            height: 200px;
        }

        h1 {
            color: var(---dark);
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .navbar-side {
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-around;
                padding: 10px 0;
            }

            .navbar-side a span {
                display: none;
            }

            .container {
                margin-left: 0;
                padding: 10px;
            }

            .chart-item {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .chart-item {
                padding: 15px;
            }

            canvas {
                height: 150px;
            }
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
        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <div class="container">
        <h1>Admin Dashboard - Analytics</h1>
        <div class="chart-container">
            <div class="chart-item">
                <h2>Events per Location</h2>
                <canvas id="eventChart"></canvas>
            </div>
            <div class="chart-item">
                <h2>Chairs per Event</h2>
                <canvas id="chairsChart"></canvas>
            </div>
            <div class="chart-item">
                <h2>Seats per Event</h2>
                <canvas id="seatAvailabilityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const locations = <?= json_encode(array_keys($event_locations)) ?>;
        const eventsPerLocation = <?= json_encode(array_values($event_locations)) ?>;
        const chairsPerLocation = <?= json_encode(array_values($chairs_per_location)) ?>;
        const ctx1 = document.getElementById('eventChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: locations,
                datasets: [{
                    label: 'Number of Events',
                    data: eventsPerLocation,
                    backgroundColor: locations.map((_, i) => `rgba(${75 + i * 10}, ${192 - i * 5}, ${192 - i * 10}, 0.8)`),
                    borderColor: locations.map((_, i) => `rgba(${75 + i * 10}, ${192 - i * 5}, ${192 - i * 10}, 1)`),
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutBounce',
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white',
                            font: {
                                size: 12,
                            },
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white',
                            font: {
                                size: 12,
                            },
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        },
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14,
                                family: 'Arial',
                            },
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                    },
                },
            }
        });
        const ctx2 = document.getElementById('chairsChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: locations,
                datasets: [{
                    label: 'Number of Chairs',
                    data: chairsPerLocation,
                    backgroundColor: locations.map((_, i) => `rgba(${75 + i * 10}, ${192 - i * 5}, ${192 - i * 10}, 0.8)`),
                    borderColor: locations.map((_, i) => `rgba(${75 + i * 10}, ${192 - i * 5}, ${192 - i * 10}, 1)`),
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutBounce',
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white',
                            font: {
                                size: 12,
                            },
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white',
                            font: {
                                size: 12,
                            },
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)',
                        },
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14,
                                family: 'Arial',
                            },
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                    },
                },
            }
        });
    </script>
</body>
</html>
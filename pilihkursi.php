<?php
require 'koneksi.php';

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if ($event_id <= 0) {
    echo "Error: Event ID tidak valid.";
    exit();
}

$event_sql = "SELECT number_of_chairs FROM events WHERE id = ?";
$event_stmt = $conn->prepare($event_sql);
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_data = $event_result->fetch_assoc();
$number_of_chairs = $event_data['number_of_chairs'];

$seat_sql = "SELECT * FROM seats WHERE event_id = ?";
$seat_stmt = $conn->prepare($seat_sql);
$seat_stmt->bind_param("i", $event_id);
$seat_stmt->execute();
$seat_result = $seat_stmt->get_result();

$seats = [];
while ($row = $seat_result->fetch_assoc()) {
    $seats[$row['seat_number']] = $row['is_available'];
}

for ($i = 1; $i <= $number_of_chairs; $i++) {
    $seat_number = "A" . $i; 
    if (!isset($seats[$seat_number])) {
        $seats[$seat_number] = 1; 
        $insert_sql = "INSERT INTO seats (event_id, seat_number, is_available) VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("is", $event_id, $seat_number);
        $insert_stmt->execute();
    }
}


$seat_stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title>Pemilihan Kursi Event</title>
    <style>
        /* Global Styles */
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

        .screen {
            margin-bottom: 30px;
            background-color: var(--dark);
            color: white;
            padding: 10px;
            font-weight: bold;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-left: 4.5rem;
        }

        .seats {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

.seat {
    width: 40px;
    height: 40px;
    background-color: #e0e0e0;
    border: 2px solid #ddd;
    text-align: center;
    line-height: 40px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.2s;
    font-weight: bold;
}


.seat.selected {
    background-color: var(--dark);
    color: white;
    transform: scale(1.1);
}


.seat.unavailable {
    background-color: #ff5252;
    color: white;
    cursor: not-allowed;
    box-shadow: none;
}

        .legend {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px auto;
            width: 70%;
            max-width: 400px;
        }


        .legend div {
            display: flex;
            align-items: center;
            font-size: 16px;
        }


        .legend div span {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 8px;
            border-radius: 3px;
        }


        .legend .regular span {
            background-color: #e0e0e0;
            border: 1px solid #ccc;
        }


        .legend .unavailable span {
            background-color: #ff5252;
        }

        .book-button {
            background-color: var(--dark);
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-left: 12rem;
        }


        .book-button:hover {
            background-color: var(---light);
            color: black;
        }


        @media (max-width: 600px) {
            .seats {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <i class="fas fa-bars menu-icon"></i>
            <div class="nav-links">
        <a href="gmsaflog.php">Main Dashboard</a>
        <a href="guest.php">Home</a>
        <a href="rsvp.php">RSVP</a>
        <a href="pilihkursi.php"class="active">Select Seat</a>
    </div>
    </div>
 
    <div class="container">
        <div class="screen">
            <h2>STAGE</h2>
        </div>
        <div class="seats">
            <?php foreach ($seats as $seat => $is_available): ?>
                <div class="seat <?= $is_available ? '' : 'unavailable' ?>" data-available="<?= $is_available ? 'true' : 'false' ?>">
                    <?= $seat ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="legend">
            <div class="regular">
                <span></span> Available
            </div>
            <div class="unavailable">
                <span></span> Unavailable
            </div>
        </div>
        <button class="book-button" onclick="bookSeats()">Book Selected Seats</button>
    </div>
    <script>
        const seats = document.querySelectorAll('.seat');
let selectedSeats = [];

seats.forEach(seat => {
    if (seat.dataset.available === 'true') {
        seat.addEventListener('click', () => {
            seat.classList.toggle('selected');
            const seatNumber = seat.textContent;
            if (seat.classList.contains('selected')) {
                selectedSeats.push(seatNumber);
            } else {
                selectedSeats = selectedSeats.filter(num => num !== seatNumber);
            }
        });
    }
});

        function bookSeats() {
          if (selectedSeats.length > 0) {
            const trimmedSeats = selectedSeats.map(seat => seat.trim());
            fetch('book_seats.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ event_id: <?= $event_id ?>, seats: trimmedSeats })
            })
              .then(response => response.json())
              .then(data => {
                console.log(data); 


                if (data.success) {
                  alert('Seats successfully booked!');
                  selectedSeats.forEach(seatNumber => {
                    const seatElements = document.querySelectorAll('.seat[data-available="true"]');
                    seatElements.forEach(seatElement => {
                      if (seatElement.textContent.trim() === seatNumber.trim()) {
                        seatElement.classList.remove('selected');
                        seatElement.classList.add('unavailable');
                        seatElement.dataset.available = 'false';
                      }
                    });
                  });


                  selectedSeats = [];
                } else {
                  alert('Error booking seats: ' + data.message);
                }
              })
              .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while booking seats.');
              });
          } else {
            alert('Please select at least one seat to book.');
          }
        }


    </script>
</body>
</html>
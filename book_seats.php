<?php
require 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);

$event_id = $data['event_id'];
$selectedSeats = $data['seats'];

$response = ['success' => false, 'message' => ''];

if (!empty($selectedSeats) && $event_id > 0) {
    foreach ($selectedSeats as $seat) {
        $update_sql = "UPDATE seats SET is_available = 0 WHERE event_id = ? AND seat_number = ?";
        $update_stmt = $conn->prepare($update_sql);

        if (!$update_stmt) {
            $response['message'] = 'Failed to prepare statement: ' . $conn->error;
            echo json_encode($response);
            exit();
        }

        $update_stmt->bind_param("is", $event_id, $seat);

        if (!$update_stmt->execute()) {
            $response['message'] = 'Failed to update seat: ' . $seat . ' - ' . $update_stmt->error;
            echo json_encode($response);
            exit();
        }

        if ($update_stmt->affected_rows === 0) {
            $response['message'] = 'No seats were updated. Either the seat does not exist or it is already unavailable.';
            echo json_encode($response);
            exit();
        }
    }

    $response['success'] = true;
    $response['message'] = 'Seats successfully booked!';
} else {
    $response['message'] = 'No seats selected or invalid event ID.';
}

echo json_encode($response);

$conn->close();
?>

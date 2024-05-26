<?php
include("connection.php");

if (isset($_GET['chaletId'])) {
    $chaletId = intval($_GET['chaletId']);

    $conn = connectToDB();

    $stmt = $conn->prepare("SELECT booking_date FROM bookings WHERE cid = ? AND status = 'Confirmed'");
    $stmt->bind_param("i", $chaletId);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => 'Booked',
            'start' => $row['booking_date'],
            'allDay' => true
        ];
    }

    $stmt->close();
    closeDBconnection($conn);

    header('Content-Type: application/json');
    echo json_encode($events);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request.']);
}
?>

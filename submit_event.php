<?php
$host = 'localhost';
$db = 'event_bcp_sms3_ems'; 
$user = 'event_topher';  
$pass = 'topher';  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
$event_title = isset($_POST['event_title']) ? trim($_POST['event_title']) : '';

$date_booked = isset($_POST['date_booked']) ? $_POST['date_booked'] : '';
if (!DateTime::createFromFormat('Y-m-d', $date_booked)) {
    die(json_encode(['status' => 'error', 'message' => 'Invalid date format. Expected format: YYYY-MM-DD.']));
}

$time = '';
if (isset($_POST['time'])) {
    $time = $_POST['time'] . ':00'; 
    if (!preg_match('/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $time)) {
        die(json_encode(['status' => 'error', 'message' => 'Invalid time format. Expected format: HH:MM:SS.']));
    }
} else {
    die(json_encode(['status' => 'error', 'message' => 'Time is required.']));
}

$attendees = isset($_POST['attendees']) && is_numeric($_POST['attendees']) ? $_POST['attendees'] : 0;

$status = 'Pending';  

$stmt = $conn->prepare("INSERT INTO bcp_sms3_booking (name, contact, event_title, attendees, date_booked, time, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $contact, $event_title, $attendees, $date_booked, $time, $status);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Event booked successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
exit();
?>

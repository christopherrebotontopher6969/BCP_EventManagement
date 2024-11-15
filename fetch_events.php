<?php

$connection = new mysqli("localhost", "event_topher", "topher", "event_bcp_sms3_ems");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT id, event_title AS title, date_booked AS start 
        FROM bcp_sms3_event_history
        WHERE status = 'approved' AND date_booked >= CURDATE()";
$result = $connection->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);

$connection->close();
?>

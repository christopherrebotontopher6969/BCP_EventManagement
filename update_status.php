<?php
$servername = "localhost"; 
$username = "event_topher"; 
$password = "event_topher"; 
$dbname = "event_bcp_sms3_ems"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST['event_id']);
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bcp_sms3_booking SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $event_id);

    if ($stmt->execute()) {
        if ($new_status == 'Cancelled' || $new_status == 'Approved') {
            $event_sql = "SELECT * FROM bcp_sms3_booking WHERE id = ?";
            $event_stmt = $conn->prepare($event_sql);
            $event_stmt->bind_param("i", $event_id);
            $event_stmt->execute();
            $event_result = $event_stmt->get_result();

            if ($event_result->num_rows > 0) {
                $event_data = $event_result->fetch_assoc();

                echo "<pre>";
                print_r($event_data);
                echo "</pre>";

                if (!empty($event_data['date_booked'])) {
                    $history_stmt = $conn->prepare("INSERT INTO bcp_sms3_event_history (name, contact, event_title, attendees, date_booked, time, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $history_stmt->bind_param("sssisss", $event_data['name'], $event_data['contact'], $event_data['event_title'], $event_data['attendees'], $event_data['date_booked'], $event_data['time'], $new_status);

                    if ($history_stmt->execute()) {
                        $delete_stmt = $conn->prepare("DELETE FROM bcp_sms3_booking WHERE id = ?");
                        $delete_stmt->bind_param("i", $event_id);
                        $delete_stmt->execute();
                        $delete_stmt->close();
                    } else {
                        echo "Error inserting into history: " . $history_stmt->error;
                    }
                    $history_stmt->close();
                } else {
                    echo "Error: Missing or empty event data.";
                }
            } else {
                echo "Error: Event not found.";
            }
            $event_stmt->close();
        }

        header("Location: tables-data.php?status=success");
        exit();
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

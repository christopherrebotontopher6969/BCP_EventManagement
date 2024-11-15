
<?php


$servername = "localhost"; 
$username = "event_topher"; 
$password = "topher"; 
$dbname = "event_bcp_ms3_ems"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$accountId = $_SESSION['accountId']; 

$sql = "SELECT Fname FROM bcp_sms3_useracc WHERE accountId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $accountId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['Fname'];
} else {
    $fullname = "User"; 
}

$stmt->close();
$conn->close();
?>


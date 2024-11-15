<?php
session_start();
if (isset($_SESSION['accountId'])) {
    header("eventdash.php");
    exit();
}

include 'connection.php';

$error = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accountId = filter_input(INPUT_POST, 'accountId', FILTER_SANITIZE_NUMBER_INT);
    $password = $_POST['password'];

    if (!preg_match('/^\d{6}$/', $accountId)) {
        $error = 'Account ID must be exactly 6 digits!';
    } else {

        $stmt = $conn->prepare("SELECT password FROM bcp_sms3_useracc WHERE accountId = ?");
        $stmt->execute([$accountId]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $_SESSION['accountId'] = $accountId;
                header("Location: eventdash.php"); 
                exit();
            } else {
                
                $error = 'Invalid password!';
            }
        } else {
       
            $error = 'Invalid account ID or password!';
        }
    }
}


$conn = null; 
?>

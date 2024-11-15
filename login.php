<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['accountId'])) {
    header("Location: eventdash.php");
    exit();
}

// Include database connection file
include 'connection.php';

$error = ''; 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $accountId = filter_input(INPUT_POST, 'accountId', FILTER_SANITIZE_NUMBER_INT);
    $password = $_POST['password'];

    // Validate account ID format
    if (!preg_match('/^\d{6}$/', $accountId)) {
        $error = 'Account ID must be exactly 6 digits!';
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT password FROM bcp_sms3_useracc WHERE accountId = ?");
        $stmt->execute([$accountId]);
        $user = $stmt->fetch();

        // Check if user exists and verify password
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Store account ID in session
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

// Close the database connection
$conn = null; 
?>

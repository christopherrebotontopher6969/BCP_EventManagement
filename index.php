<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['accountId'])) {
    // Redirect to eventdash.php if already logged in
    header("Location: eventdash.php");
    exit();
}

include 'connection.php';

$error = ''; 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accountId = filter_input(INPUT_POST, 'accountId', FILTER_SANITIZE_NUMBER_INT);
    $password = $_POST['password'];

    // Validate account ID format
    if (!preg_match('/^\d{6}$/', $accountId)) {
        $error = 'Account ID must be exactly 6 digits!';
    } else {
        try {
            // Prepare and execute the SQL query to check if the account exists
            $stmt = $conn->prepare("SELECT password FROM bcp_sms3_useracc WHERE accountId = ?");
            $stmt->execute([$accountId]);
            $user = $stmt->fetch();

            // Check if user exists and the password is correct
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Set session and redirect to eventdash.php
                    $_SESSION['accountId'] = $accountId;
                    header("Location: eventdash.php");
                    exit();
                } else {
                    $error = 'Invalid password!';
                }
            } else {
                $error = 'Invalid account ID or password!';
            }
        } catch (PDOException $e) {
            // Handle DB connection error
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Close database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/img/bcp logo.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Event Management System">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Login - EMS</title> 
</head>
<body>
    <div class="logo">
        <img src="assets/img/bcp logo.png" alt="Logo">
        <p>Event Management System</p>
    </div>

    <div class="login-container">
        <h2>Log Into Your Account</h2>
        
        <!-- Display error message if any -->
        <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <!-- Login Form -->
        <form id="loginForm" action="index.php" method="post">
            <label for="accountId">Account ID</label>
            <input type="text" id="accountId" name="accountId" required aria-label="Account ID">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required aria-label="Password">

            <div class="forgot-password">
                <a href="#" aria-label="Forgot password?">Forgot your password?</a>
            </div>

            <button type="submit">LOGIN</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

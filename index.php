<?php
session_start();  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/img/bcp logo.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clinic Management System.">
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
        <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red;">
                <?= htmlspecialchars($error) ?> 
            </div>
        <?php endif; ?>
        <form id="loginForm" action="login.php" method="post">
            <label for="accountId">Account ID</label>
            <input type="text" id="accountId" name="accountId" required aria-label="Account ID">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required aria-label="Password">

            <div class="forgot-password">
                <a href="#" aria-label="Forgot password?">Forgot your password?</a>
            </div>

            <button type="submit">LOGIN</button>
        </form>
        <script src="js/script.js"></script>
    </div>
</body>
</html>

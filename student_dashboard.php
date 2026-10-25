<?php
session_start();

// Check if logged in AND if the role is strictly 'student'
if (!isset($_SESSION["userid"]) || $_SESSION["role"] !== "student") {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, Student <?php echo htmlspecialchars($_SESSION["fname"]); ?>!</h1>
        <form class="logout-form" method="POST">
            <button type="submit" name="logout" class="logout-btn">Log Out</button>
        </form>
    </div>
</body>
</html>
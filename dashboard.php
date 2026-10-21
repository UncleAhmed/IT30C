
<?php
session_start();

if (!isset($_SESSION["userid"])) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <div class="dashboard">

        <form class="logout-form" method="POST">
            <button type="submit" name="logout" class="logout-btn">
                Log Out
            </button>
        </form>

    </div>

</body>
</html>

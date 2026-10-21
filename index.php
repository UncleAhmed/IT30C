
<?php
session_start();
require_once "db.php";

$message = "";
$messageType = "";

if (isset($_SESSION["userid"])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $username = trim($_POST["user"] ?? "");
    $password = $_POST["pass"] ?? "";

    if ($username === "" || $password === "") {
        $message = "Please enter your username and password.";
        $messageType = "error";
    } else {
        $stmt = $conn->prepare(
            "SELECT userid, username, password, fname, lname
             FROM users
             WHERE username = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result(
                $userid,
                $dbUsername,
                $hashedPassword,
                $fname,
                $lname
            );

            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                session_regenerate_id(true);

                $_SESSION["userid"] = $userid;
                $_SESSION["username"] = $dbUsername;
                $_SESSION["fname"] = $fname;
                $_SESSION["lname"] = $lname;

                header("Location: dashboard.php");
                exit;
            }
        }

        $message = "Invalid username or password.";
        $messageType = "error";

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Web - Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div id="form">
        <h1>Login Form</h1>

        <?php if ($message !== ""): ?>
            <p class="message <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form name="form" method="POST" action="index.php">
            <label>Username:</label>
            <input type="text" id="user" name="user"
                   maxlength="100" required>

            <label>Password:</label>
            <input type="password" id="pass" name="pass"
                   required>

            <input type="submit" id="btn"
                   value="Login" name="submit">
        </form>

        <p class="register-link">
            Way account?
            <a href="register.php">Dari Paghimo boi!</a>
        </p>
    </div>

</body>
</html>

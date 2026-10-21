
<?php
require_once "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = trim($_POST["fname"] ?? "");
    $mname = trim($_POST["mname"] ?? "");
    $lname = trim($_POST["lname"] ?? "");
    $username = trim($_POST["user"] ?? "");
    $password = $_POST["pass"] ?? "";
    $confirmPassword = $_POST["confirm_pass"] ?? "";

    if (
        $fname === "" ||
        $lname === "" ||
        $username === "" ||
        $password === "" ||
        $confirmPassword === ""
    ) {
        $message = "Please fill in all required fields.";
        $messageType = "error";

    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match!";
        $messageType = "error";

    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
        $messageType = "error";

    } else {
    
        $check = $conn->prepare(
            "SELECT userid FROM users WHERE username = ?"
        );

        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Username already exists!";
            $messageType = "error";
        } else {
            
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

           
            $stmt = $conn->prepare(
                "INSERT INTO users
                    (username, password, fname, lname, mname)
                 VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssss",
                $username,
                $hashedPassword,
                $fname,
                $lname,
                $mname
            );

            if ($stmt->execute()) {
                $message = "Account created! You can now log in.";
                $messageType = "success";
            } else {
                $message = "Registration failed. Please try again.";
                $messageType = "error";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Library Registration</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

    <div id="form">
        <h1>Register</h1>

        <?php if ($message !== ""): ?>
            <p class="message <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label>First Name:</label>
            <input type="text" name="fname"
                   maxlength="100" required>

            <label>Middle Name (Optional):</label>
            <input type="text" name="mname"
                   maxlength="100">

            <label>Last Name:</label>
            <input type="text" name="lname"
                   maxlength="100" required>

            <label>Username:</label>
            <input type="text" name="user"
                   maxlength="100" required>

            <label>Password:</label>
            <input type="password" name="pass"
                   minlength="8" required>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_pass"
                   minlength="8" required>

            <input type="submit" id="btn"
                   value="Create Account">
        </form>

        <p class="login-link">
            Naa nay account?
            <a href="index.php">Balik sa Login, boi!</a>
        </p>
    </div>

</body>
</html>

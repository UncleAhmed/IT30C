

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

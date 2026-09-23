<?php

session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, username, password FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $username
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: index.php");
        exit();

    } else {

        $message = "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

</head>

<body>

<h1>Library Management System</h1>

<h2>Login</h2>

<?php echo htmlspecialchars($message); ?>

<form method="POST">

    <label>Username:</label><br>
    <input type="text" name="username" required>

    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>
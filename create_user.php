<?php

include "db.php";

$username = "admin";
$password = "admin123";

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO users (username, password) VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $username,
    $hashed_password
);

if (mysqli_stmt_execute($stmt)) {

    echo "User created successfully.";

} else {

    echo "Error: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);

?>
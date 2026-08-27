<?php

include "db.php";

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    if (empty($name) || empty($email) || empty($phone)) {

        echo "Please fill in all fields.";

    } else {

        $sql = "INSERT INTO members (name, email, phone)
                VALUES ('$name', '$email', '$phone')";

        if (mysqli_query($conn, $sql)) {
            echo "Member added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
</head>

<body>

<h2>Add Member</h2>

<form method="POST">

    Name:
    <input type="text" name="name">
    <br><br>

    Email:
    <input type="email" name="email">
    <br><br>

    Phone:
    <input type="text" name="phone">
    <br><br>

    <button type="submit" name="submit">Add Member</button>

</form>

</body>
</html> 
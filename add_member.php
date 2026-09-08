```php
<?php

include "db.php";

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    if (empty($name) || empty($email) || empty($phone)) {

        echo "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "Please enter a valid email address.";

    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {

        echo "Phone number must contain exactly 10 digits.";

    } else {

        /* Check if email already exists */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id FROM members WHERE email = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($result) > 0) {

            echo "A member with this email already exists.";

        } else {

            /* Add new member */

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO members (name, email, phone)
                 VALUES (?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $name,
                $email,
                $phone
            );

            if (mysqli_stmt_execute($stmt)) {

                echo "Member added successfully!";

            } else {

                echo "Error: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
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

    <button type="submit" name="submit">
        Add Member
    </button>

</form>

</body>

</html>
```

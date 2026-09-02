```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Member ID not found.");
}

$id = $_GET["id"];

/* Get member details */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM members WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$member = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$member) {
    die("Member not found.");
}


/* Update member */

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

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE members
             SET name = ?,
                 email = ?,
                 phone = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $name,
            $email,
            $phone,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: members.php");
            exit();

        } else {

            echo "Error: " . mysqli_stmt_error($stmt);

            mysqli_stmt_close($stmt);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Update Member</title>

</head>

<body>

<h2>Update Member</h2>

<form method="POST">

    Name:
    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($member["name"]); ?>"
    >

    <br><br>

    Email:
    <input
        type="email"
        name="email"
        value="<?php echo htmlspecialchars($member["email"]); ?>"
    >

    <br><br>

    Phone:
    <input
        type="text"
        name="phone"
        value="<?php echo htmlspecialchars($member["phone"]); ?>"
    >

    <br><br>

    <button type="submit" name="submit">
        Update Member
    </button>

</form>

</body>

</html>
```

```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Member ID not found.");
}

$id = $_GET["id"];

$result = mysqli_query($conn, "SELECT * FROM members WHERE id = $id");

$member = mysqli_fetch_assoc($result);

if (!$member) {
    die("Member not found.");
}

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    if (empty($name) || empty($email) || empty($phone)) {

        echo "Please fill in all fields.";

    } else {

        $sql = "UPDATE members
                SET name = '$name',
                    email = '$email',
                    phone = '$phone'
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {

            echo "Member updated successfully!";

            header("Location: members.php");
            exit();

        } else {

            echo "Error: " . mysqli_error($conn);

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
    <input type="text" name="name"
           value="<?php echo $member["name"]; ?>">
    <br><br>

    Email:
    <input type="email" name="email"
           value="<?php echo $member["email"]; ?>">
    <br><br>

    Phone:
    <input type="text" name="phone"
           value="<?php echo $member["phone"]; ?>">
    <br><br>

    <button type="submit" name="submit">
        Update Member
    </button>

</form>

</body>

</html>
```

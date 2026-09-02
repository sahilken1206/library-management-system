```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Member ID not found.");
}

$id = $_GET["id"];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM members WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
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

?>
```

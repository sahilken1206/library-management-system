```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Loan ID not found.");
}

$id = $_GET["id"];

$sql = "UPDATE loans
        SET return_date = CURDATE()
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    header("Location: loans.php");
    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

?>
```

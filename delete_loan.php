```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Loan ID not found.");
}

$id = $_GET["id"];

$sql = "DELETE FROM loans WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    header("Location: loans.php");
    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

?>
```

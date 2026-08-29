```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Member ID not found.");
}

$id = $_GET["id"];

$sql = "DELETE FROM members WHERE id = $id";

if (mysqli_query($conn, $sql)) {

    echo "Member deleted successfully!";

    header("Location: members.php");
    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

?>
```

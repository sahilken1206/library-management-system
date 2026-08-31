```php
<?php

include "db.php";

if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM books WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Book deleted successfully!";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

?>

<form method="POST">

    Book ID:
    <input type="number" name="id">
    <br><br>

    <button type="submit" name="delete">Delete Book</button>

</form>
```

```php
<?php

include "db.php";

if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $quantity = $_POST["quantity"];

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE books SET quantity = ? WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $quantity,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Book updated successfully!";
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

    New Quantity:
    <input type="number" name="quantity">
    <br><br>

    <button type="submit" name="update">Update Book</button>

</form>
```

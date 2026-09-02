```php
<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Book ID not found.");
}

$id = $_GET["id"];

/* Get book details */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM books WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$book = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$book) {
    die("Book not found.");
}


/* Delete book */

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

    mysqli_stmt_close($stmt);

    header("Location: book.php");
    exit();

} else {

    echo "Error: " . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);
}

?>
```

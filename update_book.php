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


/* Update book */

if (isset($_POST["update"])) {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];

    if (
        empty($title) ||
        empty($author) ||
        empty($category) ||
        $quantity === ""
    ) {

        echo "Please fill in all fields.";

    } elseif (!is_numeric($quantity) || $quantity < 0) {

        echo "Quantity must be 0 or greater.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE books
             SET title = ?,
                 author = ?,
                 category = ?,
                 quantity = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssii",
            $title,
            $author,
            $category,
            $quantity,
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
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Update Book</title>

</head>

<body>

<h2>Update Book</h2>

<form method="POST">

    Title:
    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($book["title"]); ?>"
    >

    <br><br>

    Author:
    <input
        type="text"
        name="author"
        value="<?php echo htmlspecialchars($book["author"]); ?>"
    >

    <br><br>

    Category:
    <input
        type="text"
        name="category"
        value="<?php echo htmlspecialchars($book["category"]); ?>"
    >

    <br><br>

    Quantity:
    <input
        type="number"
        name="quantity"
        min="0"
        value="<?php echo htmlspecialchars($book["quantity"]); ?>"
    >

    <br><br>

    <button type="submit" name="update">
        Update Book
    </button>

</form>

</body>

</html>
```

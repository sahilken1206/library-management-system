```php
<?php

include "db.php";

if (isset($_POST["submit"])) {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];

    if (empty($title) || empty($author) || empty($category) || empty($quantity)) {

        echo "Please fill in all fields.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO books (title, author, category, quantity)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $title,
            $author,
            $category,
            $quantity
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "Book added successfully!";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Book</title>
</head>

<body>

<h2>Add a Book</h2>

<form method="POST">

    Title:
    <input type="text" name="title">
    <br><br>

    Author:
    <input type="text" name="author">
    <br><br>

    Category:
    <input type="text" name="category">
    <br><br>

    Quantity:
    <input type="number" name="quantity">
    <br><br>

    <button type="submit" name="submit">Add Book</button>

</form>

</body>

</html>
```

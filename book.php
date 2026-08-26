<?php

include "db.php";

$result = mysqli_query($conn, "SELECT * FROM books");

while ($book = mysqli_fetch_assoc($result)) {
    echo "Title: " . $book["title"] . "<br>";
    echo "Author: " . $book["author"] . "<br>";
    echo "Category: " . $book["category"] . "<br>";
    echo "Quantity: " . $book["quantity"] . "<br>";
    echo "<hr>";
}

?>
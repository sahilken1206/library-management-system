<?php

include "db.php";

if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    $sql = "DELETE FROM books WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Book deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<form method="POST">

    Book ID: <input type="number" name="id"><br><br>

    <button type="submit" name="delete">Delete Book</button>

</form>
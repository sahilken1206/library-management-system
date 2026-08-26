<?php

include "db.php";

if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $quantity = $_POST["quantity"];

    $sql = "UPDATE books SET quantity = '$quantity' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Book updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<form method="POST">

    Book ID: <input type="number" name="id"><br><br>

    New Quantity: <input type="number" name="quantity"><br><br>

    <button type="submit" name="update">Update Book</button>

</form>
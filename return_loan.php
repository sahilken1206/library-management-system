<?php

include "db.php";

if (!isset($_GET["id"])) {
    die("Loan ID not found.");
}

$id = $_GET["id"];

$stmt = mysqli_prepare(
    $conn,
    "UPDATE loans
     SET return_date = CURDATE()
     WHERE id = ?
     AND return_date IS NULL"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

if (mysqli_stmt_execute($stmt)) {

    if (mysqli_stmt_affected_rows($stmt) > 0) {

        mysqli_stmt_close($stmt);

        header("Location: loans.php");
        exit();

    } else {

        mysqli_stmt_close($stmt);

        echo "Loan is already returned or does not exist.";
    }

} else {

    echo "Error: " . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);
}

?>
<?php

include "auth.php";
include "db.php";

if (!isset($_GET["id"])) {
    die("Member ID not found.");
}

$id = $_GET["id"];

/* Check if member has any loan history */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id FROM loans WHERE member_id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

mysqli_stmt_close($stmt);

if (mysqli_num_rows($result) > 0) {

    die("Cannot delete this member because loan history exists for this member.");

}

/* Delete member */

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM members WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: members.php");
    exit();

} else {

    echo "Error: " . mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);
}

?>
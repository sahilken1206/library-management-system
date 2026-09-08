<?php

include "db.php";

if (isset($_POST["submit"])) {

    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $loan_date = $_POST["loan_date"];
    $due_date = $_POST["due_date"];

    if (
        empty($book_id) ||
        empty($member_id) ||
        empty($loan_date) ||
        empty($due_date)
    ) {

        echo "Please fill in all fields.";

    } else {

        /* Check if book exists */

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id FROM books WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $book_id
        );

        mysqli_stmt_execute($stmt);

        $book_result = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($book_result) == 0) {

            echo "Book not found.";

        } else {

            /* Check if member exists */

            $stmt = mysqli_prepare(
                $conn,
                "SELECT id FROM members WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $member_id
            );

            mysqli_stmt_execute($stmt);

            $member_result = mysqli_stmt_get_result($stmt);

            mysqli_stmt_close($stmt);

            if (mysqli_num_rows($member_result) == 0) {

                echo "Member not found.";

            } else {

                /* Create loan */

                $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO loans
                    (book_id, member_id, loan_date, due_date)
                    VALUES (?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "iiss",
                    $book_id,
                    $member_id,
                    $loan_date,
                    $due_date
                );

                if (mysqli_stmt_execute($stmt)) {

                    echo "Loan created successfully!";

                } else {

                    echo "Error: " . mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Loan</title>

</head>

<body>

<h2>Create Loan</h2>

<form method="POST">

    Book ID:
    <input type="number" name="book_id">
    <br><br>

    Member ID:
    <input type="number" name="member_id">
    <br><br>

    Loan Date:
    <input type="date" name="loan_date">
    <br><br>

    Due Date:
    <input type="date" name="due_date">
    <br><br>

    <button type="submit" name="submit">
        Create Loan
    </button>

</form>

</body>

</html>
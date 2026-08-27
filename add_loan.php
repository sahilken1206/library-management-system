<?php

include "db.php";

if (isset($_POST["submit"])) {

    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $loan_date = $_POST["loan_date"];

    if (empty($book_id) || empty($member_id) || empty($loan_date)) {

        echo "Please fill in all fields.";

    } else {

        $sql = "INSERT INTO loans (book_id, member_id, loan_date)
                VALUES ('$book_id', '$member_id', '$loan_date')";

        if (mysqli_query($conn, $sql)) {
            echo "Loan created successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
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

    <button type="submit" name="submit">Create Loan</button>

</form>

</body>
</html> 
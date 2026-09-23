<?php

include "auth.php";
include "db.php";

if (!isset($_GET["id"])) {
    die("Loan ID not found.");
}

$id = $_GET["id"];

/* Get loan details */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM loans WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$loan = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$loan) {
    die("Loan not found.");
}


/* Update loan */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $loan_date = $_POST["loan_date"];
    $due_date = $_POST["due_date"];

    if ($due_date < $loan_date) {
        die("Due date cannot be before loan date.");
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE loans
         SET book_id = ?, member_id = ?, loan_date = ?, due_date = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iissi",
        $book_id,
        $member_id,
        $loan_date,
        $due_date,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: loans.php");
        exit();

    } else {

        echo "Error: " . mysqli_stmt_error($stmt);

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Loan</title>

</head>

<body>

<h1>Edit Loan</h1>

<form method="POST">

    <label>Book ID:</label><br>
    <input
        type="number"
        name="book_id"
        value="<?php echo htmlspecialchars($loan["book_id"]); ?>"
        required
    >

    <br><br>

    <label>Member ID:</label><br>
    <input
        type="number"
        name="member_id"
        value="<?php echo htmlspecialchars($loan["member_id"]); ?>"
        required
    >

    <br><br>

    <label>Loan Date:</label><br>
    <input
        type="date"
        name="loan_date"
        value="<?php echo htmlspecialchars($loan["loan_date"]); ?>"
        required
    >

    <br><br>

    <label>Due Date:</label><br>
    <input
        type="date"
        name="due_date"
        value="<?php echo htmlspecialchars($loan["due_date"]); ?>"
        required
    >

    <br><br>

    <button type="submit">Update Loan</button>

</form>

<br>

<a href="loans.php">Back to Loans</a>

</body>
</html>